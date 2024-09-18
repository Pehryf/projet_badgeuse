#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10    // SDA sur la broche D10
#define RST_PIN 9    // RST sur la broche D9
MFRC522 rfid(SS_PIN, RST_PIN);  // Créer une instance du lecteur RFID

void setup() {
  Serial.begin(9600);  // Démarrer la communication série
  SPI.begin();         // Initialiser le bus SPI
  rfid.PCD_Init();     // Initialiser le module RFID

  Serial.println("Scan a RFID/NFC tag");
}

void loop() {
  // Vérifier si une carte est présente
  if (!rfid.PICC_IsNewCardPresent()) {
    return;
  }

  // Lire la carte
  if (!rfid.PICC_ReadCardSerial()) {
    return;
  }

  // Afficher l'UID de la carte
  Serial.print("UID tag : ");
  for (byte i = 0; i < rfid.uid.size; i++) {
    Serial.print(rfid.uid.uidByte[i] < 0x10 ? " 0" : " ");
    Serial.print(rfid.uid.uidByte[i], HEX);
  }
  Serial.println();

  rfid.PICC_HaltA();  // Arrêter la lecture de la carte
}
