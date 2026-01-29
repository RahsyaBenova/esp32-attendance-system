# IoT RFID Attendance System using ESP32, MFRC522, and XAMPP

A real-time attendance logging system that scans RFID tags using an ESP32 and sends the data wirelessly to a local PHP/MySQL server (XAMPP). The data is displayed instantly on a web dashboard.

## 📋 Features
* **Wireless Communication:** ESP32 sends data via HTTP POST over Wi-Fi.
* **Real-time Logging:** Scans are recorded in the MySQL database instantly.
* **Live Dashboard:** Auto-refreshing web page to monitor incoming scans.
* **Duplicate Handling:** Logs every scan with a precise timestamp.

## 🛠️ Hardware Requirements
1.  **ESP32 Development Board** (e.g., ESP32 DOIT DEVKIT V1)
2.  **MFRC522 RFID Module** (RC522)
3.  **RFID Tags/Cards** (13.56 MHz)
4.  **Jumper Wires** (Female-to-Male)
5.  **Micro USB Cable** (for programming and power)

## 💻 Software Requirements
1.  **Arduino IDE** (with ESP32 board manager installed).
2.  **XAMPP** (Apache Web Server + MySQL Database).
3.  **Web Browser** (Chrome, Firefox, etc.).

---

## 🔌 Circuit Diagram & Wiring

Connect the MFRC522 Reader to the ESP32 as follows.
**⚠️ IMPORTANT:** Connect the MFRC522 to **3.3V**. Connecting to 5V will damage the module.

| MFRC522 Pin | ESP32 Pin | Function |
| :--- | :--- | :--- |
| **SDA (SS)** | GPIO 5 | Chip Select |
| **SCK** | GPIO 18 | Clock |
| **MOSI** | GPIO 23 | Master Out Slave In |
| **MISO** | GPIO 19 | Master In Slave Out |
| **IRQ** | *Not Connected* | Interrupt |
| **GND** | GND | Ground |
| **RST** | GPIO 22 | Reset |
| **3.3V** | 3.3V | Power |

---

## 🚀 Installation Guide

### Step 1: Database Setup (XAMPP)
1.  Open **XAMPP Control Panel** and start **Apache** and **MySQL**.
2.  Navigate to `http://localhost/phpmyadmin/`.
3.  Create a new database named: `esp32_attendance`.
4.  Run the following SQL command in the **SQL** tab:

```sql
CREATE TABLE attendance_logs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    rfid_uid VARCHAR(30) NOT NULL,
    device_name VARCHAR(30) NOT NULL,
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);