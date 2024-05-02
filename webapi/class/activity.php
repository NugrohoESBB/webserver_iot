<?php
	class Activity {
		// Connection
        private $conn;

        // Table
        private $db_field = "station1";

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL DATA (7 DATA LIMIT)
        public function activityData(){
        	$field_data = "DESCRIBE $this->db_field";
        	$stmt = $this->conn->prepare($field_data);
            $stmt->execute();

    		// Menghitung jumlah kolom (field)
        	$numberOfFields = $stmt->rowCount();
        }
	}
?>