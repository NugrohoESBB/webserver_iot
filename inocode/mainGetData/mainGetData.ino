/*#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>*/
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include "DHT.h"
#include <elapsedMillis.h>

/*#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64

#define OLED_RESET -1
#define SCREEN_ADDRESS 0x3C
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);*/

double preTemp, temp, preHum, hum, diffValueTemp, percentTemp, diffValueHum, percentHum;

const int ledPin = D8;
#define DHTPIN D3

elapsedMillis elapsedTime;
#define DHTTYPE DHT11
 
const char* ssid = "Rumah sakit";
const char* password = "k0stput1h";

DHT dht(DHTPIN, DHTTYPE);

// GET data request variable
WiFiClient client;
HTTPClient http;
    
String address;
String payload;

void ledTwinkle() {
  digitalWrite(ledPin, LOW);
  delay(500);
  digitalWrite(ledPin, HIGH);
  delay(500);
  digitalWrite(ledPin, LOW);
  delay(500);
  digitalWrite(ledPin, HIGH);
  delay(500);
  digitalWrite(ledPin, LOW);
  delay(500);
  digitalWrite(ledPin, HIGH);
}

void setup() {
  //display.clearDisplay();

  pinMode(ledPin, OUTPUT);
  digitalWrite(ledPin, HIGH);
  
  Serial.begin(115200);
  dht.begin();
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  int i=0;
  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    /*display.setTextSize(1);
    display.setTextColor(WHITE);
    display.setCursor(0,28);
    display.println(".");*/
    delay(1000);     
  }
  Serial.println("");
  Serial.println(F("DHTxx test!"));
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();

  /*display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0,10);
  display.println("WiFi connected");
  display.setCursor(0,20);
  display.print("IP address: ");
  display.println(WiFi.localIP());
  display.setCursor(0,30);
  display.println("DHTxx test!");
  display.display();*/
  delay(2000);
}

void loop() {
  ledTwinkle();
  //double kelembaban = random(50, 150);
  //double suhu = random(25, 40);

  if (elapsedTime > 60000) {
    preTemp = temp;
    preHum = hum;
  
    hum = dht.readHumidity();
    temp = dht.readTemperature();
  
    // Check if any reads failed and exit early (to try again).
    if (isnan(hum) || isnan(temp)) {
      Serial.println(F("Failed to read from DHT sensor!"));
      return;
    }
    Serial.println("Temp: " + String(temp) + " & Hum: " + String(hum));
  
    /*display.clearDisplay();
    display.setTextSize(1);
    display.setTextColor(WHITE);
    display.setCursor(0,10);
    display.println("Temp: " + String(temp) + "Hum: " + String(hum));
    display.display();*/
  
    diffValueTemp = temp - preTemp;
    diffValueHum = hum - preHum;
    percentTemp = ((diffValueTemp / 256.0) * 100);
    percentHum = ((diffValueHum / 256.0) * 100);
  
    Serial.println("Diff : " + String(diffValueTemp) + " and " + String(diffValueHum));
    Serial.println("Perc : " + String(percentTemp) + "% and " + String(percentHum) + "%");
    Serial.println(" ");
    /*display.setCursor(0,20);
    display.println("Diff : " + String(diffValueTemp) + " and " + String(diffValueHum));
    display.setCursor(0,30);
    display.println("Perc : " + String(percentTemp) + "% and " + String(percentHum) + "%");
    display.display();*/
  
    /*Serial.print(F("Temperature:"));
    Serial.print(suhu);
    Serial.print(F("°C   Humidity:"));
    Serial.print(kelembaban);
    Serial.println(F("%"));*/
    
    if ((WiFi.status() == WL_CONNECTED)) {
      if (temp != preTemp and hum != preHum) {
        // C:\...\...\(directory)\webapi\api\create.php
        address ="http://192.168.0.198/iot/webapi/api/create.php?temp=";
        address += String(temp);
        address += "&hum=";
        address += String(hum);
        address += "&difftemp=";
        address += String(diffValueTemp);
        address += "&perctemp=";
        address += String(percentTemp);
        address += "&diffhum=";
        address += String(diffValueHum);
        address += "&perchum=";
        address += String(percentHum);
          
        http.begin(client,address);  //Specify request destination
        int httpCode = http.GET();//Send the request
          
        if (httpCode > 0) { //Check the returning code    
            payload = http.getString();   //Get the request response payload
            payload.trim();
            if( payload.length() > 0 ){
              /*display.setCursor(0,40);
              display.println("Status: " + String(payload));
              display.display();*/
  
              Serial.println(payload + "\n");
            }
        } else {
          /*display.setCursor(0,40);
          display.println("Connected failed");
          display.display();*/
  
          Serial.println("Connected failed \n");
        }
        
        http.end();   //Close connection
      }
    }else{
      /*display.setCursor(0,40);
      display.println("Not connected to" + String(ssid));
      display.display();*/
  
      Serial.print("Not connected to wifi ");
      Serial.println(ssid);
    }
    elapsedTime = 0;
    //delay(60000); //interval 60s
  }
}
