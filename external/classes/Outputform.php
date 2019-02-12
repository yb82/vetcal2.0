<?php

class Outputform{
	public $description;
	public $dueDate;
	public $amount;
		//public $courseName;

	public function __construct($description,$dueDate,$amount){
			//$this->courseStartDates= array();
		$this->description = $description;
		$this->dueDate = $dueDate;
		$this->amount = $amount;
			//$this->courseName = $courseName;


	}
	



}