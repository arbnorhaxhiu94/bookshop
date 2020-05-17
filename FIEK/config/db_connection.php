<?php

class DB_Connect{

	public function __construct($host, $username, $password, $database){
		$this->check_connection($host, $username, $password, $database);
	}

	public function check_connection($host, $username, $password, $database){
		$this->connection = mysqli_connect($host, $username, $password, $database);
		return $this->connection;
	}

	public function getconn(){
		return $this->connection;
	}
			
}

#$connection = new DB_Connect('localhost', 'root', '', 'fifa');

?>