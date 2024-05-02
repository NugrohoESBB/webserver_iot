<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../class/mc_log.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Nodemcu_log($db);
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// The request is using the POST method
		$data = json_decode(file_get_contents("php://input"));
		$item->temp = $data->temp;
		$item->difftemp = $data->difftemp;
		$item->perctemp = $data->perctemp;
		$item->hum = $data->hum;
		$item->diffhum = $data->diffhum;
		$item->perchum = $data->perchum;
	} 
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
		// The request is using the GET method
		$item->temp = isset($_GET['temp']) ? $_GET['temp'] : die('wrong structure!');
		$item->difftemp = isset($_GET['difftemp']) ? $_GET['difftemp'] : die('wrong structure!');
		$item->perctemp = isset($_GET['perctemp']) ? $_GET['perctemp'] : die('wrong structure!');
		$item->hum = isset($_GET['hum']) ? $_GET['hum'] : die('wrong structure!');
		$item->diffhum = isset($_GET['diffhum']) ? $_GET['diffhum'] : die('wrong structure!');
		$item->perchum = isset($_GET['perchum']) ? $_GET['perchum'] : die('wrong structure!');
	}else {
		die('wrong request method');
	}
	
    if($item->createLogData()){
        echo 'Data created successfully.';
    } else{
        echo 'Data could not be created.';
    }
?>