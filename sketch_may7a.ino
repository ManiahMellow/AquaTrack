#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <OneWire.h>
#include <DallasTemperature.h>

#define ONE_WIRE_BUS 13
#define BUZZER_PIN 27

OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

const char* ssid = "low's";
const char* password = "ellowjbr";

const int ph_Pin = 35;
float Po = 0;
float PH_step;
int nilai_analog_PH;
float TeganganPh;
float PH4 = 3.1;
float PH7 = 2.6;

// Function prototypes
void sendToServer(String serverUrl, float Po, float temperatureC);
void checkOptimalConditions(String serverUrl);
void activateBuzzer();
void deactivateBuzzer();

void setup() {
  pinMode(ph_Pin, INPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW);

  Serial.begin(9600);
  sensors.begin();

  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    nilai_analog_PH = analogRead(ph_Pin);
    TeganganPh = (3.3 / 4095) * nilai_analog_PH;
    PH_step = (PH4 - PH7) / 3;
    Po = 4.7 + ((PH7 - TeganganPh) / PH_step); 
    float temperatureC = getTemperature();

    // Send data to server
    String storeUrl = "http:/192.168.56.1:8000/arduino/store/";
    String checkOptimalUrl = "http://192.168.56.1:8000/arduino/checkOptimalConditions/";

    sendToServer(storeUrl, Po, temperatureC);
    checkOptimalConditions(checkOptimalUrl);
  } else {
    Serial.println("WiFi not connected");
  }

  delay(5000);
}

float getTemperature() {
  sensors.requestTemperatures();
  float temperatureC = sensors.getTempCByIndex(0);
  return temperatureC;
}

void sendToServer(String serverUrl, float Po, float temperatureC) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverUrl);
    http.addHeader("Content-Type", "application/json");

    StaticJsonDocument<200> jsonDoc;
    jsonDoc["pH"] = Po;
    jsonDoc["suhu"] = temperatureC;

    String jsonString;
    serializeJson(jsonDoc, jsonString);

    int httpResponseCode = http.POST(jsonString);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server response: " + response);
    } else {
      Serial.printf("Error sending request, HTTP response code: %d\n", httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi not connected");
  }
}

void checkOptimalConditions(String serverUrl) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverUrl);
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server response: " + response);

      DynamicJsonDocument doc(1024);
      deserializeJson(doc, response);

      int pH_status = doc["pH_status"];
      int suhu_status = doc["suhu_status"];

      if (pH_status == 1 || suhu_status == 1) {
        activateBuzzer();
      } else {
        deactivateBuzzer();
      }
    } else {
      Serial.printf("Error sending request, HTTP response code: %d\n", httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi not connected");
  }
}

void activateBuzzer() {
  digitalWrite(BUZZER_PIN, HIGH);
  delay(1000);
  digitalWrite(BUZZER_PIN, LOW);
}

void deactivateBuzzer() {
  digitalWrite(BUZZER_PIN, LOW);
}
