<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "root";
	private $database = "BestStore";
	private $connection = "";
	
	function __construct() {
		$conn = $this->connectDB();
		$this->connection = $conn;
	}
	
	function getConn() {
		return $this->connection;
	}

	function getError() {
		return $this->connection->error;
	}

	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->connection,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->connection,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}

	function closeSql() {
		$this->connection->close();
	}
}
?>