<?php
header("Progma:no-cache");
header("Cache-Control:no-cache,must-revalidate");
require_once('./classes/Course.php');
require_once('./classes/Fee.php');
require_once('./classes/Datahandler.php');
$data = new Datahandler();

//print_r($data->courseData);
           	  //	print_r($data->courseData);
//include ('../header.php');
?>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel ="stylesheet" type="text/css" href="./css/calculator.css">


<style type="text/css">

  .coursename{
    width: 496px;
  }

  .coursesection{
    display: none;
  }
  .coursename {
    border-color: whitesmoke;
    background-color: #fffdf5;
    border-radius: 3px;
    margin-bottom: 5px;

  }
  .coursetitle{
    background-color: #ffdd57;
    color: rgba(0, 0, 0, 0.7);
  }
  .coursedetail{

    color: #3b3108;
    border-radius: 3px;
    border-color: #ffdd57;

  }
  .main{
    margin: auto;
    width: 60%;
    
    padding: 5px;
  }
  .items{
    padding-right: 2px;
    padding-left:  2px;
    padding-top:  2px;
    padding-bottom:  4px;
  }
  td.personalDetail{

    width: 25%;
    
  }  

  .personalDetail2{
    padding:  6px;
    width: 200px;
    margin: 3px;
  }

  .address1{
    padding:  6px;
    width:250px;
    margin: 3px;
  }
  .header{
    text-align: left;
    padding-left: 20px;
    padding-top: 20px;
  }
  .selectbox{
	height:380px ;
	width:550px;
  }
 .mainimg{
	 clear: both; 
	 display: block; 
	 margin: auto; 
	 width: 60%; 
	 padding: 5px;
 }


</style>

<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="./js/calculator.js"></script>
<img src="../images/header1.PNG"/ class="mainimg">
<div class = "main">
  
  <form name="certform"  id="certform" method="post" action="./update.php">

    <div class="tile notification is-light ">
      <b>Thank you for choosing ALS and using our online Enrolment Form. <br/>Please fill in the fields here and we will respond with a letter of offer within 24 hours.<br/>
      If you have any questions about this process, please contact us at enrol@alscertificates.com<br/><br/>
      First choose the courses you are interested, then complete your personal details.</b>

    </div>

    <table style='width:370px;'>
      <tr>
        <td style='width:160px; '>
          <b>Courses </b><br/>
          <select multiple="multiple" id='lstBox1'  class ="selectbox">
            <?php

            echo $data->loadCourseName();


            ?>
          </select>
        </td>
        <td style='width:50px;text-align:center;vertical-align:middle;'>
          <input type='button' id='btnRight' value ='  >  '/>
          <!-- <br/><input type='button' id='btnLeft' value ='  <  '/> -->
        </td>
        <td style='width:160px;'>
          <b>Selected Course </b><br/>
          <select multiple="multiple" id='lstBox2' class ="selectbox">

          </select>
        </td>
      </tr>
    </table>
    <b>Payment Option</b>
    <br/>

    <input type="radio" name="Paymentoption" value="1" id="option1" checked="true">&nbsp;Option 1&nbsp;&nbsp;
    <input type="radio" name="Paymentoption" id="option2" value="2">&nbsp;Option 2&nbsp;&nbsp;
    <input type="radio"  id="option3" style="display: float; display: none;" name="Paymentoption" value="3" ><lable id="option31" style="display: none;">&nbsp;Option 3</lable>
    <input type="radio"  id="option4" style="display: float;" name="Paymentoption" value="Pay Upfront" ><lable id="option4" >&nbsp;Pay Upfront</lable>
    
    <br/>
    <br/>
    

<!--
  <div id="1-course" style="display:none"> -->
    <div id="course1"  class = "message is-black">
      <div class = "message-header">
        1. Course  <br/>
      </div>
      <div class = "message-body">
       Course Name <input  id="course1name" type="text" class="coursename" name = "course1name" /><br/>
       Course Duration <input id="course1duration" type="text" name = "course1duration" /><br/>
       Course Start Date: <select id="1st" name = "course1startdate"></select>  Finish Date: <input type="text" id="finish1" name= "finish1" readonly="readonly"></input><br/>
     </div>
   </div>



   <div id="course2"   class = "message is-black"  >
    <div class = "message-header">
      2. Course
    </div>
    <div class = "message-body">
     Course Name <input id="course2name" type="text" class="coursename" name = "course2name"/> <br/> 
     Course Duration <input id="course2duration" type="text" name = "course3duration" /><br/>
     Course Start Date: <select id="2nd"  name = "course2startdate"></select>  Finish Date: <input type="text" id="finish2" name= "finish2" readonly="readonly"></input><br/>
   </div>
 </div>





 <div id="course3"   class = "message is-black" >
  <div class = "message-header">
    3. Course
  </div>
  <div class = "message-body">
   Course Name <input class="coursename" id="course3name" type="text" name = "course3name"/><br/>
   Course Duration <input id="course3duration" type="text" name = "course3duration" /><br/>
   Course Start Date: <select id="3rd" name = "course3startdate"></select>  Finish Date: <input type="text" id="finish3" name= "finish3" readonly="readonly" ></input><br/>
 </div>
