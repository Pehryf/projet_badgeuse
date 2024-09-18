  #include <WiFiNINA.h>

// Replace these with your network credentials
const char* ssid     = "Projet.IR6*";
const char* password = "Projet.IR6*";

void setup() {
  Serial.begin(9600);

  // Check for the WiFi module
  if (WiFi.status() == WL_NO_MODULE) {
    Serial.println("WiFi module not found");
    while (true);
  }

  // Attempt to connect to Wi-Fi network
  Serial.print("Connecting to ");
  Serial.println(ssid);

  while (WiFi.begin(ssid, password) != WL_CONNECTED) {
    // Wait 1 second and retry
    delay(1000);
    Serial.print(".");
  }

  // When connected, print the IP address
  Serial.println("");
  Serial.println("Connected to Wi-Fi!");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  // Add your loop code here
}
