#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>
#include <HTTPClient.h>

// --- Config ---
// make sure you have same SSID and Password with the laptop wifi
const char* ssid = "OrangGantengPekanbaru";
const char* password = "12345678";

// REPLACE with your computer's IP address, buka wifi -> nama wifi -> info -> IPv4
const char* serverName = "http://[{YOUR_IP_ADDRESS}]/attendance/api.php";

// --- RFID Pins ---
#define SS_PIN  5
#define RST_PIN 22

MFRC522 rfid(SS_PIN, RST_PIN);

void setup() {
  Serial.begin(115200);
  
  // Init WiFi
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConnected to WiFi");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // Init SPI and MFRC522
  SPI.begin();
  rfid.PCD_Init();
  Serial.println("Place RFID card near the reader...");
}

void loop() {
  // Check for new cards
  if (!rfid.PICC_IsNewCardPresent()) return;
  if (!rfid.PICC_ReadCardSerial()) return;

  // Read UID
  String uidString = "";
  for (byte i = 0; i < rfid.uid.size; i++) {
    if (rfid.uid.uidByte[i] < 0x10) uidString += "0"; // Add leading zero
    uidString += String(rfid.uid.uidByte[i], HEX);
  }
  uidString.toUpperCase();

  Serial.print("Card Detected! UID: ");
  Serial.println(uidString);

  // Send data to Server
  if(WiFi.status() == WL_CONNECTED){
    HTTPClient http;
    http.begin(serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare Data
    String httpRequestData = "rfid_uid=" + uidString + "&device_name=Gate_1";
    
    // Send POST Request
    int httpResponseCode = http.POST(httpRequestData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server Response: " + response);
    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }

  // Halt PICC
  rfid.PICC_HaltA();
  rfid.PCD_StopCrypto1();
  delay(1000); // Wait a bit before next read
}