</div>




<div id="course4"   class = "message is-black"  >
  <div class = "message-header">
    4. Course
  </div>
  <div class = "message-body">
    Course Name <input class="coursename" id="course4name" type="text" name = "course4name"/><br/>
    Course Duration <input id="course4duration" type="text" name = "course4duration"  /><br/>
    Course Start Date: <select id="4th"  name = "course4startdate"></select>  Finish Date: <input type="text" id="finish4" name= "finish4" readonly="readonly"></input><br/>
  </div>
</div>


<div id="course5"   class = "message is-black"  >
  <div class = "message-header">
    5. Course 
  </div>
  <div class = "message-body">
    Course Name <input class="coursename" id="course5name" type="text" name = "course5name"/> <br/>
    Course Duration <input id="course5duration" type="text" name = "course5duration" /><br/>
    Course Start Date: <select id="5th"  name = "course5startdate"></select>  Finish Date: <input type="text" id="finish5" name= "finish5" readonly="readonly"></input><br/>
  </div>
</div>


<div id="course6"   class = "message is-black"  >
  <div class = "message-header">

    6. Course 
  </div>
  <div class = "message-body">
   Course Name <input class="coursename" id="course6name" type="text" name = "course6name"/> <br/>
   Course Duration <input id="course6duration" type="text" name = "course6duration"  /><br/>
   Course Start Date: <select id="6th"  name = "course6startdate"></select>  Finish Date: <input type="text" id="finish6" name= "finish6" readonly="readonly"></input><br/>
 </div>

</div>
<br/>
<br/>
<input type="button" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check Payment Plan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" id="submitform" class= "button is-dark is-large"  />
<input type="button" value="Complete Application Details" id="createform" class= "button is-dark is-large" style="display: none" />
<input type="button" value="Reset" class= "button is-light is-large"  onClick="window.location.reload()">
<br/>
<br/>
<div title="Create Applicaiton form" id="createapplication" style="display: none"  >


  <div id="personalinformation" >
    <b>Personal Information</b>
    <br/><br/>
    <table>
     <tr>
       <td class="personalDetail">First Name : </td>
       <td><input type="text" class="personalDetail2" name="fname" id="fname" required="true"></td>
       <td class="personalDetail">Phone : </td>
       <td><input class="personalDetail2" type="text" name="phone"></td>


     </tr>

     <tr>
      <td class="personalDetail"> Last Name:</td>
      <td ><input class="personalDetail2" type="text" name="lname" required="true"></td>
      <td class="personalDetail"> Email:</td>
      <td  ><input type="text" class="personalDetail2" name="email" placeholder="example@ihbrisbane.com.au"></td>
    </tr>

    <tr>
      <td class="personalDetail"> Date of Birth:</td>
      <td><input class="personalDetail2" type="text" name="dob" placeholder="dd/mm/YYYY" required="true"></td>
      <td class="personalDetail"> USI : </td>
      <td  ><input class="personalDetail2" type="text" name="usi"></td>
    </tr>

    <tr>
      <td class="personalDetail"> Gender:</td>
      <td><input type="radio" name="gender" value="Male" checked="true">&nbsp;Male&nbsp;&nbsp;<input type="radio" name="gender" value="Female">&nbsp;Female&nbsp;&nbsp; </td>
      <td class="personalDetail"> English Level : </td><td><select class="personalDetail2" type="select" name="englvl">
      <option value="Pre-Intermediate">Pre-Intermediate</option>
      <option value="Intermediate">Intermediate</option>
      <option value="Upper-Intermediate">Upper-Intermediate</option>
      <option value="Advanced">Advanced</option>
    </select></td>
  </tr>

  <tr>
    <td class="personalDetail"> Nationality : </td><td > <input class="personalDetail2" type="text" name="nation" required="true"></td>
  </tr>

  <tr>
    <td class="personalDetail"> Passport No. : </td><td  ><input class="personalDetail2" type="text" name="passport"></td>
  </tr>

  <tr>
    <td class="personalDetail"> Address:</td><td ><input type="text" class="address1" name="address" ></td>
  </tr>

  <tr> 
    <td class="personalDetail">Agent:</td><td ><input type="text" class="personalDetail2" name="agent" ></td>
  </tr>


  <tr>
  </tr>

