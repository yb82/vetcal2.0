<?php

require_once ("./classes/Course.php");
require_once ("./classes/Datahandler.php");
require_once ("./classes/Fee.php");
require_once ("./classes/StudentDetail.php");
require_once ("./classes/Outputform.php");
require_once ('./libraries/pdflib/tcpdf.php');

define( "TENWEEKS", "+67 day");
define( "FOURWEEKS", "+28 day");

define( "TUITION", "Tuition");

define( "SECONDPAYMENTDATE", "-17 day");



class Calculator{
	private $fee;
	private $dataHandler;
	//private $studentDetail;
	private $paymentOption;
	public $selectedCourseNameNStartDate;
	public $paymentPlan;
	private $selectedCourseDataDetail;
	private $today;
	public $error ="hello";
	public $todayDate;
	public $total;
	private $receivedata;




	public function __construct($selectedCourseNameNStartDate,$paymentOption,$receivedata){
			//$this->courseStartDates= array();

		$this->fee = new Fee();
		$this->dataHandler = new Datahandler();
		$this->receivedata = $receivedata;

		//$this->studentDetail = new StudentDetail();
		$this->paymentOption = $paymentOption;
		$this->selectedCourseNameNStartDate =$selectedCourseNameNStartDate;
		$this->paymentPlan = array();
		$this->todayDate = new DateTime();
		$this->today = $this->todayDate->format('d/m/Y');

		$this->checkMatEnrolFee();
		if(count($this->selectedCourseNameNStartDate) ==1){
			$this->error .="<br/> single <br/>";
			$this->singlecourse();

		} else{
			switch ($this->paymentOption) {
				case 1:
				//$this->error .="hello1<br/>";
				$this->calculate1();

				break;
				case 2:
				//$this->error .="hello2<br/>";
				$this->calculate2();
				break;
				case 3:
				//$this->error .="hello3<br/>";
				$this->calculate3();
				break;

			}
		}
		

	}
	public static function strToDate($date){ 
		$date1 = DateTime::createFromFormat('d/m/Y', $date);
		return $date1;
	}
	public static function dateToString($dateTime){
		return $dateTime->format('d/m/Y');
	}

	public function checkMatEnrolFee(){
		$output1;
		$enrolFlag = false;
		//$moreThan2Courses = false;
		$materialFee= 0;

		$this->selectedCourseDataDetail = array();

		foreach ($this->selectedCourseNameNStartDate as $value) {	
	/*		if($value[0]=="Diploma of Business" && ($value[1] == "20/11/2017" ||$value[1] == "08/01/2018" ||$value[1] == "26/02/2018" )){
				$tempCourse = $this->dataHandler->getCourseDataByName($value[0]);

				

				$tempCourse->tuitionFee = 4400;
				
				$this->selectedCourseDataDetail[] = $tempCourse;	
			} else
	*/		$this->selectedCourseDataDetail[]= $this->dataHandler->getCourseDataByName($value[0]);
		}


		foreach ($this->selectedCourseDataDetail as $key => $value) {
			//print_r( $value );
			if($value->enrolmentFee == 0){
				$enrolFlag = true;					
			}
		}
		
		//$moreThan2Courses = (count($this->selectedCourseNameNStartDate) > 1 ) ? true : false;

		$description = "Enrolment Fee Wavied";
		$enrolmentFee;
		if($enrolFlag){
			$enrolmentFee = 0;

		}
		/* else if($moreThan2Courses){
			$enrolmentFee = 95;
			$description = "Enrolment";

		} */
		else {
			$description = "Enrolment";
			$enrolmentFee = 195;
		}
		$output1 = new Outputform($description,$this->today,$enrolmentFee);
		$this->paymentPlan[]= $output1;


		foreach ($this->selectedCourseDataDetail as $key => $value) {
				# code...
			if($value->materialFee !=0){
				$materialFee += $value->materialFee;
			}
		}

		// Material special
		/*if(count($this->selectedCourseNameNStartDate) >=2 && $materialFee > 100){
			$materialFee = 100;
		}*/
		
		$outputMaterial = new Outputform("Material",$this->today,$materialFee);
		$this->paymentPlan[] = $outputMaterial;
		$pPlanFee = $this->fee->paymentPlanFee;
		
		$outputRecord = new Outputform("Payment Plan", $this->today, $pPlanFee);
		$this->paymentPlan[] =$outputRecord;
		
	}

