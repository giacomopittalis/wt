<?php
session_start();
include 'sessionclass.php';
include 'clconclass.php';
include 'xxxfunctions.php';
$obj = new session;
$seadminguide = $obj->seadminguide();
$obj1 = new clcon;



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

<form name="repfrm1" id="frmrep1" method="post" action="xxxreport3.php"> 
    
<b>Client & Site</b><br>

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
<?php include "xxxReportJS.php" ?>
<div id="addclient">
    
</div>
<input type="button" value="Add a Client" class="add" id="add" />

<br><br>
<b>Date Range</b>
<br>
<script>
$(function() {
	$('#startDatepicker').datepick();
	$('#endDatepicker').datepick();
});


</script>
Date start: <input type="text" id="startDatepicker" name="startDatepicker">  Date end: <input type="text" id="endDatepicker" name="endDatepicker">



<br><br>
<b>Extra filters</b>
<br>
Gender: 
<br>
<select name="gender" id="gender">
    <option value="all">All</option>
    <option value="female">Female</option>
    <option value="male">Male</option>
    <option value="neuter">Neuter</option>
</select>


<br>

Lower age:<br>
<select name="agelow"><option value ="0">All</option><option value ="16">16</option><option value ="17">17</option><option value ="18">18</option><option value ="19">19</option><option value ="20">20</option><option value ="21">21</option><option value ="22">22</option><option value ="23">23</option><option value ="24">24</option><option value ="25">25</option><option value ="26">26</option><option value ="27">27</option><option value ="28">28</option><option value ="29">29</option><option value ="30">30</option><option value ="31">31</option><option value ="32">32</option><option value ="33">33</option><option value ="34">34</option><option value ="35">35</option><option value ="36">36</option><option value ="37">37</option><option value ="38">38</option><option value ="39">39</option><option value ="40">40</option><option value ="41">41</option><option value ="42">42</option><option value ="43">43</option><option value ="44">44</option><option value ="45">45</option><option value ="46">46</option><option value ="47">47</option><option value ="48">48</option><option value ="49">49</option><option value ="50">50</option><option value ="51">51</option><option value ="52">52</option><option value ="53">53</option><option value ="54">54</option><option value ="55">55</option><option value ="56">56</option><option value ="57">57</option><option value ="58">58</option><option value ="59">59</option><option value ="60">60</option><option value ="61">61</option><option value ="62">62</option><option value ="63">63</option><option value ="64">64</option><option value ="65">65</option><option value ="66">66</option><option value ="67">67</option><option value ="68">68</option><option value ="69">69</option><option value ="70">70</option><option value ="71">71</option><option value ="72">72</option><option value ="73">73</option><option value ="74">74</option><option value ="75">75</option><option value ="76">76</option><option value ="77">77</option><option value ="78">78</option><option value ="79">79</option><option value ="80">80</option><option value ="81">81</option><option value ="82">82</option><option value ="83">83</option><option value ="84">84</option><option value ="85">85</option><option value ="86">86</option><option value ="87">87</option><option value ="88">88</option><option value ="89">89</option><option value ="90">90</option><option value ="91">91</option><option value ="92">92</option><option value ="93">93</option><option value ="94">94</option><option value ="95">95</option><option value ="96">96</option><option value ="97">97</option><option value ="98">98</option><option value ="99">99</option><option value ="100">100</option></select>
<br>Higher age:<br>
<select name="agehight"><option value ="0">All</option><option value ="16">16</option><option value ="17">17</option><option value ="18">18</option><option value ="19">19</option><option value ="20">20</option><option value ="21">21</option><option value ="22">22</option><option value ="23">23</option><option value ="24">24</option><option value ="25">25</option><option value ="26">26</option><option value ="27">27</option><option value ="28">28</option><option value ="29">29</option><option value ="30">30</option><option value ="31">31</option><option value ="32">32</option><option value ="33">33</option><option value ="34">34</option><option value ="35">35</option><option value ="36">36</option><option value ="37">37</option><option value ="38">38</option><option value ="39">39</option><option value ="40">40</option><option value ="41">41</option><option value ="42">42</option><option value ="43">43</option><option value ="44">44</option><option value ="45">45</option><option value ="46">46</option><option value ="47">47</option><option value ="48">48</option><option value ="49">49</option><option value ="50">50</option><option value ="51">51</option><option value ="52">52</option><option value ="53">53</option><option value ="54">54</option><option value ="55">55</option><option value ="56">56</option><option value ="57">57</option><option value ="58">58</option><option value ="59">59</option><option value ="60">60</option><option value ="61">61</option><option value ="62">62</option><option value ="63">63</option><option value ="64">64</option><option value ="65">65</option><option value ="66">66</option><option value ="67">67</option><option value ="68">68</option><option value ="69">69</option><option value ="70">70</option><option value ="71">71</option><option value ="72">72</option><option value ="73">73</option><option value ="74">74</option><option value ="75">75</option><option value ="76">76</option><option value ="77">77</option><option value ="78">78</option><option value ="79">79</option><option value ="80">80</option><option value ="81">81</option><option value ="82">82</option><option value ="83">83</option><option value ="84">84</option><option value ="85">85</option><option value ="86">86</option><option value ="87">87</option><option value ="88">88</option><option value ="89">89</option><option value ="90">90</option><option value ="91">91</option><option value ="92">92</option><option value ="93">93</option><option value ="94">94</option><option value ="95">95</option><option value ="96">96</option><option value ="97">97</option><option value ="98">98</option><option value ="99">99</option><option value ="100">100</option></select>
<BR>
Hiring Year
<br>
<select name="hiring_year" id="sel6"><option value="0">All</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option></select>
<!--<BR>
Salary Plan
<br>
<select name="salary_plan"><option value="0">All</option><option value="Hourly">Hourly</option><option value="Salary">Salary</option><option value="Union">Union</option></select>-->
<br>
Shows employees with more than <input name="num_contact" style="width:30px;"> contacts
<br>
Shows employees with more than <input name="num_consults" style="width:30px;"> consults
<br>
<br><br>
<input type="submit" name="sub1" id="but1" value="Generate" class="success button">
</form>
<br>
===================================<br>
===================================</br>
<?php 
// if search is done
	if (isset($_POST['sub1'])){
            
            //print_r($_POST); 
            //exit;
 
            
                $conta_hc=0;





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
                ${"location_query" . $iClient}=" and contact.locid='${"location" . $iClient}'";                
            }
            
            $client_query.=" or (contact.clid='".${"client" . $iClient}."'".${"location_query" . $iClient}.")"; 
            }    
            $iClient++;                    
            }
            
           


             

            $gender=$_POST['gender'];
            
            
            $hiring_year=$_POST['hiring_year'];
            $hiring_year=$obj1->encode($hiring_year);
            if ($hiring_year=="0") {
            $hiring_year_query="";
            } else {
            $hiring_year_query=" and employee.hyear='$hiring_year'";
            }
            
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
            $gender_query=" and employee.gender='$gender_d'";
            }
            
 
            $connection = mysqli_connect($host, $user, $pw, $db);
            
            if ($location=="") {
                $location_query="";
            } else {
                $location_query="and contact.locid='$location'";                
            }
            
