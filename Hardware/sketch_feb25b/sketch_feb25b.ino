// reading the value 
// #include <SPI.h>
// #include <MFRC522.h>

// #define SS_PIN 10
// #define RST_PIN 9
 
// MFRC522 rfid(SS_PIN, RST_PIN); // Create instance

// void setup() {
//   Serial.begin(9600);
//   SPI.begin();      // Init SPI bus
//   rfid.PCD_Init();  // Init MFRC522
//   Serial.println("Scan an RFID tag...");
// }

// void loop() {
//   // Look for new cards
//   if ( ! rfid.PICC_IsNewCardPresent()) return;

//   // Select one of the cards
//   if ( ! rfid.PICC_ReadCardSerial()) return;

//   // Show UID on serial monitor
//   Serial.print("Tag UID:");
//   for (byte i = 0; i < rfid.uid.size; i++) {
//     Serial.print(rfid.uid.uidByte[i] < 0x10 ? " 0" : " ");
//     Serial.print(rfid.uid.uidByte[i], HEX);
//   }
//   Serial.println();

//   rfid.PICC_HaltA(); // Stop reading
// }

// // writing the value 
// #include <SPI.h>
// #include <MFRC522.h>

// #define SS_PIN 10
// #define RST_PIN 9
// MFRC522 mfrc522(SS_PIN, RST_PIN);

// // Use the default key (FFFFFFFFFFFF) to access the card
// MFRC522::MIFARE_Key key;

// void setup() {
//   Serial.begin(9600);
//   SPI.begin();
//   mfrc522.PCD_Init();
  
//   // Prepare the security key (standard for new cards)
//   for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;
  
//   Serial.println("Ready to WRITE. Scan card now...");
// }

// void loop() {
//   if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) return;

//   byte block = 4; // We will write to Block 4
//   byte dataBlock[] = {
//     'G', 'e', 'm', 'i', 'n', 'i', ' ', 'A', 'I', ' ', ' ', ' ', ' ', ' ', ' ', ' '
//   }; // Must be exactly 16 bytes

//   // 1. Authenticate with the card
//   MFRC522::StatusCode status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, block, &key, &(mfrc522.uid));
//   if (status != MFRC522::STATUS_OK) {
//     Serial.print("Auth failed: "); Serial.println(mfrc522.GetStatusCodeName(status));
//     return;
//   }

//   // 2. Write the data
//   status = mfrc522.MIFARE_Write(block, dataBlock, 16);
//   if (status == MFRC522::STATUS_OK) {
//     Serial.println("✅ Data written successfully!");
//   } else {
//     Serial.print("❌ Write failed: "); Serial.println(mfrc522.GetStatusCodeName(status));
//   }

//   mfrc522.PICC_HaltA();
//   mfrc522.PCD_StopCrypto1();
// }

// read the data 
// #include <SPI.h>
// #include <MFRC522.h>

// #define SS_PIN 10
// #define RST_PIN 9
// MFRC522 mfrc522(SS_PIN, RST_PIN);

// MFRC522::MIFARE_Key key;

// void setup() {
//   Serial.begin(9600);
//   SPI.begin();
//   mfrc522.PCD_Init();

//   // Use the same default key (FFFFFFFFFFFF) used during the write process
//   for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;
  
//   Serial.println("Ready to READ. Scan your card...");
// }

// void loop() {
//   // Look for new cards
//   if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) return;

//   byte block = 4; // The block we want to read
//   byte buffer[18]; // Buffer to store the read data (16 bytes + 2 bytes for CRC)
//   byte size = sizeof(buffer);

//   // 1. Authenticate
//   MFRC522::StatusCode status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, block, &key, &(mfrc522.uid));
//   if (status != MFRC522::STATUS_OK) {
//     Serial.print("Auth failed: "); Serial.println(mfrc522.GetStatusCodeName(status));
//     return;
//   }

//   // 2. Read the Block
//   status = mfrc522.MIFARE_Read(block, buffer, &size);
//   if (status == MFRC522::STATUS_OK) {
//     Serial.print("Data in Block "); Serial.print(block); Serial.print(": ");
    
