<?php
class connectPDO{
	private $user = '';
	private $pass = '';
	private $host = '';
	private $db = '';
	private $conn = '';

	function __construct(){		
		$this->host = 'localhost';
		$this->db = 'github';
		$this->user = 'root';
		$this->pass = '';

		$this->getConection();
	}

	function getConection(){
		$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';',$this->user, $this->pass);			
	}

	public function updateLogs($detail){
		$detail = 'hola';
		$timeStamp = '2019-05-09 12:27:00';
		$this->conn->prepare("INSERT INTO reg_movs (detail, time_stamp) VALUES (:d, :t)");
		$this->conn->bindParam(':d', $detail);
		$this->conn->bindParam(':t', $timeStamp);
		$this->conn->execute();
	}
}
?>