	public function getAllPaymentPlan(){
		//$this->error .="helloPayment<br/>";
		
		return $this->paymentPlan;
	}
	private function checkDiscount($tuition){
		$courseCnt =count($tuition);
		if ($this->receivedata->getPromotionFlag()) {
				
			if($this->fee->promotion < 1){
				foreach ($tuition as $key => $value) {
					
					$tuition[$key] = $value* $this->fee->promotion;
				}
					
				
			}

			
		}

		if($courseCnt==2){
			$tuition[$courseCnt-1] -= $this->fee->package;
		}elseif ($courseCnt >=3) {
			# code...
			$tuition[$courseCnt-1] -= $this->fee->package1;
		}

		return $tuition;
	}

public function calculate1(){	
		$tuition = array() ;
		$startdate =array();
		$courseName = array();
		$firstPayment = 0;
		$tempPaymentPlan = array();
		$tempPaymentDueDate = array();
		$tempCourseName = array();
		
		// get course name and its start date
		
		foreach ($this->selectedCourseNameNStartDate as $key => $value) {
			
			$courseName[] = $value[0];
			$startdate[]= $this->strToDate($value[1]);

		}

		// get tuition fees and make an array

		foreach ($this->selectedCourseDataDetail as $key => $value) {
			$tuition[] = $value->tuitionFee ;	
		}
		
		
		
		

		// check discount.
		$courseCnt =count($tuition);
		$tuition = $this->checkDiscount($tuition);
		// deduct course special price.
		
		$tempPaymentPlan[0]= 500;
		$tempPaymentPlan[1]= 1000;
	//	print_r($this->selectedCourseDataDetail);

		$tempCourseName[0]=$this->selectedCourseDataDetail[0]->courseName;
		$tempCourseName[1]=$this->selectedCourseDataDetail[1]->courseName;
		
		$tempPaymentDueDate[0] = $this->today;
		
		$duedate = $startdate[0];
		//print_r($startdate);
		//echo "<br/><br/>duedate".$duedate;
		//echo $this->dateToString( $duedate->modify("+10 day"));

		$tempPaymentDueDate[1] = $this->dateToString($duedate->modify(SECONDPAYMENTDATE));
		//print_r($tempPaymentDueDate);
		switch ($courseCnt) {
			case 2:

			$tuition[0]-=750;
			$tuition[1]-=750;

			break;
			
			case 3:
			$tuition[0]-=750;
			$tuition[1]-=375;
			$tuition[2]-=375;
				# code...
			break;
			
			case 4:
				# code...
			$tuition[0]-=375;
			$tuition[1]-=375;
			$tuition[2]-=375;
			$tuition[3]-=375;
			break;
			
			case 5:
				# code...
			$tuition[0]-=300;
			$tuition[1]-=300;
			$tuition[2]-=300;
			$tuition[3]-=300;
			$tuition[4]-=300;
			break;
			
			case 6:
				# code...
			$tuition[0]-=300;
			$tuition[1]-=300;
			$tuition[2]-=225;
			$tuition[3]-=225;
			$tuition[4]-=225;
			$tuition[5]-=225;
			break;
			
		}

		$paymentcounter =2;// created 2 payment as shown above, the payment will be start in third.
		$i =0; // course selector
		$duedateCounter =0; // each course payment counter, first will be 10 weeks after start date.
		$reminder ;
		$flagTwoPayment = false; // if the payment is only 2 payments, this will be used.


		foreach ($tuition as  $value) {
			$reminder = $value;
			// this checks that this called course is the first course or not.
			if($i==0){
				$duedate1 =$startdate[$i]->modify("+17 day");//add 2 weeks 
			} else $duedate1 =$startdate[$i];
			$i++;

		/*	$tempPaymentDueDate[]=$this->dateToString( $duedate1);
			$tempPaymentPlan[$paymentcounter++] = 1123;*/

			do{
				if($reminder >= 1000){

					if($duedateCounter==0 && !$flagTwoPayment){
						$tempPaymentDueDate[]=$this->dateToString( $duedate1->modify(TENWEEKS));
					} else $tempPaymentDueDate[]=$this->dateToString( $duedate1->modify(FOURWEEKS));
				
					$tempPaymentPlan[$paymentcounter++] = 1000;
					$reminder -=1000;
					
					$duedateCounter ++;
				}
			}while ($reminder > 1000);
			
			$flagTwoPayment = ($duedateCounter == 0) ? true : false ;
			$duedateCounter=0;

			if($reminder !=0){
				
				$tempPaymentPlan[$paymentcounter] = $reminder;
				$tempPaymentDueDate[] = (!$flagTwoPayment) ? $this->dateToString( $duedate1->modify(FOURWEEKS)) : $this->dateToString( $duedate1->modify(TENWEEKS)) ;

				
				$paymentcounter++;
				
			} 

			$flagTwoPayment = false;
			
			

		}

		$counter =0;
		foreach ($tempPaymentDueDate as $key => $value) {
			$outputPayment = new Outputform(TUITION, $value,$tempPaymentPlan[$counter]);
			$this->paymentPlan[]=$outputPayment;
			$counter++;
		}

		foreach ($this->paymentPlan as $key => $value) {

			$this->total += $value->amount;
		}
                
	}
	
