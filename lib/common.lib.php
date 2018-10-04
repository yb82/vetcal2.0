<?php
require_once ("config/config.php");
	

	function databaseConnection($db_connection) {
		// connection already opened
		if ($db_connection != null) {
			return true;
		} else {
			// create a database connection, using the constants from config/config.php
			try {
				$db_connection = new PDO ( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS );
				return $db_connection;
				// If an error is catched, database connection failed
			} catch ( PDOException $e ) {
				//$this->errors [] = $this->lang ['Database error'];
				return false;
			}
		}
	}
	
?>