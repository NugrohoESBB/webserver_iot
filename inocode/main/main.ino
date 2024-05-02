#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);

const int triggerPin = 12; //D6 (12)
const int echoPin = 14; //D5 (14)
const int relayPo1Pin = 3; //RX (3)
const int relayPo2Pin = 2; //D4 (2)
bool relayState = HIGH;

long duration, jarak;
 
const char* ssid = "zoraa";
const char* password = "h4h4h1h1";

// GET data request variable
WiFiClient client;
HTTPClient http;
    
String address;
String payload;

void setup() {
  lcd.begin();
  //lcd.init();
  lcd.backlight();
  Serial.begin(115200);

  pinMode(triggerPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(relayPo1Pin, OUTPUT);
  pinMode(relayPo2Pin, OUTPUT);
  digitalWrite(relayPo1Pin, relayState);
  digitalWrite(relayPo2Pin, relayState);
  
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  int i=0;
  while(WiFi.status() != WL_CONNECTED){ 
    Serial.print(".");
    lcd.setCursor(0,0);
    lcd.print("Connecting..");
    delay(1000);     
  } 
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print(WiFi.localIP());
  lcd.setCursor(0,1);
  lcd.print("ALL CLEAR");
  delay(2000);
  lcd.clear();
}

void hcsrVALUE() {
  digitalWrite(triggerPin, LOW);
  delayMicroseconds(2); 
  digitalWrite(triggerPin, HIGH);
  delayMicroseconds(10); 
  digitalWrite(triggerPin, LOW);
  duration = pulseIn(echoPin, HIGH);
  jarak = (duration/2) / 29.1;
  Serial.println("jarak :");
  Serial.print(jarak);
  Serial.println(" cm");
  delay(1000);

  if (jarak >= 4) {
    digitalWrite(relayPo1Pin, LOW);
    lcd.setCursor (0,1);
    //lcd.print ("================");
    lcd.print ("Level Air Rendah");
  } else if (jarak == 5) {
    digitalWrite(relayPo1Pin, HIGH);
    digitalWrite(relayPo2Pin, HIGH);
    lcd.setCursor (0,1);
    //lcd.print ("================");
    lcd.print ("Level Air Normal");
  } else if (jarak <= 4) {
    digitalWrite(relayPo2Pin, LOW);
    lcd.setCursor (0,1);
    //lcd.print ("================");
    lcd.print ("Level Air Tinggi");
  }
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Tinggi Air : " + String(jarak));
}

void loop() {
  hcsrVALUE();

  // Check if any reads failed and exit early (to try again).
  if (isnan(jarak)) {
    Serial.println(F("Failed to read from HCSR sensor!"));
    return;
  }
  Serial.print(F("Jarak:"));
  Serial.print(jarak);
  Serial.println(F(" cm"));
  
  if ((WiFi.status() == WL_CONNECTED)) {
    // C:\xampp\htdocs\postData\webapi\api\create.php
    address ="http://192.168.101.59/postData/webapi/api/create.php?jarak=";
    address += String(jarak);
    address += "&pompa="; 
    address += String(relayPo1Pin) ;
      
    http.begin(client,address);  //Specify request destination
    int httpCode = http.GET();//Send the request
      
    if (httpCode > 0) { //Check the returning code    
        payload = http.getString();   //Get the request response payload
        payload.trim();
        if( payload.length() > 0 ){
           Serial.println(payload + "\n");
        }
    } else {
      Serial.print("Connected failed ");
    }
    
    http.end();   //Close connection
  }else{
    Serial.print("Not connected to wifi ");
    Serial.println(ssid);
  }
  delay(10000); //interval 10s
}
