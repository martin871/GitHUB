<?php
/**
 * @Author Martin Ucan May
 */
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
	
	/**
	* Realiza la conexion a la bd github
	*
	* $this->conn se le asigna la conexion
	*/
	function getConection(){
		$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';',$this->user, $this->pass);			
	}

	/**
	*Registra la consulta en la tabla de regs_movs
	*
	*/
	public function updateLogs($detail){
		$send = '';
		$timeStamp = date('Y-m-d H:i:s');		
		$send = $this->conn->prepare("INSERT INTO reg_movs (id, detail, time_stamp) VALUES (NULL, :d, :t)");
		$send->bindParam(":d", $detail, PDO::PARAM_STR);
		$send->bindParam(":t", $timeStamp);
		$send->execute();
	}
}
?>