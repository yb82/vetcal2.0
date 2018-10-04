<?php
	require_once ('class/Startdate.php');
	
	$startdates= new Startdate();

?>
<head>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/startdate.css">
</head>

	<p>Start Date</p>
	<table class="startdatetable">
		<tr><th>Category</th><th>Start Dates</th></tr>
		<?php
			//echo $startdates->outputLine;
			echo $startdates->PrintStartDate();
		?>
	</table>
	<p id="pp" onclick="editable()"> hi</p>
	<button value="update">aaaa</button>

	<script type="text/javascript">
		
		function editable() {
			document.getElementById("pp").contentEditable = true;
		}
		function update() {


			$.post( "./update.php", {  aaaa : courseData })
    			.done(function( data ) {
      			if(data=="[]"){
        			alert( "No data!!!" );
      			} 
		      	else {
		        	var s_Data= jQuery.parseJSON( data );
		        	document.getElementById('result').innerHTML = "";


		      		var output ="<table class =\"table is-narrow\">" ;
		        	output += "<tr  ><th>Due Date</th><th >Fee Description</th><th>Course Name</th><th>Payment Amount</th></tr>"
		        	var tmpCourseName ="";

		        	for(var i =  0 ; i < s_Data.length; i ++) {

		          		if(tmpCourseName != s_Data[i]["courseName"]){
		            		output += '<tr><td>'+s_Data[i]["dueDate"]+"</td><td>"+s_Data[i]["description"]+"</td><td style='font-weight: bold;'>"+s_Data[i]["courseName"]+"</td><td>$"+s_Data[i]["amount"]+"</td></tr>";  
		          		} else{
		          			output += '<tr><td>'+s_Data[i]["dueDate"]+"</td><td>"+s_Data[i]["description"]+"</td><td>"+s_Data[i]["courseName"]+"</td><td>$"+s_Data[i]["amount"]+"</td></tr>";
		          		}
		          		tmpCourseName = s_Data[i]["courseName"]

		        	}
		        
		      }           
		      
      
    		});
		}
	</script>
