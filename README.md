---

## 📄 PHP TCPDump Capture Rotator

This script automates the rotation of `tcpdump` packet captures using PHP. It runs indefinitely, rotating the capture file every hour.

### 🔧 Requirements

- Linux/Unix environment
- `tcpdump` installed and accessible in system path
- PHP CLI (Command Line Interface)
- Root privileges (required for capturing with `tcpdump` on interfaces)

### 📁 Files & Paths

- **Log file**: `/var/tmp/tcpdump_log.txt`
- **Capture files**:
  - Latest: `/var/tmp/capture2.pcap`
  - Previous: `/var/tmp/capture1.pcap`

### ⚙️ Configuration

Modify the following variables in the script as needed:

- `$interface`: Your network interface (e.g., `eth0`, `ens33`, `lo`, `any`)
- `$rotationTime`: Time in seconds before rotation (`3600` = 1 hour)
- `date_default_timezone_set`: Set your correct timezone (e.g., `Asia/Kuala_Lumpur`)

### 🚀 How It Works

1. The script sets unlimited time and memory usage to avoid limits.
2. Every hour:
   - Moves the previous capture file (`capture2.pcap`) to `capture1.pcap`.
   - Starts a new `tcpdump` process writing to `capture2.pcap`.
   - Logs all actions to `tcpdump_log.txt`.
   - Kills the running `tcpdump` process after 1 hour.

### 🛠️ Usage

```bash
php /path/to/your/script.php
```

Run as root or with `sudo`:

```bash
sudo php /path/to/your/script.php
```

### 📝 Notes

- Ensure `/var/tmp/` has sufficient space for storing `.pcap` files.
- This script runs indefinitely. Use a process manager or manually stop it when needed.
- You may use `crontab`, `supervisord`, or `systemd` to keep it running in the background.
