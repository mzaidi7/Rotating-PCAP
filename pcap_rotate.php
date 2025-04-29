<?php
set_time_limit(0); // Prevents timeout issues
ini_set('memory_limit', '-1');
date_default_timezone_set('Asia/Kuala_Lumpur'); // Change to your timezone
$logFile = "/var/tmp/tcpdump_log.txt"; // Log file
$basePath = "/var/tmp/";
$file1 = $basePath . "capture1.pcap";
$file2 = $basePath . "capture2.pcap";
$interface = "any"; // Change to your network interface (e.g., eth0, ens33)
$rotationTime = 3600; // 1 hour

while (true) {
    // Log start
    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] Rotating capture files...\n", FILE_APPEND);

    // Rotate files: Move file2 -> file1 before capturing new
    if (file_exists($file2)) {
        rename($file2, $file1);
        file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] Moved $file2 -> $file1\n", FILE_APPEND);
    }

    // Start tcpdump into file2
    $command = "tcpdump -i $interface -s 0 -w $file2 > /dev/null 2>&1 & echo $!";
    $pid = trim(shell_exec($command)); // Get process ID of tcpdump

    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] TCPDump started with PID: $pid, capturing to $file2\n", FILE_APPEND);

    // Wait 1 hour before stopping tcpdump
    sleep($rotationTime);

    // Stop tcpdump
    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] Stopping tcpdump PID: $pid\n", FILE_APPEND);
    shell_exec("kill -9 $pid"); // Forcefully kill tcpdump process

    sleep(2); // Small delay before restarting
}
?>
