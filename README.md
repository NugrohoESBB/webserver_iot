<h2>🛠️ Setup folder setelah download repositori</h2>

<p>1. Paste file zip setelah download file dari repositori ke folder xampp > htdocs</p>
<p>2. Unzip file tersebut</p>
<p>3. Ubah nama folder yang di dapat setelah dilakukan unzip yang semula nama foldernya "webserver_iot" menjadi "iot"</p>
<p>4. Setelah nama foldernya diubah sehingga alur foldernya menjadi xampp > htdocs > iot</p>
<br>


<h2>🛠️ Arduino IDE Code (GET METHOD)</h2>

<p>1. Ubah SSID dan Password</p>

```php
const char* ssid = "ENTER A VALUE";
const char* password = "ENTER A VALUE";
```
<p>2. Isi IP untuk get data dan melihat status pengiriman data</p>

```php
if ((WiFi.status() == WL_CONNECTED)) {
    // C:\xampp\htdocs\postData\webapi\api\create.php
    address ="http://(yourIP)/postData/webapi/api/create.php?suhu=";
    address += String(suhu);
    address += "&kelembaban="; 
    address += String(kelembaban) ;
      
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
```
<br>


<h2>🛠️ Arduino IDE Code (POST METHOD)</h2>

<p>1. Ubah SSID dan Password</p>

```php
const char* ssid = "ENTER A VALUE";
const char* password = "ENTER A VALUE";
```
<p>2. Isi IP untuk post data dan melihat status pengiriman data</p>

```php
if ((WiFi.status() == WL_CONNECTED)) {
    WiFiClient client;
    HTTPClient http;
    
    StaticJsonDocument<200> doc;
    String url, nodemcuData; 
    
    // C:\xampp\htdocs\postData\webapi\api\create.php
    url ="http://(yourIP)/postData/webapi/api/create.php";
    
    doc["suhu"] = String(suhu);
    doc["kelembaban"] = String(kelembaban);

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
```
<br>


<h2>🛠️ PHP Code (database.php)</h2>
<p>ubah bagian database.php sesuai kebutuhan</p>

```php
<?php 
    class Database {
        private $host = "Your Host";
        private $database_name = "Your Database Name";
        private $username = "Your Username";
        private $password = "Your Password";

        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  
?>
```
<br>


<h2>🛠️ PHP Code (create.php)</h2>
<p>Import database.php and mc_log.php</p>

```php
include_once '../config/database.php';
include_once '../class/mc_log.php';
```

<p>Melakukan pengecekan dan publish data ke database</p>

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method
    $data = json_decode(file_get_contents("php://input"));
    $item->suhu = $data->suhu;
    $item->kelembaban = $data->kelembaban;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
    // The request is using the GET method
    $item->suhu = isset($_GET['suhu']) ? $_GET['suhu'] : die('wrong structure!');
    $item->kelembaban = isset($_GET['kelembaban']) ? $_GET['kelembaban'] : die('wrong structure!');
}else {
    die('wrong request method');
}
    
if($item->createLogData()){
    echo 'Data created successfully.';
} else{
    echo 'Data could not be created.';
}
```
