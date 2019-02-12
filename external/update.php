<?php

require_once 'classes/Datahandler.php';
require_once 'classes/Receivedata.php';
require_once 'classes/Calculator.php';
require_once 'classes/PDFCreator.php';

//require_once './preloader.php';
//$login = new Login ();



if (isset ( $_POST ["duration"] )) {
	$coursename= $_POST["duration"];
	//echo coursename;
	$courseData = new Datahandler ();
	
	
	

	echo json_encode($courseData->getCourseData($coursename));


}

else if (isset ( $_POST ["courses"] )) {

	$courseNames= $_POST["courses"];
	$courseData = new Datahandler ();
	
	
	
	echo json_encode($courseData->getStartDateByName($courseNames));


	
}

else if (isset ( $_POST ["coursedata"] )) {
	$coursename= $_POST["coursedata"];

	$courseData = new Datahandler ();
	
	

	echo json_encode($courseData->getCourseData($coursename));


}

else if(isset($_POST["course1duration"])){
	
	$receive = new Receivedata();
	$courseData = $receive->getUserCourseData();
	$paymenetOption = $receive->getPaymentOption();
	$calculator = new Calculator($courseData, $paymenetOption);
	$result = $calculator->getAllPaymentPlan();

	$paymentPDF = new PDFCreator();
	
	if ($receive->getStudentDetail()->application == "1" ){
		
		$paymentPDF->createApplicationPDF($courseData, $receive->getStudentDetail(),$receive->getPaymentOption());
	} else	$paymentPDF->createPaymentplanPDF($courseData,$result,$calculator->total);
	

}
