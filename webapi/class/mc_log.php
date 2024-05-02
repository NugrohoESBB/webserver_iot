<?php
    class Nodemcu_log{

        // Connection
        private $conn;

        // Table
        private $db_table = "station1";

        // Columns
        public $id;
        public $temp;
        public $difftemp;
        public $perctemp;
        public $hum;
        public $diffhum;
        public $perchum;
        public $created_at;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL DATA (7 DATA LIMIT)
        public function getLogData(){
            $sqlQuery = "SELECT id, temp, difftemp, perctemp, hum, diffhum, perchum, created_at FROM " . $this->db_table . " ORDER BY created_at DESC LIMIT 7";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createLogData(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        temp = :temp,
                        difftemp = :difftemp,
                        perctemp = :perctemp,
                        hum = :hum,
                        diffhum = :diffhum,
                        perchum = :perchum";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->temp=htmlspecialchars(strip_tags($this->temp));
            $this->difftemp=htmlspecialchars(strip_tags($this->difftemp));
            $this->perctemp=htmlspecialchars(strip_tags($this->perctemp));
            $this->hum=htmlspecialchars(strip_tags($this->hum));
            $this->diffhum=htmlspecialchars(strip_tags($this->diffhum));
            $this->perchum=htmlspecialchars(strip_tags($this->perchum));
        
            // bind data
            $stmt->bindParam(":temp", $this->temp);
            $stmt->bindParam(":difftemp", $this->difftemp);
            $stmt->bindParam(":perctemp", $this->perctemp);
            $stmt->bindParam(":hum", $this->hum);
            $stmt->bindParam(":diffhum", $this->diffhum);
            $stmt->bindParam(":perchum", $this->perchum);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // fetch single
        public function getSingleLogData(){
            $sqlQuery = "SELECT
                        id, 
                        temp,
                        difftemp,
                        perctemp,
                        hum,
                        diffhum,
                        perchum,
                        created_at
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
			//error handling
			if($stmt->errorCode() == 0) {
				while(($dataRow = $stmt->fetch(PDO::FETCH_ASSOC)) != false) {
					$this->temp = $dataRow['temp'];
                    $this->difftemp = $dataRow['difftemp'];
                    $this->perctemp = $dataRow['perctemp'];
					$this->hum = $dataRow['hum'];
                    $this->diffhum = $dataRow['diffhum'];
                    $this->perchum = $dataRow['perchum'];
					$this->created_at = $dataRow['created_at'];
				}
			} else {
				$errors = $stmt->errorInfo();
				echo($errors[2]);
			}
			
            //$dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            //$this->suhu = $dataRow['suhu'];
            //$this->kelembaban = $dataRow['kelembaban'];
            //$this->created_at = $dataRow['created_at'];
        }        

        // Edit Data
        public function updateDataLog(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        temp = :temp,
                        difftemp = :difftemp,
                        perctemp = :perctemp,
                        hum = :hum,
                        diffhum = :diffhum,
                        perchum = :perchum,
                        created_at = :created_at
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->temp=htmlspecialchars(strip_tags($this->temp));
            $this->difftemp=htmlspecialchars(strip_tags($this->difftemp));
            $this->perctemp=htmlspecialchars(strip_tags($this->perctemp));
            $this->hum=htmlspecialchars(strip_tags($this->hum));
            $this->diffhum=htmlspecialchars(strip_tags($this->diffhum));
            $this->perchum=htmlspecialchars(strip_tags($this->perchum));
            $this->created_at=htmlspecialchars(strip_tags($this->created_at));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":temp", $this->temp);
            $stmt->bindParam(":difftemp", $this->difftemp);
            $stmt->bindParam(":perctemp", $this->perctemp);
            $stmt->bindParam(":hum", $this->hum);
            $stmt->bindParam(":diffhum", $this->diffhum);
            $stmt->bindParam(":perchum", $this->perchum);
            $stmt->bindParam(":created_at", $this->created_at);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               $itemCount = $stmt->rowCount();
			   if($itemCount > 0){
					return true;
				}else{
					return false;
				}
            }
            return false;
        }

        // DELETE
        function deleteLogData(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

