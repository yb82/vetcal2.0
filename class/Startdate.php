<?php
require_once("lib/common.lib.php");
require_once ("config/config.php");
	

	
class Startdate {
	private $db_connection = null;
	
	private $coursestartdate=array();
	public $outputLine;
	public function __construct(){

		
		if ($this->databaseConnection()) {

			$query = $this->db_connection->prepare('
				SELECT * FROM startdate
			');	
			$query->execute();
			$result=$query->fetchAll();
			if(count ($result) >0){
				foreach ($result as $row) {
					
					$this->coursestartdate[]=array($row[0],$row[1]);
				}
			}

		} 
		$db_connection=null;

	}
	public function PrintStartDate()
	{
		
		foreach ($this->coursestartdate as $key => $value) {
			$this->outputLine .= sprintf('<tr><td>%1$s</td><td contenteditable="true" class="">%2$s</td></tr>',$value[0],$value[1]);
		}
		//$this->outputLine .=print_r($this->coursestartdate);
		return $this->outputLine;
	}
	function databaseConnection() {
		// connection already opened
		if ($this->db_connection != null) {
			return true;
		} else {
			// create a database connection, using the constants from config/config.php
			try {
				$this->db_connection = new PDO ( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS );
				return true;
				// If an error is catched, database connection failed
			} catch ( PDOException $e ) {
				//$this->errors [] = $this->lang ['Database error'];
				return false;
			}
		}
	}

}