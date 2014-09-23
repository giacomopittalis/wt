<?php
session_start();
include 'sessionclass.php';
include 'clconclass.php';
include 'xxxfunctions.php';
$obj = new session;
$seadminguide = $obj->seadminguide();
$obj1 = new clcon;



?>
  

<?php
//$xxx = "pippo";
//$xxx = $obj1->encode($xxx);
//echo "Encoded: $xxx";
//$yyy="cSMCqa_bwbFieQpVwew5Hmc2J6yn2wAeAYhQtiW412U";
//$xxx = $obj1->decode($yyy);
//echo "<br>Decoded: $xxx";
?>


<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<link href="dpick/jquery.datepick.css" rel="stylesheet">
<script src="dpick/jquery.plugin.js"></script>
<script src="dpick/jquery.datepick.js"></script>
<script>
    $(document).ready(function($) {       
  var lst_location_id = 'lst_location'; //first select list ID
  var lst_client_id = 'lst_client'; //second select list ID
  var initial_target_html = '<option value="">First select a client</option>'; //Initial prompt for target select
 
  $('#'+lst_location_id).html(initial_target_html); //Give the target select the prompt option
 
  $('#'+lst_client_id).change(function(e) {
    //Grab the chosen value on first select list change
    var selectvalue = $(this).val();
 
    //Display 'loading' status in the target select list
    $('#'+lst_location_id).html('<option value="">Loading...</option>');
 
    if (selectvalue == "") {
        //Display initial prompt in target select if blank value selected
       $('#'+lst_location_id).html(initial_target_html);
    } else {
      //Make AJAX request, using the selected value as the GET
      $.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
             success: function(output) {
                //alert(output);
                $('#'+lst_location_id).html(output);
            },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " "+ thrownError);
          }});
        }
    });
});



  

</script>
</head>  

<form name="repfrm1" id="frmrep1" method="post" action="xxxreport.php"> 
    
<b>site ( ability to pick multiple clients and/or, locations within a client </b><br>

<select name="lst_client" id="lst_client">
    <option value="">Select a client</option>
<?php
$connection = mysqli_connect($host, $user, $pw, $db);
$result = mysqli_query($connection, "SELECT * from client");  
while($row = mysqli_fetch_array($result))   {   
$id=$row['id'];
$fname=$row['clname'];
$fname = $obj1->decode($fname);
$names[] = $fname; 
$ids[] = $id; 
?>
    <option value="<?php echo $id ?>"><?php echo "$fname" ?></option>
<?php
}
?>
</select>    
    


<select name="lst_location" id="lst_location"></select>    





    
<br>
<script>
var jArray= <?php echo json_encode($names ); ?>;  
var jArray2= <?php echo json_encode($ids ); ?>; 
$(document).ready(function() {
    $("#add").click(function() {
        var intId = $("#addclient div").length + 1;
        

        
        var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
        var select0 = "<select id='lst_client" + intId + "' name='lst_client" + intId + "'>";
        var select1 = "<option value=xxx>Select a client</option>";
        
    var select2= "";
    var i;
    
    // must find a better way to count the clients
    for (i = 0; i < 10; i++) {
        select2+= "<option value=" + jArray2[i] + ">" + jArray[i] + "</option>";
    }
            
            
        var select3 = "</select>";
        var fType = select0 + select1 + select2 + select3;
        var location1 ="<select name=lst_location" + intId + " id=lst_location" + intId + "><option value=>First select a client</option></select>  "
        var removeButton = $("<input type=\"button\" class=\"remove\" value=\"-\" />");
        removeButton.click(function() {
            $(this).parent().remove();
        });
        fieldWrapper.append(fType);
        fieldWrapper.append(location1);
        fieldWrapper.append(removeButton);
        $("#addclient").append(fieldWrapper);
        
if ($("#lst_client" + intId).length > 0){ // if new client is added to search
 
 
//////////////////////////////////////////////////////////////11111111111111 
var lst_location_id1 = 'lst_location1'; //first select list ID
var lst_client_id1 = 'lst_client1'; //second select list ID
$('#'+lst_client_id1).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id1).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id1).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id1).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////11111111111111
//////////////////////////////////////////////////////////////22222222222222 
var lst_location_id2 = 'lst_location2'; //first select list ID
var lst_client_id2 = 'lst_client2'; //second select list ID
$('#'+lst_client_id2).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id2).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id2).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id2).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////2222222222
//////////////////////////////////////////////////////////////33333333333333 
var lst_location_id3 = 'lst_location3'; //first select list ID
var lst_client_id3 = 'lst_client3'; //second select list ID
$('#'+lst_client_id3).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id3).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id3).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id3).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////3333333333
//////////////////////////////////////////////////////////////44444444444444 
var lst_location_id4 = 'lst_location4'; //first select list ID
var lst_client_id4 = 'lst_client4'; //second select list ID
$('#'+lst_client_id4).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id4).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id4).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id4).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////4444444444
//////////////////////////////////////////////////////////////55555555555555 
var lst_location_id5 = 'lst_location5'; //first select list ID
var lst_client_id5 = 'lst_client5'; //second select list ID
$('#'+lst_client_id5).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id5).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id5).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id5).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////5555555555
//////////////////////////////////////////////////////////////66666666666666 
var lst_location_id6 = 'lst_location6'; //first select list ID
var lst_client_id6 = 'lst_client6'; //second select list ID
$('#'+lst_client_id6).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id6).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id6).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id6).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////6666666666
//////////////////////////////////////////////////////////////77777777777777 
var lst_location_id7 = 'lst_location7'; //first select list ID
var lst_client_id7 = 'lst_client7'; //second select list ID
$('#'+lst_client_id7).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id7).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id7).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id7).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////7777777777
//////////////////////////////////////////////////////////////88888888888888 
var lst_location_id8 = 'lst_location8'; //first select list ID
var lst_client_id8 = 'lst_client8'; //second select list ID
$('#'+lst_client_id8).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id8).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id8).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id8).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////8888888888
//////////////////////////////////////////////////////////////99999999999999 
var lst_location_id9 = 'lst_location9'; //first select list ID
var lst_client_id9 = 'lst_client9'; //second select list ID
$('#'+lst_client_id9).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id9).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id9).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id9).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////9999999999
 
 
 
} else {
 alert("no");    
    }
