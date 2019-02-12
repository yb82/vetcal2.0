



$(document).ready(function() {
  var course2duration,course2StartDate;
  var course3duration,course3StartDate;
  var course4duration,course4StartDate;
  var course5duration,course5StartDate;
  var course6duration,course6StartDate;

  var monthNames = new Array();

  monthNames[0] = "01";
  monthNames[1] = "02";
  monthNames[2] = "03";
  monthNames[3] = "04";
  monthNames[4] = "05";
  monthNames[5] = "06";
  monthNames[6] = "07";
  monthNames[7] = "08";
  monthNames[8] = "09";
  monthNames[9] = "10";
  monthNames[10] = "11";
  monthNames[11] = "12";

  var dateFlag = 0;
  $("#finish1").val("");
  $("#finish2").val("");
  $("#finish3").val("");
  $("#finish4").val("");
  $("#finish5").val("");
  $("#finish6").val("");

  $("#submitform").click(function(e){
    var selectedCourses = $("#lstbox2 option").length;
    var flag = true;
    switch(selectedCourses){

      case 1:

      if($("#1st").val() == "-"){
        flag = false;
      }

      break;
      
      case 2:
      if($("#1st").val() == "-"){
        flag = false;
      }
      if($("#2nd").val() == "-"){
        flag = false;
      }
      break;
      
      case 3:
      if($("#1st").val() == "-"){
        flag = false;
      }
      if($("#2nd").val() == "-"){
        flag = false;
      }
      if($("#3rd").val() == "-"){
        flag = false;
      }

      break;
      
      case 4:
      if($("#1st").val() == "-"){
        flag = false;
      }
      if($("#2nd").val() == "-"){
        flag = false;
      }
      if($("#3rd").val() == "-"){
        flag = false;
      }if($("#4th").val() == "-"){
       flag = false;
     }
     break;

     case 5:
     if($("#1st").val() == "-"){
      flag = false;
    }
    if($("#2nd").val() == "-"){
      flag = false;
    }
    if($("#3rd").val() == "-"){
      flag = false;
    }if($("#4th").val() == "-"){
      flag = false;
    }if($("#5th").val() == "-"){
      flag = false;
    }

    break;

    case 6:
    if($("#1st").val() == "-"){
      flag = false;
    }
    if($("#2nd").val() == "-"){
      flag = false;
    }
    if($("#3rd").val() == "-"){
      flag = false;
    }
    if($("#4th").val() == "-"){
      flag = false;
    }
    if($("#5th").val() == "-"){
      flag = false;      

    }
    if($("#6th").val() == "-"){
      flag = false;
    }
    break;
    default:
    alert("Please select at least 1 course!!");
    e.preventDefault();
    return false;
    break;
  }
  if (!flag) {
   alert("Please check your start dates!");
   e.preventDefault();
   return false;
 } 
 else{
  $(".items").remove();
  var output ="<table class='items'><th class = 'items' style='width:400px' >Course Name</th><th class = 'items' style='width:160px '>Course Start Date</th>";
  switch (selectedCourses){
    case 1:
    output += '<tr><td class="items">'+$("#course1name").val()+'</td><td class="items">'+$("#1st").val()+'</td></tr>';
    break;

    case 2:
    output += '<tr><td class="items">'+$("#course1name").val()+'</td><td class="items">'+$("#1st").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course2name").val()+'</td><td class="items">'+$("#2nd").val()+'</td></tr>';
    break;

    case 3:
    output += '<tr><td class="items">'+$("#course1name").val()+'</td><td class="items">'+$("#1st").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course2name").val()+'</td><td class="items">'+$("#2nd").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course3name").val()+'</td><td class="items">'+$("#3rd").val()+'</td></tr>';
    break;

    case 4:
    output += '<tr><td class="items">'+$("#course1name").val()+'</td><td class="items">'+$("#1st").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course2name").val()+'</td><td class="items">'+$("#2nd").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course3name").val()+'</td><td class="items">'+$("#3rd").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course4name").val()+'</td><td class="items">'+$("#4th").val()+'</td></tr>';
    break;

    case 5:
    output += '<tr><td class="items">'+$("#course1name").val()+'</td><td class="items">'+$("#1st").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course2name").val()+'</td><td class="items">'+$("#2nd").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course3name").val()+'</td><td class="items">'+$("#3rd").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course4name").val()+'</td><td class="items">'+$("#4th").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course5name").val()+'</td><td class="items">'+$("#5th").val()+'</td></tr>';
    break;

    case 6:
    output += '<tr><td class="items">'+$("#course1name").val()+'</td><td class="items">'+$("#1st").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course2name").val()+'</td><td class="items">'+$("#2nd").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course3name").val()+'</td><td class="items">'+$("#3rd").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course4name").val()+'</td><td class="items">'+$("#4th").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course5name").val()+'</td><td class="items">'+$("#5th").val()+'</td></tr>';
    output += '<tr><td class="items">'+$("#course6name").val()+'</td><td class="items">'+$("#6th").val()+'</td></tr>';
    break;


  }
  output += "</table><br/><br/><label class='items'>Is this information correct?</label>"

  $("#dialog-confirm").append(output);
  

}
$( "#dialog-confirm" ).dialog({
  resizable: true,
  width: 550,
  height: 400,
  modal: true,
  buttons: {
    "Confirm": function() {
     $( this ).dialog( "close" );

     var newDialog = window.open('about:blank', "_form");
     document.forms["certform"].target='_form';
     document.forms["certform"].submit();

           //$("#certform").submit();
           
           
         },
         Cancel: function() {
          $( this ).dialog( "close" );
          return false;
        }
      }
    });

});


$( "#1st" ).change(function() {
  var startdate = $("#1st option:selected").val();
  var tempDate = startdate.split("/");
  var now = new Date(tempDate[2],tempDate[1]-1,tempDate[0]);
  var duration = $("#course1duration").val();
  now.setDate(now.getDate()+(duration * 7)-3);
  $("#finish1").val(now.getDate()+"/"+(monthNames[now.getMonth()])+"/"+now.getFullYear());
});

$( "#2nd" ).change(function() {
  var startdate = $("#2nd option:selected").val();
  var tempDate = startdate.split("/");
  var now = new Date(tempDate[2],tempDate[1]-1,tempDate[0]);
  var duration = $("#course2duration").val();
  now.setDate(now.getDate()+(duration * 7)-3);
  $("#finish2").val(now.getDate()+"/"+(monthNames[now.getMonth()])+"/"+now.getFullYear());
});

$( "#3rd" ).change(function() {
  var startdate = $("#3rd option:selected").val();
  var tempDate = startdate.split("/");
  var now = new Date(tempDate[2],tempDate[1]-1,tempDate[0]);
  var duration = $("#course3duration").val();
  now.setDate(now.getDate()+(duration * 7)-3);
  $("#finish3").val(now.getDate()+"/"+(monthNames[now.getMonth()])+"/"+now.getFullYear());
});

$( "#4th" ).change(function() {
  var startdate = $("#4th option:selected").val();
  var tempDate = startdate.split("/");
  var now = new Date(tempDate[2],tempDate[1]-1,tempDate[0]);
  var duration = $("#course4duration").val();
  now.setDate(now.getDate()+(duration * 7)-3);
  $("#finish4").val(now.getDate()+"/"+(monthNames[now.getMonth()])+"/"+now.getFullYear());
});

$( "#5th" ).change(function() {
  var startdate = $("#5th option:selected").val();
  var tempDate = startdate.split("/");
  var now = new Date(tempDate[2],tempDate[1]-1,tempDate[0]);
  var duration = $("#course5duration").val();
  now.setDate(now.getDate()+(duration * 7)-3);
  $("#finish5").val(now.getDate()+"/"+(monthNames[now.getMonth()])+"/"+now.getFullYear());
});


$( "#6th" ).change(function() {
  var startdate = $("#6th option:selected").val();
  var tempDate = startdate.split("/");
  var now = new Date(tempDate[2],tempDate[1]-1,tempDate[0]);
  var duration = $("#course6duration").val();
  now.setDate(now.getDate()+(duration * 7)-3);
  $("#finish6").val(now.getDate()+"/"+(monthNames[now.getMonth()])+"/"+now.getFullYear());
});
$("#createform").click(function(e){
  $("#createapplication").slideDown();
  $("#submitform").hide(1000);
  $("#fname").focus();
});
$("#option4").click(function(){
  $("#submitform").hide(1000);
});
$("#option1").click(function(){
  $("#submitform").show(1000);
});

$("#option2").click(function(){
  $("#submitform").show(1000);
});

$("#option3").click(function(){
  $("#submitform").show(1000);
});


$("#submitAppform").click(function(e){
  var flag1 = true;
  var flag2 = true;
  var flag3 = true;
  if(!$('#agree').is(":checked")){
    flag1=false;
  } else if(!$('#agree1').is(":checked")){
    flag2=false;
  } else if(!$('#agree2').is(":checked")){
    flag3=false;
  }
  
  if (flag1 && flag2 && flag3) {

    var selectedCourses = $("#lstbox2 option").length;
    var flag = true;
    switch(selectedCourses){

      case 1:

      if($("#1st").val() == "-"){
        flag = false;
      }

      break;

      case 2:
      if($("#1st").val() == "-"){
        flag = false;
      }
      if($("#2nd").val() == "-"){
        flag = false;
      }
      break;

      case 3:
      if($("#1st").val() == "-"){
        flag = false;
      }
      if($("#2nd").val() == "-"){
        flag = false;
      }
      if($("#3rd").val() == "-"){
        flag = false;
      }

      break;

      case 4:
      if($("#1st").val() == "-"){
        flag = false;
      }
      if($("#2nd").val() == "-"){
        flag = false;
      }
      if($("#3rd").val() == "-"){
        flag = false;
      }if($("#4th").val() == "-"){
       flag = false;
     }
     break;

     case 5:
     if($("#1st").val() == "-"){
      flag = false;
    }
    if($("#2nd").val() == "-"){
      flag = false;
    }
    if($("#3rd").val() == "-"){
      flag = false;
    }if($("#4th").val() == "-"){
      flag = false;
    }if($("#5th").val() == "-"){
      flag = false;
    }

    break;

    case 6:
    if($("#1st").val() == "-"){
      flag = false;
    }
    if($("#2nd").val() == "-"){
      flag = false;
    }
    if($("#3rd").val() == "-"){
      flag = false;
    }
    if($("#4th").val() == "-"){
      flag = false;
    }
    if($("#5th").val() == "-"){
      flag = false;      

    }
    if($("#6th").val() == "-"){
      flag = false;
    }
    break;
    default:
    alert("Please select at least 1 course!!");
    e.preventDefault();
    return false;
    break;
  }
  if (!flag) {
   alert("Please check your start dates!");
   e.preventDefault();
   return false;
 }else{
  $( "#dialog-confim-application" ).dialog({
    resizable: true,
    width: 650,
    height: 250,
    modal: true,
    buttons: {
      "Confirm": function() {
       $( this ).dialog( "close" );
       $("#certform").append("<input name=\"application\" id=\"application\" type=\"text\" value=\"1\">");
       var newDialog = window.open('about:blank', "abc");
       document.forms["certform"].target='abc';
       document.forms["certform"].submit();
       $("#application").remove();


     },
     Cancel: function() {
      $( this ).dialog( "close" );
      return false;
    }
  }
});
  
} 





} 
else{
  alert("please agree with policy");
  return false;
}



});


  /*$("#createform").click(function(e){
    $( "#createapplication" ).dialog({
        resizable: true,
        width: 650,
        height: 600,
        modal: true,
        buttons: {
          "Confirm": function() {
           $( this ).dialog( "close" );
           $("#createapplication").slideDown();
           //$("#certform").submit();
           
           
         },
         Cancel: function() {
          $( this ).dialog( "close" );
          return false;
        }
      }
    });

  });*/

  $('#other').click(function (e) {
    $('#othervisa').slideDown();
  });


  $('#btnRight').click(function(e) {
    var course1duration;
    var course1StartDate;
    var selectedOpts = $('#lstBox1 option:selected');
    if (selectedOpts.length == 0) {
      alert("Nothing to move.");
      e.preventDefault();
      return;

    }

    $('#lstBox2').append($(selectedOpts).clone());

    var selectedCourses = $("#lstbox2 option").length;




    switch(selectedCourses){
      case 1:
      var courseName = $("#lstbox2 option").eq(0).val();
      $.post( "./update.php", { duration: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } 
        else {
          var s_Data= jQuery.parseJSON( data );
          $("#course1duration").val(s_Data[0]);
          $('#1st').append($('<option>', {value:"-", text: "-"}));



          for(var i = 1 ; i < s_Data[1].length; i ++) {


            $('#1st').append($('<option>', {value:s_Data[1][i], text: s_Data[1][i]}));  

          }
        }           
      });
      $("#course1").slideDown();
      $("#createform").slideDown();
      
      $('#course1name').val(selectedOpts.val());
      break;

      case 2:
      var courseName = $("#lstbox2 option").eq(1).val();
      $.post( "./update.php", { duration: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } 
        else {
          var s_Data= jQuery.parseJSON( data );
          $("#course2duration").val(s_Data[0]);
          $('#2nd').append($('<option>', {value:"-", text: "-"}));
          for(var i = 1 ; i < s_Data[1].length; i ++) {
            $('#2nd').append($('<option>', {value:s_Data[1][i], text: s_Data[1][i]}));
          }
        }           
      });
      $("#course2").slideDown();
      $("#option3").slideDown();
      $("#option31").slideDown();
      $('#course2name').val(selectedOpts.val());
      break;

      case 3:
      var courseName = $("#lstbox2 option").eq(2).val();
      $.post( "./update.php", { duration: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } 
        else {
          var s_Data= jQuery.parseJSON( data );
          $("#course3duration").val(s_Data[0]);
          $('#3rd').append($('<option>', {value:"-", text: "-"}));    
          for(var i = 1 ; i < s_Data[1].length; i ++) {
            $('#3rd').append($('<option>', {value:s_Data[1][i], text: s_Data[1][i]}));
          }
        }           
      });
      $("#course3").slideDown();
      $('#course3name').val(selectedOpts.val());
      break;

      case 4:
      var courseName = $("#lstbox2 option").eq(3).val();
      $.post( "./update.php", { duration: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } 
        else {
          var s_Data= jQuery.parseJSON( data );
          $("#course4duration").val(s_Data[0]);
          $('#4th').append($('<option>', {value:"-", text: "-"}));
          for(var i = 1 ; i < s_Data[1].length; i ++) {
            $('#4th').append($('<option>', {value:s_Data[1][i], text: s_Data[1][i]}));
          }
        }           
      });
      $("#course4").slideDown();
      $('#course4name').val(selectedOpts.val());
      break;

      case 5:
      var courseName = $("#lstbox2 option").eq(4).val();
      $.post( "./update.php", { duration: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } 
        else {
          var s_Data= jQuery.parseJSON( data );
          $("#course5duration").val(s_Data[0]);
          $('#5th').append($('<option>', {value:"-", text: "-"}));
          for(var i = 1 ; i < s_Data[1].length; i ++) {
            $('#5th').append($('<option>', {value:s_Data[1][i], text: s_Data[1][i]}));
          }
        }           
      });
      $("#course5").slideDown();
      $('#course5name').val(selectedOpts.val());
      break;

      case 6:
      var courseName = $("#lstbox2 option").eq(5).val();
      $.post( "./update.php", { duration: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } 
        else {
          var s_Data= jQuery.parseJSON( data );
          $("#course6duration").val(s_Data[0]);
          $('#6th').append($('<option>', {value:"-", text: "-"}));
          for(var i = 1 ; i < s_Data[1].length; i ++) {
            $('#6th').append($('<option>', {value:s_Data[1][i], text: s_Data[1][i]}));
          }
        }  });
      $("#course6").slideDown();
      $('#course6name').val(selectedOpts.val());
      break;
      default:
      alert("Full!!!!!!!!!!!!!!");
      return;
      break;  }

        //changeStartDate();
        $(selectedOpts).remove();
        e.preventDefault();
      });