</table>
</div>
<br/><br/>


  <p style="font-size: 20px">You may be required to complete a Genuine Temporary Entrant Statement; our enrolment team will advise you if so. Details for this can be found <a herf="http://www.ihbrisbane.com.au/applying-student-visa/">here</a></p>

<br>
<br>

<div id="visadetail">
  <b>Visa Detail </b>
  <table>
    <tr><td class="personalDetail"> Visa:</td><td>
      <input type="radio" name="visa" value="Student" checked="true">&nbsp;Student&nbsp;&nbsp;
      <input type="radio" name="visa" value="Business" >&nbsp;Business&nbsp;&nbsp;
      <input type="radio" name="visa" value="Dependent" >&nbsp;Dependent&nbsp;&nbsp;
      <input type="radio" id="other" name="visa" value="Other">&nbsp;Other&nbsp;&nbsp; </td></tr>

      <tr id="othervisa" class="personalDetail" style="display:none;"><td>Please specifiy your visa </td><td><input class="personalDetail1" type="text" name="othervisa"  ></td></tr>

      <tr><td class="personalDetail"> DIBP Office : </td><td><input class="personalDetail2" type="text" name="dibp"></td></tr>
    </table>
    <br/>
    Are you currently enrolled at another institution in Australia?  <input type="radio" name="otherschool" value="Yes" >&nbsp;Yes&nbsp;&nbsp;<input type="radio" name="otherschool" value="No" checked="true">&nbsp;No&nbsp;&nbsp; <br/>
    If YES, is this additional study you wish to undertake?
    <input type="radio" name="undertake" value="Yes" >&nbsp;Yes&nbsp;&nbsp;<input type="radio" name="undertake" value="No" checked="true">&nbsp;No&nbsp;&nbsp;(If No, a letter of release is required)<br/> <br/>
  </div>

  <br/>
  <div id="oshc">
    <b>Insurance Detail</b><br/><br/>

    <b>OSHC</b>(<b>O</b>verseas <b>S</b>tudent <b>H</b>ealth <b>C</b>over - Compulsory requirement for student visa holder from arrival in Australia)<br/><br/>

    Do you want IH Brisbane - ALS to arrange OSHC for you?<br/><br/>
    <input type="radio" name="insurance" value="None" checked="true">&nbsp;No required&nbsp;&nbsp;
    <input type="radio" name="insurance" value="Single">&nbsp;Single&nbsp;&nbsp;
    <input type="radio" name="insurance" value="Couple">&nbsp;Couple&nbsp;&nbsp; 
    <input type="radio" name="insurance" value="Family">&nbsp;Family&nbsp;&nbsp; 

    <br/><br/>

    <table>
      <tbody>
        <tr>
          <td>Single Rate</td><td>Couple Rate</td><td>Family Rate</td>
        </tr> 
        <tr>
          <td>$49 per month</td><td>$138 per month</td><td>$200 per month</td>
        </tr>   
      </tbody>
    </table>
  </div>
  <br/><br/>

  <input type="checkbox" id="agree" name="agree">&nbsp;&nbsp;I have read and understood the  <a target="_blank" href="./termsandcondtion.pdf">Terms and Conditions</a>, including the Cancellation and Refund Policy.<br/><br/>


  <input type="checkbox" id="agree1" name="agree1">&nbsp;&nbsp;I confirm that I have sufficient funds to pay for all tuition fees, accommodation and all other personal expenses during the full period of my course.<br/><br/>

  <input type="checkbox" id="agree2" name="agree2">&nbsp;&nbsp;I certify that all information given by me in this application is accurate and correct.<br/><br/>



  <input type="button" value="Create Application" id="submitAppform" class= "button is-dark is-large"  />
  <br/><br/>


</div>

<div id="dialog-confirm" title="Confirm Detail" style="display:none" >






</div>
<div id="dialog-confim-application" title="Thanks for choosing ALS" style="display:none;" >
    <label style="font-size: 17px; margin: 10px;">Your Enrolment Form has been created in a new tab.</label><br/> 
    <label style="font-size: 17px; margin: 10px;">Please check the details, save as a pdf and follow the steps to enrol.</label><br/>
    </label>
  </div>

</form>