	public function calculate2(){	
		$tuition = array() ;
		$startdate =array();
		$courseName = array();
		$firstPayment = 0;
		$tempPaymentPlan = array();
		$tempPaymentDueDate = array();
		$tempCourseName = array();
		
		foreach ($this->selectedCourseNameNStartDate as $key => $value) {
			
			$courseName[] = $value[0];
			$startdate[]= $this->strToDate($value[1]);

		}




		foreach ($this->selectedCourseDataDetail as $key => $value) {
			$tuition[] = $value->tuitionFee ;	
		}
		$courseCnt =count($tuition);
		$tuition = $this->checkDiscount($tuition);


		$tempCourseName[]= $courseName[0];
		$counter =1;
	
		foreach ($tuition as $key => $value) {
			$firstPayment += $value*0.2;
			$tempPaymentPlan[$counter] = $value*0.2;
			$counter++;
			$tempPaymentPlan[$counter] = $value*0.3;
			$counter++;			
			$tempPaymentPlan[$counter] = $value*0.3;
			$counter++;
		}
		$tempPaymentPlan[0]=$firstPayment;

		$tempPaymentDueDate[]=$this->today;
		$tempCourseName[]= $courseName[0];
		$counter = 0;
		foreach ($startdate as $key => $value) {
			$duedate =$value;
			$tempCourseName[]=$courseName[$counter];
			$tempPaymentDueDate[]= $this->dateToString($duedate->modify(SECONDPAYMENTDATE));
			
			$tempCourseName[]=$courseName[$counter];
			$duedate =$value->modify("+17 day");//add 2 weeks 
			
			$tempPaymentDueDate[]=  $this->dateToString($duedate->modify(TENWEEKS));
			$tempCourseName[]=$courseName[$counter];
			$tempPaymentDueDate[]=  $this->dateToString($duedate->modify(FOURWEEKS));
			$counter++;

		}

		$counter = 0;
		foreach ($tempPaymentDueDate as $key => $value) {
			
			$outputPayment = new Outputform(TUITION, $value,$tempPaymentPlan[$counter]);
			$this->paymentPlan[]=$outputPayment;
			$counter++;
		}
		foreach ($this->paymentPlan as $key => $value) {
			# code...

			$this->total += $value->amount;
		}


	}
	public function calculate3(){	
		

		$tuition = array() ;
		$startdate =array();
		$courseName = array();
		$firstPayment = 0;
		$tempPaymentPlan = array();
		$tempPaymentDueDate = array();
		$tempCourseName = array();
		
		foreach ($this->selectedCourseNameNStartDate as $key => $value) {
			
			$courseName[] = $value[0];
			$startdate[]= $this->strToDate($value[1]);

		}



		foreach ($this->selectedCourseDataDetail as $key => $value) {
			$tuition[] = $value->tuitionFee ;	
		}

		$courseCnt =count($tuition);
		$tuition = $this->checkDiscount($tuition);

		//$tempCourseName[]= $courseName[0];
		$counter =1;
		foreach ($tuition as $key => $value) {
			$firstPayment += $value*0.5;
			$tempPaymentPlan[$counter] = $value*0.5;
			//$tempCourseName[] = $courseName[$counter];
			$counter++;
		}
		$tempPaymentPlan[0]=$firstPayment;

		$tempPaymentDueDate[]=$this->today;
		foreach ($startdate as $key => $value) {

			$tempPaymentDueDate[]= $this->dateToString($value->modify(TENWEEKS));
		}

		$counter = 0;
		foreach ($tempPaymentDueDate as $key => $value) {
			$outputPayment = new Outputform(TUITION, $value,$tempPaymentPlan[$counter]);
			$this->paymentPlan[]=$outputPayment;
			$counter++;
		}
		foreach ($this->paymentPlan as $key => $value) {
			# code...

			$this->total += $value->amount;
		}


	}




