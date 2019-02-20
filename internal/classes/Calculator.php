<?php

require_once ("./classes/Course.php");
require_once ("./classes/Datahandler.php");
require_once ("./classes/Fee.php");
require_once ("./classes/StudentDetail.php");
require_once ("./classes/Outputform.php");
require_once ("./classes/Receivedata.php");

define( "TENWEEKS", "+67 day");
define( "FOURWEEKS", "+28 day");

define( "TUITION", "Tuition");

define( "SECONDPAYMENTDATE", "-17 day");
define( "LTSECONDPAYMENT", "+38 day");

define("LTPCKFIRSTPAYMENT",250);
define("LATINPAYMENT",500);

class Calculator{
	private $fee;
	private $dataHandler;
	//private $studentDetail;
	private $paymentOption;
	public $selectedCourseNameNStartDate;
	public $paymentPlan;
	public $selectedCourseDataDetail;
	private $today;
	public $error ="hello";
	public $todayDate;
	public $total;
	public $finalPaymentplan;
	public $receivedata;
	private $promotion;
	private $courseDetailOutput =array();

	// calculate the way of marketing then change this payment plan for Becas.
	// $paymentPlan is marketing payment, $finalPaymentplan is for Enrolment officer.


	

	public function __construct($selectedCourseNameNStartDate,$paymentOption, $receive){
	
		$this->receivedata = $receive;
		$this->fee = new Fee();
		$this->dataHandler = new Datahandler();

	
		$this->paymentOption = $paymentOption;
		$this->selectedCourseNameNStartDate =$selectedCourseNameNStartDate;
		$this->paymentPlan = array();
		$this->todayDate = new DateTime();
		$this->today = $this->todayDate->format('d/m/Y');
		$this->finalPaymentplan = array();

		$this->checkMatEnrolFee();
		if(count($this->selectedCourseNameNStartDate) ==1){
		
			if($this->paymentOption ==4){
				$this->calculate4();
			}
			else $this->singlecourse();

		} else{
			switch ($this->paymentOption) {
				case 1:
	
				$this->calculate1();

				break;
				case 2:
	
				$this->calculate2();
				break;
				case 3:
	
				$this->calculate3();
				break;
				case 4:
				$this->calculate4();
				break;

				case 5:
				$this->calculate5();
				break;

			}
		}
		
		$this->finalizePayment();
		

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
				break;
			}
		}

		// get course details and make a table form.
		$tempEndDate =array();
		$tempcourseName = array();
		$tempstringStartdate = array();
		foreach ($this->selectedCourseNameNStartDate as $key => $value) {
			
			$tempcourseName[] = $value[0];
			$tempstringStartdate[] = $value[1];
			$tempEndDate[]= $this->strToDate($value[1]);

		}
		$i = 0;
		foreach ($this->selectedCourseDataDetail as $key => $value) {
			//print_r( $value );
					$daysToAddup = $value->duration *7 -3;
					$tempDate = $tempEndDate[$i]->modify('+'.$daysToAddup.' day' );
					$strEndDate = $this->dateToString($tempDate);

					$this->courseDetailOutput[] = array("COURSE"=>$value->courseName." ".$value->courseCode ,"CRICOS CODE"=>$value->cricos,"COURSE LENGTH"=>$value->duration." week","START DATE"=>$tempstringStartdate[$i],"END DATE"=>$strEndDate );
					

		}



		if($this->receivedata->getEnrolmentFeeWaive()){
			$enrolFlag = true;
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
		if($this->receivedata->getMaterialFeeWaive()){
			$materialFee = 0;
		}
		$outputMaterial = new Outputform("Material",$this->today,$materialFee);
		$this->paymentPlan[] = $outputMaterial;
		$pPlanFee = $this->fee->paymentPlanFee;
		if($this->receivedata->getPaymentFeeWaive()){
			$pPlanFee= 0;
		}
		$outputRecord = new Outputform("Payment Plan", $this->today, $pPlanFee);
		$this->paymentPlan[] =$outputRecord;
		
	}

	public function getAllPaymentPlan(){
		//$this->error .="helloPayment<br/>";
		
		return $this->finalPaymentplan;
	}
	public function getCourseDetailOutput()
	{
		return $this->courseDetailOutput;
	}
	private function finalizePayment(){
		$remain = 0; 
		$currentPayment = 0;
		$currentCourseTuition = 0;
		$courseCnt = 0;  // course selector
		$courseChangeFlag = false;
		$currentCourse = new Course();

		/* call payment, then get course tution.
		if payment > tuition, payment - tuition
		then call next tuition, tuition - remain.
		
		*** if the course is retail I, still remain is bigger than course tuition.
		need to call tutions till tuition > remain.

		*/ 

		foreach ($this->paymentPlan as $key=> $onePayment){
			$currentPayment = $onePayment->amount;
            

          
			if (!$courseChangeFlag){
				// if the course hasn't called, then call tuition fee and save into variable.

                $currentCourse = $this->selectedCourseDataDetail[$courseCnt++];
                $currentCourseTuition = $currentCourse->tuitionFee;
            	$courseChangeFlag = true;
            }

            if ($onePayment->description != TUITION){
            	//if this payment is not tution, save it with any process. ex matarial, enrolment or payment plan.
                $this->finalPaymentplan[] = $onePayment;
            }
            else
            {	
                if ($currentCourseTuition < $currentPayment)
                {
                	// current payment is bigger than tution.
                	// put current tuition and call next course and tution - remain.


                    
                    $temp1= new Outputform($onePayment->description, $onePayment->dueDate, $currentCourseTuition);
                    $temp1->courseName = $currentCourse->courseName;
                    $this->finalPaymentplan[]=$temp1;
                      



                    $remain = $currentCourseTuition - $currentPayment;

                    // remain is now negative.


                    
                    while ($remain <0 ) {
                    	// call next course
                    	$currentCourse = $this->selectedCourseDataDetail[$courseCnt++];
                    	$currentCourseTuition = $currentCourse->tuitionFee;
                       	$courseChangeFlag = true;
                       	// remain is negative, and difference can be both positive and negative 
                       	$diff = $remain + $currentCourseTuition;
 // To delete      
/*
                       	$temp1= new Outputform("diff", $onePayment->dueDate, (abs($remain)));
                       	if($diff > 0  ){
                       		$temp1->courseName = "positive";	
                       	} else $temp1->courseName = "negative or 0";	
               			$this->finalPaymentplan[]=$temp1;
*/                    	 

                       	if($diff > 0  ){
                       		// if current course tution is bigger than the rest remaining payment fee, save remain, and deduct current course tution.
                    		$currentCourseTuition += $remain;
                    		$temp1= new Outputform($onePayment->description, $onePayment->dueDate, (abs($remain)));
                    		$temp1->courseName = $currentCourse->courseName;
                    		$this->finalPaymentplan[]=$temp1;		
                    		break;
                       	} else {
                       		$remain += $currentCourseTuition;
// To delete
                       		/*
	                       	$temp1= new Outputform("diff", $onePayment->dueDate, (abs($remain)));
	                       	if($diff > 0  ){
	                       		$temp1->courseName = "positive REMAIN";	
	                       	} else $temp1->courseName = "negative or 0 REMAIN";	
	                       	$this->finalPaymentplan[]=$temp1;
	                       	*/
// To delete                

                       		$temp1= new Outputform($onePayment->description, $onePayment->dueDate, $currentCourseTuition);
                       		$temp1->courseName = $currentCourse->courseName;
                       		$this->finalPaymentplan[]=$temp1;
                       		//break;

                       	}


                    }
                   

                }
                else
                {
                    
                    $currentCourseTuition -= $currentPayment;
                    if ($currentCourseTuition >= 0)
                    {
                    	$temp1= new Outputform($onePayment->description, $onePayment->dueDate, $onePayment->amount);
                    	$temp1->courseName = $currentCourse->courseName;
                        $this->finalPaymentplan[]=$temp1;
                    }
                    
                }
                if($currentCourseTuition == 0){
                    $courseChangeFlag = false;
                }


            }


        }
                $this->finalPaymentplan[]= new Outputform("Total", "", $this->total);
                $this->finalPaymentplan[] = $this->getCourseDetailOutput();
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
	
		if($this->receivedata->getuseDiscountFlag()){
			$tuition[$courseCnt-1]-=$this->receivedata->getDiscount();
		}elseif($courseCnt==2){
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
			//$this->error .="hello22222<br/>";
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
	private function getNextPayment(){
		return LATINPAYMENT;
	}



	public function calculate4(){	
		//$this->error .="hello cal4 1<br/>";
		$tuition = array() ;
		$startdate =array();
		$courseName = array();
		
		$tempPaymentPlan = array();
		$tempPaymentDueDate = array();
		$tempCourseName = array();
		$aPayment = $this->getNextPayment();
		// get course name and its start date
		
		foreach ($this->selectedCourseNameNStartDate as $key => $value) {
			
			$courseName[] = $value[0];
			$startdate[]= $this->strToDate($value[1]);

		}

		// get tuition fees and make an array

		foreach ($this->selectedCourseDataDetail as $key => $value) {
			$tuition[] = $value->tuitionFee ;	
		}
		//$this->error .= "hello cal4 2<br/>";
		$courseCnt =count($tuition);
		
		$tuition = $this->checkDiscount($tuition);


		$currentTution=0;
		$counter = 0;
		$paymentCounter = 0;
		$startDateOfFirstCourse = $startdate[$counter];
		//$this->error .= "hello cal4 3<br/>";
		$tmpDuedate= new DateTime();

		foreach ($tuition as $value) {
			$currentTution = $value;
			$currentCourseName = $courseName[$counter];
			if($courseCnt == 1 ) {
				$tempPaymentDueDate[]=$this->today;
				$tempCourseName[]= $currentCourseName;
				$tempPaymentPlan[]= $aPayment;
				$currentTution-=$aPayment;
				$paymentCounter++;

			}
			
			if($currentTution > $aPayment ){
				
				while ($currentTution>0) {

					
					if($paymentCounter ==1){
						$tmpDuedate = $startDateOfFirstCourse->modify("-10 day");
					}
					else if($paymentCounter ==2){
						$tmpDuedate = $startDateOfFirstCourse->modify(LTSECONDPAYMENT);
					}
					else if($aPayment < 500){

					} else if($paymentCounter ==0){
						
					}
					else 
						$tmpDuedate = $tmpDuedate->modify(FOURWEEKS);
						
						
					
					
					$tempPaymentDueDate[]=$this->dateToString($tmpDuedate);
					$tempPaymentPlan[]=$aPayment;
					$tempCourseName[]=$currentCourseName;
					$paymentCounter++;
					$currentTution-=$aPayment;
					$aPayment= $this->getNextPayment();

					if($currentTution < $aPayment){
						if($currentTution != 0){
							$tempPaymentDueDate[]=$this->dateToString( $tmpDuedate->modify(FOURWEEKS));
							$tempPaymentPlan[]=$currentTution;
							$tempCourseName[]=$currentCourseName;
							$aPayment-=$currentTution;
						}
						break;
					}
				

				}
			}	

			$counter++;

		}

		$counter =0;
		foreach ($tempPaymentDueDate as $key => $value) {
			$outputPayment = new Outputform(TUITION, $value,$tempPaymentPlan[$counter]);
			$this->paymentPlan[]=$outputPayment;
			$counter++;
		}
		//print_r($this->paymentPlan);
		foreach ($this->paymentPlan as $key => $value) {
			# code...

			$this->total += $value->amount;
		}

		
		
		//===================================================================================================================
		 

                
	}


	public function calculate5(){	
		//$this->error .="hello cal4 1<br/>";
		$tuition = array() ;
		$startdate =array();
		$courseName = array();
		
		$tempPaymentPlan = array();
		$tempPaymentDueDate = array();
		$tempCourseName = array();
		$aPayment = LATINPAYMENT;
		



		
		foreach ($this->selectedCourseNameNStartDate as $key => $value) {
			
			$courseName[] = $value[0];
			$startdate[]= $this->strToDate($value[1]);

		}

		// get tuition fees and make an array

		foreach ($this->selectedCourseDataDetail as $key => $value) {
			$tuition[] = $value->tuitionFee ;	
		}
		
		$courseCnt =count($tuition);
		
		$tuition = $this->checkDiscount($tuition);

		//first payment takes second course $250;
		//$tuition[0]-=LTPCKFIRSTPAYMENT;
		$tuition[1]-=LATINPAYMENT;


		$currentTution=0;
		$counter = 0;
		$paymentCounter = 0;
		
		$remain = 0;

		$tempPaymentDueDate[]=$this->today;
		$tempCourseName[]= $courseName[$counter];
		$tempPaymentPlan[]= $aPayment;
		$paymentCounter++;

		
		
		$tmpDuedate= new DateTime();
		$currentStartDate = new DateTime();
		//$remainDate = new DateTime();
		foreach ($tuition as $value) {
			$currentStartDate = $startdate[$counter];
			$currentTution = $value;
			$currentCourseName = $courseName[$counter];
			if($remain != 0 && $count !=0){
				$tempPaymentDueDate[]=$tmpDuedate;
				$tempPaymentPlan[]=$remain;
				$tempCourseName[]=$currentCourseName;
				$currentTution-=$remain;
			}
			
						
			if($currentTution > $aPayment ){
				
				while ($currentTution>0) {

					
					if($paymentCounter ==1){
						$tmpDuedate = $currentStartDate->modify("-10 day");
					}
					else if($paymentCounter ==2){
						$tmpDuedate = $currentStartDate->modify(LTSECONDPAYMENT);
					}
					
					else 
						$tmpDuedate = $tmpDuedate->modify(FOURWEEKS);
						
						
					
					
					$tempPaymentDueDate[]=$this->dateToString($tmpDuedate);
					$tempPaymentPlan[]=$aPayment;
					$tempCourseName[]=$currentCourseName;
					$paymentCounter++;
					$currentTution-=$aPayment;
					//$aPayment= $this->getNextPayment();

					if($currentTution < $aPayment){
						if($currentTution != 0){
							$tempPaymentDueDate[]=$this->dateToString( $tmpDuedate->modify(FOURWEEKS));
							$tempPaymentPlan[]=$currentTution;
							$tempCourseName[]=$currentCourseName;
							$remian =$aPayment- $currentTution;

						}
						break;
					}
				

				}
			}	

			$counter++;
			$paymentCounter=1;

		}

		$counter =0;
		foreach ($tempPaymentDueDate as $key => $value) {
			$outputPayment = new Outputform(TUITION, $value,$tempPaymentPlan[$counter]);
			$this->paymentPlan[]=$outputPayment;
			$counter++;
		}
		//print_r($this->paymentPlan);
		foreach ($this->paymentPlan as $key => $value) {
			# code...

			$this->total += $value->amount;
		}

		
		
		//===================================================================================================================
		 

                
	}




	public function singlecourse(){
		$tuition ;
		$startdate;
		$reminder ;
		$courseName ;
		$this->error .="start single <br/>";

		foreach ($this->selectedCourseNameNStartDate as  $value) {
				# code...
			$this->error .="hello".$courseName = $value[0];
			$startdate= $this->strToDate($value[1]);

		}

		foreach ($this->selectedCourseDataDetail as $key => $value) {
				# code...
			$reminder = $tuition = $value->tuitionFee -= $this->fee->single;

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
				//$this->error .="hello".print_r($this->paymentPlan);
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