//     // Print the data as characters (to see the text we wrote)
//     for (byte i = 0; i < 16; i++) {
//       Serial.write(buffer[i]);
//     }
//     Serial.println();
//   } else {
//     Serial.print("Read failed: "); Serial.println(mfrc522.GetStatusCodeName(status));
//   }

//   mfrc522.PICC_HaltA();
//   mfrc522.PCD_StopCrypto1();
// }


// code to send the data 
// #include <SPI.h>
// #include <MFRC522.h>

// #define SS_PIN 10
// #define RST_PIN 9
// MFRC522 rfid(SS_PIN, RST_PIN);

// // --- CONFIGURATION ---
// String MERCHANT_ID = "MCH-8829-X"; 
// String LOCATION = "Main Entrance"; // Hardcoded location

// void setup() {
//   Serial.begin(9600);
//   SPI.begin();
//   rfid.PCD_Init();
// }

// void loop() {
//   // Reset the loop if no new card present on the sensor/reader.
//   if (!rfid.PICC_IsNewCardPresent() || !rfid.PICC_ReadCardSerial()) return;

//   // 1. Get the NFC/Tag ID
//   String nfcID = "";
//   for (byte i = 0; i < rfid.uid.size; i++) {
//     nfcID += String(rfid.uid.uidByte[i], HEX);
//   }
//   nfcID.toUpperCase();

//   // 2. Send as JSON string to Serial
//   // Final Format: {"merchant_id": "MCH-8829-X", "nfc_id": "A1B2C3D4", "location": "Main Entrance"}
//   Serial.print("{\"merchant_id\": \"");
//   Serial.print(MERCHANT_ID);
//   Serial.print("\", \"nfc_id\": \"");
//   Serial.print(nfcID);
//   Serial.print("\", \"location\": \"");
//   Serial.print(LOCATION);
//   Serial.println("\"}");

//   delay(2000); // Wait 2 seconds to avoid double-logging
//   rfid.PICC_HaltA();
// }

// with buger and led 
#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10
#define RST_PIN 9
#define BUZZER_PIN 8  // Connect Buzzer (+) to Pin 8
#define LED_PIN 7     // Connect your working LED (+) to Pin 7

MFRC522 rfid(SS_PIN, RST_PIN);

// --- CONFIGURATION ---
String MERCHANT_ID = "MCH-8829-X"; 
String LOCATION = "Main Entrance";

void setup() {
  Serial.begin(9600);
  SPI.begin();
  rfid.PCD_Init();

  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(LED_PIN, OUTPUT);
  
  // Quick startup signal to show it's ready
  digitalWrite(LED_PIN, HIGH);
  delay(200);
  digitalWrite(LED_PIN, LOW);
}

void loop() {
  // Reset the loop if no new card present on the sensor/reader.
  if (!rfid.PICC_IsNewCardPresent() || !rfid.PICC_ReadCardSerial()) return;

  // 1. Physical Feedback (ATM Style)
  // Short sharp beep and flash happens immediately on scan
  digitalWrite(BUZZER_PIN, HIGH);
  digitalWrite(LED_PIN, HIGH);
  delay(150); // The "Bip" duration
  digitalWrite(BUZZER_PIN, LOW);
  digitalWrite(LED_PIN, LOW);

  // 2. Get the NFC/Tag ID
  String nfcID = "";
  for (byte i = 0; i < rfid.uid.size; i++) {
    nfcID += String(rfid.uid.uidByte[i], HEX);
  }
  nfcID.toUpperCase();

  // 3. Send as JSON string to Serial
  Serial.print("{\"merchant_id\": \"");
  Serial.print(MERCHANT_ID);
  Serial.print("\", \"nfc_id\": \"");
  Serial.print(nfcID);
  Serial.print("\", \"location\": \"");
  Serial.print(LOCATION);
  Serial.println("\"}");

  // Halt communication
  delay(1500); 
  rfid.PICC_HaltA();
}