//        $('#'+lst_client1_id).change(function(e) {
//              alert("caz");
//          });
    });
   
});
</script>
<div id="addclient">
    
</div>
<input type="button" value="Add a Client" class="add" id="add" />

<br><br>
<b>start and end date range – specific to the date – not just month and year</b>
<br>
<script>
$(function() {
	$('#startDatepicker').datepick();
	$('#endDatepicker').datepick();
});


</script>
Date start: <input type="text" id="startDatepicker" name="startDatepicker">  Date end: <input type="text" id="endDatepicker" name="endDatepicker">


<!--<br><br>
Participation reports would require us to have an option to enter the number of available employees for which the report statistics should be based on – that is NOT the same as the total number in the database.  So all percentages would have to be based off of the number WE enter – not the number in the database ( this goes to my comment about active/ inactive and terminated employees below)
<br>
Participation report should include at least the following ( there may have been a few items I am forgetting that are in the documents) : Consult stats; contact stats; topics for each consult type ( health consult topics and subtopics/ injury consult topics and sub topics/ proactive topics.  There are a number of different stats that are needed in each category and those were all detailed in the needs doc and can be found ( most of them) in the sample reports-->


<br><br>
<input type="submit" name="sub1" id="but1" value="Generate" class="success button">
</form>
<br>===============================================================================</br>
<?php 
// if search is done
	if (isset($_POST['sub1'])){
            
            //print_r($_POST); 
            //exit;
 
            
            




// search contacts
            $current_year=date("Y");
            
            
            
            
            $client=$_POST['lst_client'];
            $location=$_POST['lst_location'];           
            
            
            // how many clients are searched         
            $iClient = 1;
            while ($iClient <= count($_POST)) {
            if (isset($_POST[lst_client.$iClient])) {
            ${"client" . $iClient}=$_POST[lst_client.$iClient]; 
            ${"location" . $iClient}=$_POST[lst_location.$iClient]; 
            $clientsmore.= "<br>Client: ".$obj1->decode(clientIdToName(${"client" . $iClient}))." - Location: ".$obj1->decode(locationIdToName(${"location" . $iClient}))."";
            
                        if (${"location" . $iClient}=="") {
                ${"location_query" . $iClient}="";
            } else {
                ${"location_query" . $iClient}=" and contact.locid='${"location" . $iClient}";                
            }
            
            $client_query.=" or (contact.clid='".${"client" . $iClient}."'".${"location_query" . $iClient}."')"; 
            }    
            $iClient++;                    
            }
            
           


             

            $gender=$_POST['gender'];
            
            $agelow=$_POST['agelow'];
            $agelow_year=$current_year-$agelow;
            $agelow_dob = date("$agelow_year-m-d");
            if ($agelow=="0") {
            $agelow_query="";
            } else {
            $agelow_query=" and employee.dob<'$agelow_dob'";
            }
            
            $agehight=$_POST['agehight'];
            $agehight_year=$current_year-$agehight;
            $agehight_dob = date("$agehight_year-m-d");
            if ($agehight=="0") {
            $agehight_query="";
            } else {
            $agehight_query=" and employee.dob>'$agehight_dob'";
            }
            
            $from=$_POST['startDatepicker'];
            $from_ex = explode("/", $from);
            $from_ok = $from_ex[2]."-".$from_ex[0]."-".$from_ex[1]; // porción1
            if ($from_ok=="--") {
            $from_query="";
            } else {         
            $from_query=" and contact.dat>='$from_ok'";    
            }
            
            $to=$_POST['endDatepicker'];
            $to_ex = explode("/", $to);
            $to_ok = $to_ex[2]."-".$to_ex[0]."-".$to_ex[1]; // porción1
            if ($to_ok=="--") {
            $to_query="";
            } else {         
            $to_query=" and contact.dat<='$to_ok'";    
            }
            
            
            //gender needed?
            if ($gender=="all") {
            $gender_query="";
            } else {
            $gender_d = $obj1->encode($gender);
            $gender_query=" and T2.gender='$gender_d'";
            }
            
 
            $connection = mysqli_connect($host, $user, $pw, $db);
            
            if ($location=="") {
                $location_query="";
            } else {
                $location_query="and contact.locid='$location'";                
            }
            $query="SELECT * from contact  INNER JOIN employee  ON contact.empid = employee.id where (contact.clid='$client' $location_query) $client_query $from_query $to_query";
            $result = mysqli_query($connection, $query);  
           // echo "<br><b>$query</b><br><br>";
            
            
            $row_cnt = $result->num_rows;
       
            
            echo "<b>Partecipation Report for:</b><br>"; 
            echo "Client: ".$obj1->decode(clientIdToName($client))." - Location: ".$obj1->decode(locationIdToName($location));
            echo " $clientsmore ";
  

        
//            echo "<br>Location: ".$obj1->decode(locationIdToName($location));        
//            echo "<br>Gender: ".$gender;
//            echo "<br>Low age: ".$agelow." (Employers born after: $agelow_dob)";
//            echo "<br>Hight age: ".$agehight." (Employers born before: $agehight_dob)";
//            echo "<br><br><b>USED QUERY (DEBUGGING PURPOSE ONLY):</b><br> SELECT * from contact T1 INNER JOIN employee T2 ON T1.empid = T2.id where T1.clid='$client' $location_query $gender_query $agelow_query $agehight_query $year_query<br>";
            echo "<br><br><b>Total contacts with employees found:</b> $row_cnt<br><br>";
//            echo "<br><br><b>Contact List:</b><br>";
//            
            while($row = mysqli_fetch_array($result))   {
                $contact_date=$row['dat'];
                $employer_name=$row['fname'];              
                $employer_name=$obj1->decode($employer_name);
                $employer_lname=$row['lname'];  
                $employer_lname=$obj1->decode($employer_lname);
                $contype=$row['contype'];  
                $contype=$obj1->decode($contype);
                echo  "Employee: ".$employer_name." ".$employer_lname."<br> Contact: ".$contact_date." ".$contype."<br> Consult type: To Do<br>=================================================<br>";
    }
        }
?>