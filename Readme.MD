# Smart RFID Attendance System (In/Out Logic + Web Dashboard)

An advanced IoT attendance system using ESP32 and MFRC522. It features an intelligent **In/Out toggle logic**, a **real-time web dashboard**, and a **user-friendly registration page** that auto-detects new cards without reloading the page.

## 🌟 Features
* **Auto In/Out Logic:** Automatically detects if a user is clocking IN or OUT based on their last activity.
* **Smart Registration:** "Scan to Register" feature using AJAX (no page refresh needed while typing names).
* **Real-Time Dashboard:** Live table showing User Name, UID, Status (IN/OUT), and Timestamp.
* **Unknown Card Detection:** Unregistered cards are sent to a "temporary holding" queue for easy registration.

## 🛠️ Hardware Requirements
1.  **ESP32 Development Board** (e.g., DOIT DEVKIT V1)
2.  **MFRC522 RFID Module** (RC522)
3.  **RFID Tags/Cards** (13.56 MHz)
4.  **Jumper Wires** & **Micro USB Cable**

## 🔌 Wiring Diagram
*Connect MFRC522 to ESP32 (3.3V Logic Only)*

| MFRC522 Pin | ESP32 Pin | Function |
| :--- | :--- | :--- |
| **SDA (SS)** | GPIO 5 | Chip Select |
| **SCK** | GPIO 18 | SPI Clock |
| **MOSI** | GPIO 23 | Master Out Slave In |
| **MISO** | GPIO 19 | Master In Slave Out |
| **GND** | GND | Ground |
| **RST** | GPIO 22 | Reset |
| **3.3V** | 3.3V | **Power (Do NOT use 5V)** |

---

## 🚀 Installation Guide

### Step 1: Database Setup (XAMPP)
1.  Open **XAMPP Control Panel** -> Start **Apache** & **MySQL**.
2.  Go to `http://localhost/phpmyadmin/`.
3.  Create a database named: `esp32_attendance`.
4.  Run the following SQL in the **SQL** tab to create the 3 required tables:

```sql
-- 1. Users Table (Stores Name & UID)
CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    serialnumber VARCHAR(50) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Attendance Table (Stores Logs)
CREATE TABLE attendance (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) NOT NULL,
    status VARCHAR(10) NOT NULL, -- 'IN' or 'OUT'
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Temp Table (For Registration Queue)
CREATE TABLE temp_card (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uid VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Initialize Temp Table
INSERT INTO temp_card (uid) VALUES ('Wait for scan...');

```

### Step 2: Web Server Setup (PHP)

1. Go to `C:\xampp\htdocs\` and create a folder named `attendance`.
2. Create the following **6 files** inside that folder:

| File Name | Description |
| --- | --- |
| `db.php` | Database connection settings. |
| `api.php` | **The Brain.** Receives ESP32 data, decides if it's Login or Register. |
| `get_uid.php` | Fetches the latest UID for the registration page (AJAX). |
| `register.php` | The Registration UI (uses jQuery for auto-refresh). |
| `insert_user.php` | Saves the new user to the database. |
| `index.php` | The main Dashboard showing In/Out history. |

### Step 3: ESP32 Firmware (Arduino IDE)

1. Install **MFRC522** library by *GithubCommunity*.
2. Open the code and configure your network:

```cpp
const char* ssid = "YOUR_WIFI_NAME";
const char* password = "YOUR_WIFI_PASS";

// Point to the 'api.php' file
const char* serverName = "[http://192.168.1.](http://192.168.1.)X/attendance/api.php"; 

```

3. Upload the code.

---

## 🎮 How to Use

### A. Registering a New User

1. Open your browser to: `http://localhost/attendance/register.php`
2. Enter the user's **Name** and **Gender**.
3. **Scan the new RFID Card.**
4. The UID box will **automatically fill** (within 1 second) without refreshing the page.
5. Click **Save User**.

### B. Daily Attendance

1. Open the Dashboard: `http://localhost/attendance/index.php`
2. **Scan the card.**
* **First Scan:** System logs **"IN"**.
* **Second Scan:** System logs **"OUT"**.


3. The dashboard updates automatically to show the status.

---

## ❓ Troubleshooting

**Q: The registration page doesn't update when I scan.**

* Ensure the ESP32 is connected to WiFi (Check Serial Monitor).
* Ensure the ESP32 is pointing to `api.php` correctly.
* Check if `get_uid.php` returns a value when opened manually in the browser.

**Q: I get "Connection Failed" errors.**

* Check `db.php`. Password for XAMPP is usually empty `""`.
* Ensure your firewall allows incoming connections on Port 80.

**Q: ESP32 connects but nothing happens.**

* The ESP32 must be on the **same Wi-Fi network** as the computer running XAMPP.
* Use the computer's **IPv4 Address** (e.g., `192.168.1.5`), NOT `localhost`.

---

## 📄 License

Open Source. Happy Coding!

```

```