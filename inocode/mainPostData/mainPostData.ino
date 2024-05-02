#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include "DHT.h"

#define DHTPIN D3
const int ledPin = D8;

#define DHTTYPE DHT11   // DHT 11
//#define DHTTYPE DHT22   // DHT 22
//#define DHTTYPE DHT21   // DHT 21

const char* ssid = "zorAA";
const char* password = "h4h4h1h1";

DHT dht(DHTPIN, DHTTYPE);



void ledTwinkle() {
  digitalWrite(ledPin, HIGH);
  delay(500);
  digitalWrite(ledPin, LOW);
  delay(500);
  digitalWrite(ledPin, HIGH);
  delay(500);
  digitalWrite(ledPin, LOW);
}

void setup() {
  pinMode(ledPin, OUTPUT);
  Serial.begin(115200);
  Serial.println(F("DHTxx test!"));
  dht.begin();
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  int i=0;
  while(WiFi.status() != WL_CONNECTED){ 
    Serial.print(".");
    delay(1000);     
  } 
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  delay(2000);
  digitalWrite(ledPin, HIGH);
}

void loop() {
  ledTwinkle();
  //double kelembaban = random(50.00, 150.00);
  //double suhu = random(25.00, 40.00);
  
  double hum = dht.readHumidity();
  double temp = dht.readTemperature();

  Serial.print(F("Temperature:"));
  Serial.print(temp);
  Serial.print(F("°C   Humidity:"));
  Serial.print(hum);
  Serial.println(F("%"));

  if ((WiFi.status() == WL_CONNECTED)) {
    WiFiClient client;
    HTTPClient http;
    
    StaticJsonDocument<200> doc;
    String url, nodemcuData; 
    
    // C:\...\...\(directory)\webapi\api\create.php
    url ="http://192.168.211.59/iot/webapi/api/create.php";
    
    doc["temp"] = String(temp);
    doc["hum"] = String(hum);

    http.begin(client,url);
    http.addHeader("Content-Type", "application/json");
    
    serializeJson(doc, nodemcuData);
    Serial.print("POST data >> ");
    Serial.println(nodemcuData); 
  
    int httpCode = http.POST(nodemcuData);//Send the request
    String payload;  
    if (httpCode > 0) { //Check the returning code   
        payload = http.getString();   //Get the request response payload
        payload.trim();
        if( payload.length() > 0 ){
           Serial.println(payload + "\n");
        }
    }
    
    http.end();   //Close connection
  }else{
    Serial.print("Not connected to wifi ");Serial.println(ssid);
  }
  delay(60000); //interval 60s
}