	public function singlecourse(){
		$tuition ;
		$startdate;
		$reminder ;
		$courseName ;
		//$this->error .="start single <br/>";
		
		foreach ($this->selectedCourseNameNStartDate as  $value) {
				# code...
			$courseName = $value[0];
			$startdate= $this->strToDate($value[1]);

		}

		foreach ($this->selectedCourseDataDetail as $key => $value) {
				# code...
			$reminder = $tuition = $value->tuitionFee -= $this->fee->single;

		}
		if ($this->receivedata->getPromotionFlag()) {
				
			$reminder*= $this->fee->promotion;

			
		}
		//$this->error .="first Payment <br/>";
		
	

		if($this->paymentOption == 1){
			
			$reminder -= 300;

			$output1 = new Outputform(TUITION,$this->today,300,$courseName);
			$this->paymentPlan[]=$output1;
			

			# Second payment Due date 
			$paymentDue = $startdate;
			$paymentDue->modify(SECONDPAYMENTDATE);
			$counter = 0;
			do{
				$this->error .=" Payments <br/>";
				$outputPayment = new Outputform(TUITION, $this->dateToString($paymentDue),1000,$courseName);
				if($counter == 0 ) $paymentDue->modify("+17 day");
				$reminder -=1000;

				if ($counter == 0) {
					$paymentDue = $startdate;
					$paymentDue->modify(TENWEEKS);					
				} else $paymentDue->modify(FOURWEEKS);
				$counter++;
				$this->paymentPlan[] = $outputPayment;

			}while ($reminder-1000 > 0 );
			//print_r($this->paymentPlan);
			//echo "<br/><br/>";


			if($reminder > 0){
				$this->error .=" last Payment <br/>";
				$ouptutLast = new Outputform(TUITION,$this->dateToString($paymentDue),$reminder,$courseName);
				$this->paymentPlan[]=$ouptutLast;
			}
			

			
		}

		else if($this->paymentOption ==2)
		{
			$tempPayment = array($reminder*0.3, $reminder*0.2, $reminder*0.3, $reminder*0.2);
			$paymentDue = $startdate;

			$tempDueDate = array($this->today);
			$tempDueDate[] =  $this->dateToString($paymentDue->modify(SECONDPAYMENTDATE));
			$paymentDue->modify("+17 day");
			$tempDueDate[] =  $this->dateToString($paymentDue->modify(TENWEEKS));
			$tempDueDate[] = $this->dateToString($paymentDue->modify(FOURWEEKS));
			$i =0;
			foreach ($tempDueDate as $key => $value) {
				$outputPayment = new Outputform(TUITION,$value,$tempPayment[$i],$courseName);
				$this->paymentPlan[] = $outputPayment;
				$i++;
			}
			
		}
		foreach ($this->paymentPlan as $key => $value) {
			# code...

			$this->total += $value->amount;
		}

	}
}
