<?php
class Database{

	// database credentials
	private $host = 'localhost';
	private $db_name = 'MediaOTG';
	private $username = 'crud';
	private $password = 'secret';
	public $conn;

	// connect
	public function getConnection(){
		$this->conn = null;

		try{
			$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
		} catch(PDOException $exception){
			echo "Connection error: ".$exception->getMessage();
		}

		return $this->conn;
	}
}