$('#btnLeft').click(function(e) {
  var selectedOpts = $('#lstBox2 option:selected');
  if (selectedOpts.length == 0) {
    alert("Nothing to move.");
    e.preventDefault();
  }

  $('#lstBox1').append($(selectedOpts).clone());
  $(selectedOpts).remove();
  e.preventDefault();
});
});


function getStartDateByName(courseName){



    /*$('#lstbox2 option').each(function(){
        courseNames.push($(this).val());
      });*/


      $.post( "./update.php", { courses: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } else {
         var s_Data= jQuery.parseJSON( data );


         for(var i = 0 ; i < s_Data.length; i ++){

          $('#1st').append($('<option>', {value:s_Data[i], text: s_Data[i]}));
        }

        $('#course1').slideDown();


      }           


    });
    }

    function getCourseDuration(courseName){





      $.post( "./update.php", { duration: courseName })
      .done(function( data ) {
        if(data=="[]"){
          alert( "No data!!!" );
        } else {
         var s_Data= jQuery.parseJSON( data );
         return s_Data;

                  /*for(var i = 0 ; i < s_Data.length; i ++){
                    
                    $('#1st').append($('<option>', {value:s_Data[i], text: s_Data[i]}));
                  }*/
                  
            //$('#course1').slideDown();


          }           
          

        });
    }

    function checkDate(startDate){

      var tempDate = startDate.split("/");
      var converted = new Date(tempDate[2],tempDate[1]-1,tempDate[0]);
      var now = new Date();
      if(now > converted){
        return 0;
      } 
      else 
        return 1;

    }
