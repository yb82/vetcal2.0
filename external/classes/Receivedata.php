<?php
require_once("./classes/StudentDetail.php");
class Receivedata{
	private $course1name, $course1startdate , $course1finishdate;
	private $course2name, $course2startdate, $course2finishdate;
	private $course3name, $course3startdate, $course3finishdate;
	private $course4name, $course4startdate, $course4finishdate;
	private $course5name, $course5startdate, $course5finishdate;
	private $course6name, $course6startdate, $course6finishdate;
	private $paymentOption;
	private $courseData;
	private $application;
	private $promotion = false;
		//private $finishdates;
	private $studentDetail;


		//private $flag1 = flase, $flage2 = false, $flag3=false, $flag4= false, $flag5=false, $flag6=false;

	public function __construct(){
		$this->courseData = Array();
		$this->studentDetail = new StudentDetail(); 
			//$this->$finishdates = Array() ;

		$flag = true;
		if(isset($_POST["course1name"])){
			$this->course1name = $_POST["course1name"];
		} 	else $flag = false;
		if(isset($_POST["course1startdate"])){
			$this->course1startdate = $_POST["course1startdate"];
		}	else $flag = false;

		if(isset($_POST["finish1"])){
			$this->course1finishdate = $_POST["finish1"];
		} else $flag = false;


		if($flag){

			$this->courseData[] = Array($this->course1name, $this->course1startdate,$this->course1finishdate) ;

		}



		$flag = true;
		if(isset($_POST["course2name"])){
			$this->course2name = $_POST["course2name"];
		} 	else $flag = false;
		if(isset($_POST["course2startdate"])){
			$this->course2startdate = $_POST["course2startdate"];
		}	else $flag = false;
		if(isset($_POST["finish2"])){
			$this->course2finishdate = $_POST["finish2"];
		} else $flag = false;


		if($flag){

			$this->courseData[] =  Array($this->course2name, $this->course2startdate,$this->course2finishdate)  ;
			
		}





		$flag = true;
		if(isset($_POST["course3name"])){
			$this->course3name = $_POST["course3name"];
		}	else $flag = false;
		if(isset($_POST["course3startdate"])){
			$this->course3startdate = $_POST["course3startdate"];
		}	else $flag = false;

		if(isset($_POST["finish3"])){
			$this->course3finishdate = $_POST["finish3"];
		} else $flag = false;


		if ($flag) {
				# code...
			$this->courseData[] = Array($this->course3name, $this->course3startdate,$this->course3finishdate) ;
		}

		$flag = true;
		if(isset($_POST["course4name"])){
			$this->course4name = $_POST["course4name"];
		}	else $flag = false;
		if(isset($_POST["course4startdate"])){
			$this->course4startdate = $_POST["course4startdate"];
		}	else $flag = false;

		if(isset($_POST["finish4"])){
			$this->course4finishdate = $_POST["finish4"];
		} else $flag = false;


		if ($flag) {
				# code...
			$this->courseData[] = Array($this->course4name, $this->course4startdate,$this->course4finishdate)  ;
			
		}


		$flag = true;
		if(isset($_POST["course5name"])){
			$this->course5name = $_POST["course5name"];
		}	else $flag = false;
		if(isset($_POST["course5startdate"])){
			$this->course5startdate = $_POST["course5startdate"];
		}	else $flag = false;


		if(isset($_POST["finish5"])){
			$this->course5finishdate = $_POST["finish5"];
		} else $flag = false;


		if ($flag) {
				# code...
			$this->courseData[] = Array($this->course5name, $this->course5startdate,$this->course5finishdate) ;

		}

		$flag = true;
		if(isset($_POST["course6name"])){
			$this->course6name = $_POST["course6name"];
		}	else $flag = false;

		if(isset($_POST["course6startdate"])){
			$this->course6startdate = $_POST["course6startdate"];
		}	else $flag = false;

		if(isset($_POST["finish6"])){
			$this->course6finishdate = $_POST["finish6"];
		} else $flag = false;


		if ($flag) {
				# code...
			$this->courseData[] = Array($this->course6name, $this->course6startdate,$this->course6finishdate) ;

		}


		if(isset($_POST["Paymentoption"])){
			$this->paymentOption = true;
		}	
		if(isset($_POST["promotion"]) && $_POST["promotion"]== "promotion10"){
			$this->promotion = true;
		}

		if(isset($_POST["fname"])){
			$this->studentDetail->fName = $_POST["fname"];
		} 	
		if(isset($_POST["lname"])){
			$this->studentDetail->lName = $_POST["lname"];
		} 	
		if(isset($_POST["dob"])){
			$this->studentDetail->dateOfBirth = $_POST["dob"];
		} 	
		if(isset($_POST["passport"])){
			$this->studentDetail->passportNo = $_POST["passport"];
		} 	
		if(isset($_POST["phone"])){
			$this->studentDetail->contact = $_POST["phone"];
		} 	
		if(isset($_POST["gender"])){
			$this->studentDetail->gender =$_POST["gender"];
		}
		if(isset($_POST["address"])){
			$this->studentDetail->currentAddr = $_POST["address"];
		} 	
		if(isset($_POST["email"])){
			$this->studentDetail->email = $_POST["email"];
		} 	
		if(isset($_POST["visa"])){
			if($_POST["visa"] =="other" && isset($_POST["othervisa"])){
				$this->studentDetail->visa = $_POST["othervisa"];
			}
			$this->studentDetail->visa = $_POST["visa"];
		} 	
		if(isset($_POST["insurance"])){
			$this->studentDetail->insurance = $_POST["insurance"];
		} 	
		if(isset($_POST["nation"])){
			$this->studentDetail->nation = $_POST["nation"];
		} 	
		if(isset($_POST["usi"])){
			$this->studentDetail->usi = $_POST["usi"];
		}
		if(isset($_POST["englvl"])){
			$this->studentDetail->englvl = $_POST["englvl"];
		}
		if(isset($_POST["dibp"])){
			$this->studentDetail->dibp = $_POST["dibp"];
		}
		if(isset($_POST["otherschool"])){
			$this->studentDetail->otherschool = $_POST["otherschool"];
		}
		if(isset($_POST["undertake"])){
			$this->studentDetail->undertake = $_POST["undertake"];
		}
		if(isset($_POST["application"])){
			$this->studentDetail->application =$_POST["application"];
		} else $this->studentDetail->application =0;
		if(isset($_POST["agent"])){
			$this->studentDetail->agent =$_POST["agent"];
		} else $this->studentDetail->agent = "Direct";







	}

	public function getPaymentOption(){
		return $this->paymentOption;
	}
	public function getUserCourseData(){
		return $this->courseData;
	}
	public function getStudentDetail(){
		return $this->studentDetail;
	}
	public function getPromotionFlag(){
		return $this->promotion;
	}

}