// GENERAL QUERY             
            $query="SELECT contact.dat, employee.fname, employee.dob, employee.lname, employee.type, employee.hplan, employee.gender, employee.pos, employee.desg, employee.hyear, employee.dept, contact.clid as client_id, contact.locid as location_id, contact.contype, contact.id as contact_id, employee.id as employee_id from contact  INNER JOIN employee  ON contact.empid = employee.id where (contact.clid='$client' $location_query) $client_query $from_query $to_query $gender_query $agelow_query $agehight_query $hiring_year_query order by employee.lname";
            $result = mysqli_query($connection, $query);  
         echo "<br><b>$query</b><br><br>";
            $row_cnt = $result->num_rows;
  
            echo "<b>Participation Report for:<br>"; 
            echo "Client: ".$obj1->decode(clientIdToName($client))." - Location: ".$obj1->decode(locationIdToName($location));
            echo " $clientsmore ";
            echo "<br>Low age: ".$agelow;
            echo "<br>Hight age: ".$agehight;
            echo "<br>From: $from_ok<br>To: $to_ok<br>Gender: $gender</b><br>===================================<br>
===================================</br><br><br>";        
      

          
            while($row = mysqli_fetch_array($result))   {
                $contact_date=$row['dat'];
                $contact_id=$row['contact_id'];
                $client_id=$row['client_id']; 
                $location_id=$row['location_id'];                
                $employee_id=$row['employee_id'];                 
                $employee_type=$row['type'];                
                $employee_dept=$row['dept'];
                $employee_gender=$row['gender'];
                $employee_pos=$row['pos'];
                $employee_desg=$row['desg'];
                $employee_hyear=$row['hyear'];
                $employee_hplan=$row['hplan'];
                $employee_dob=$row['dob'];                
                $employer_name=$row['fname'];              
                $employer_name=$obj1->decode($employer_name);
                $employer_lname=$row['lname'];  
                $employer_lname=$obj1->decode($employer_lname);
                $contype=$row['contype'];  
                $contype=$obj1->decode($contype);
                
               
                

// search consult type: 1 hcmain
                $queryHC="SELECT * from hcmain where conid='$contact_id'";
                $resultHC = mysqli_query($connection, $queryHC);  
                $row_cntHC = $resultHC->num_rows;  
                //echo "<b>Contact id $contact_id done $row_cntHC health consults</b></br>";
                if ($row_cntHC>0) {
                    while($rowHC = mysqli_fetch_array($resultHC))   {
                    $hcconsult=$rowHC['id'];
                    }
                    $hc="Healt consult ($hcconsult)";                    
                }
                
// search consult type: 1 icmain
                $queryIC="SELECT * from icmain where conid='$contact_id'";
                $resultIC = mysqli_query($connection, $queryIC);  
                $row_cntIC = $resultIC->num_rows;  
                //echo "<b>Contact id $contact_id done $row_cntHC health consults</b></br>";
                if ($row_cntIC>0) {
                    while($rowIC = mysqli_fetch_array($resultIC))   {
                    $icconsult=$rowIC['id'];
                    }
                    $ic="Injury consult ($icconsult)";                    
                }                
                
// search consult type: 1 icmain
                $queryOC="SELECT * from ocmain where conid='$contact_id'";
                $resultOC = mysqli_query($connection, $queryOC);  
                $row_cntOC = $resultOC->num_rows;  
                //echo "<b>Contact id $contact_id done $row_cntHC health consults</b></br>";
                if ($row_cntOC>0) {
                    while($rowOC = mysqli_fetch_array($resultOC))   {
                    $occonsult=$rowOC['id'];
                    }
                    $oc="Injury consult ($occonsult)";                    
                } 
                
                           
                // create array
                 $arr[] = "$employee_id****$employer_name****$employer_lname****$employee_dob****$employee_dept****$employee_hyear****$employee_gender****$employee_pos****$employee_desg****$employee_type****$employee_hplan";
    }
    

    $result = array_unique($arr);
    sort($result);
    echo "<table><tr><td><b>Total Employees with contacts in range: ".count($result)."</b></td></tr>";
    foreach ($result as $clave => $valor) {
    $porciones = explode("****", $valor);
    $emp_id= $porciones[0]; 
    $emp_fname= $porciones[1];
    $emp_lname= $porciones[2];    
    $emp_dob= $porciones[3]; 
    $emp_dept= $porciones[4]; 
    $emp_hyear= $porciones[5];
    $emp_gender= $porciones[6];
    $emp_pos= $porciones[7];
    $emp_desg= $porciones[8];
    $emp_type= $porciones[9];
    $emp_hplan= $porciones[10];
    
    
    $query2="SELECT * from contact  where contact.empid = '$emp_id' $from_query $to_query  ";
    $result2 = mysqli_query($connection, $query2);  
    $row_cnt2 = $result2->num_rows;
    
    // show depending on number of  contact
    $num_contact=$_POST[num_contact];
    if ($num_contact=="") {
        $num_contact="0";
    }
    if ($row_cnt2>=$num_contact) {
    
    
     //count consults
    $queryC="SELECT * from contact  where contact.empid = '$emp_id' $from_query $to_query  ";
    $resultC = mysqli_query($connection, $queryC);  
    $row_cntC = $resultC->num_rows;
    $tot_HC=0;
    $tot_IC=0;
    $tot_PC=0; 
    $tot_OC=0;
    $tot=0;
    while($row_cntC = mysqli_fetch_array($resultC))   {
         $id_contatto=$row_cntC['id'];  
         $queryHC3="SELECT * from hcmain where conid='$id_contatto'";
         $resultHC3 = mysqli_query($connection, $queryHC3);  
         $row_cntHC3 = $resultHC3->num_rows; 
         $tot_HC +=$row_cntHC3;
         
         $queryIC3="SELECT * from icmain where conid='$id_contatto'";
         $resultIC3 = mysqli_query($connection, $queryIC3);  
         $row_cntIC3 = $resultIC3->num_rows; 
         $tot_IC +=$row_cntIC3;
         
         $queryOC3="SELECT * from ocmain where conid='$id_contatto'";
         $resultOC3 = mysqli_query($connection, $queryOC3);  
         $row_cntOC3 = $resultOC3->num_rows; 
         $tot_OC +=$row_cntOC3;        
         
         $queryPC3="SELECT * from pcmain where conid='$id_contatto'";
         $resultPC3 = mysqli_query($connection, $queryPC3);  
         $row_cntPC3 = $resultPC3->num_rows; 
         $tot_PC +=$row_cntPC3;            
    }
    $tot=$tot_HC+$tot_IC+$tot_OC+$tot_PC;
    //echo "H $tot_HC I $tot_IC O $tot_OC P $tot_PC TOTALE: $tot;<br>";  
      //echo "EMP: $emp_id has $tot consults";  
 if ($tot<=$_POST[num_consults]) {
    
 } else {
        
        
          
    echo "<tr><td><b>$emp_id) $emp_lname, $emp_fname</b><td></tr>";
    echo "<tr><td><b>DEPT: ".$obj1->decode($emp_dept)." DOB: $emp_dob Hiring Year:".$obj1->decode($emp_hyear)."</b><td></tr>"; 
    echo "<tr><td><b>GENDER: ".$obj1->decode($emp_gender)." POS: ".$obj1->decode($emp_pos)." TYPE OF HIRING::".$obj1->decode($emp_type)." HEALTH PLAN::".$obj1->decode($emp_hplan)."</b><td></tr>"; 
    echo "<tr><td><b>Client:".$obj1->decode(clientIdToName($client_id))." Location:".$obj1->decode(locationIdToName($location_id))."</b><td></tr>";    
    echo "<tr><td>Contacts: $row_cnt2 Consults: $tot</td></tr>";
    
    $query2="SELECT * from contact  where contact.empid = '$emp_id' $from_query $to_query  ";
    $result2 = mysqli_query($connection, $query2);  
    $row_cnt2 = $result2->num_rows;
    while($row2 = mysqli_fetch_array($result2))   {
    $con_id=$row2['id'];        
    $con_date=$row2['dat'];
    $con_type=$row2['contype'];
    $con_type=$obj1->decode($con_type);
    
    // search consult type: 1 icmain
    $ic2="";    
    $queryIC2="SELECT * from icmain where conid='$con_id'";
    $resultIC2 = mysqli_query($connection, $queryIC2);  
    $row_cntIC2 = $resultIC2->num_rows;  
    if ($row_cntIC2>0) {
    while($rowIC2 = mysqli_fetch_array($resultIC2))   {
    $icconsult2=$rowIC2['id'];
    $conta_ic++;
       $ic2="[Injury consult]";  
    }                  
    }      
    // search consult type: 1 icmain
    $hc2="";    
    $queryHC2="SELECT * from hcmain where conid='$con_id'";
    $resultHC2 = mysqli_query($connection, $queryHC2);  
    $row_cntHC2 = $resultHC2->num_rows;  
    if ($row_cntHC2>0) {
    while($rowHC2 = mysqli_fetch_array($resultHC2))   {
    $hcconsult2=$rowHC2['id'];
    $conta_hc++;
    $hc2.="[Health consult]"; 
    }                   
    }     
    // search consult type: 1 icmain
    $oc2="";
    $queryOC2="SELECT * from ocmain where conid='$con_id'";
    $resultOC2 = mysqli_query($connection, $queryOC2);  
    $row_cntOC2 = $resultOC2->num_rows;  
    if ($row_cntOC2>0) {
    while($rowOC2 = mysqli_fetch_array($resultOC2))   {
    $occonsult2=$rowOC2['id'];
    $conta_oc++;
        $oc2="[Opportunity consult]"; 
    }                   
    }     
    // search consult type: 1 icmain
    $pc2="";
    $queryPC2="SELECT * from pcmain where conid='$con_id'";
    $resultPC2 = mysqli_query($connection, $queryPC2);  
    $row_cntPC2 = $resultPC2->num_rows;  
    if ($row_cntPC2>0) {
    while($rowPC2 = mysqli_fetch_array($resultPC2))   {
    $pcconsult2=$rowPC2['id'];
    $conta_pc++;
        $pc2="[Proactive consult]"; 
    }                   
    }     
    echo "<tr><td>$con_date - $con_type $hc2 $ic2 $oc2 $pc2</td></tr>";
    }
    echo "<tr><td>=================================</td></tr>";
    }
    // end tot contact
    }
    // end tot consult
    
    
}
    
    
echo "<tr><td><b>Total Contacts Retrieved for Client: $row_cnt</b><br>";
echo "<b>Total Health consults: $conta_hc</b><br>";    
echo "<b>Total Injury consults: $conta_ic</b><br>";     
echo "<b>Total Opportunity consults: $conta_oc</b><br>";     
echo "<b>Total Proactive consults: $conta_pc</b></td></tr></table>";    
    
    
        }
        
?>