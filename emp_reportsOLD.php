       <?phpsession_start();include 'sessionclass.php';include 'clconclass.php';include 'xxxfunctions.php';$obj = new session;$seadminguide = $obj->seadminguide();$obj1 = new clcon;//error_reporting(E_ALL);//ini_set('display_errors', 1);?><!DOCTYPE html><!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --><!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]--><!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]--><head>  <meta charset="utf-8" />  <!-- Set the viewport width to device width for mobile -->  <meta name="viewport" content="width=device-width" />  <title>Wellness - Employers Report</title>    <!-- Included CSS Files (Uncompressed) -->  <!--  <link rel="stylesheet" href="stylesheets/foundation.css">  -->    <!-- Included CSS Files (Compressed) -->  <link rel="stylesheet" href="stylesheets/foundation.min.css">  <link rel="stylesheet" href="stylesheets/app.css">  <script src="javascripts/modernizr.foundation.js"></script>    <script>  	function getloc(){	var ghi = document.getElementById("sel1").value;	try     { /*Generally non IE browsers*/     ajR4 = new XMLHttpRequest();    }catch (e)    { /*IE 6 and down*/try         {ajR4 = new ActiveXObject("Msxml2.XMLHTTP");        }    catch (e)        {try             {ajR4 = new ActiveXObject("Microsoft.XMLHTTP");            }        catch (e)            { /*Failure to define ajax (old or broken browser)*/             alert("Your browser is too old, or is misconfigured");             return false;            }        }    }//receive dataajR4.onreadystatechange = function(){	if(ajR4.readyState == 4){		document.getElementById("repobj1").innerHTML = ajR4.responseText;	}};ajR4.open("GET", "mconrepajax.php?clid=" + ghi, true);ajR4.send(null);};  </script></head><body><?php include('header.php'); ?> 		<div class="row">		<div class="twelve columns">			<div class="row" id="head1">				<div class="twelve columns" id="head1a">					<br />					<br />				</div>			</div>			<div class="row">						<div style="width:80%; margin:auto;">					<h4>Employers Report</h4>					<br />                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <head><script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script><script>    $(document).ready(function($) {  var lst_location_id = 'lst_location'; //first select list ID  var lst_client_id = 'lst_client'; //second select list ID  var initial_target_html = '<option value="">First select a client</option>'; //Initial prompt for target select   $('#'+lst_location_id).html(initial_target_html); //Give the target select the prompt option   $('#'+lst_client_id).change(function(e) {    //Grab the chosen value on first select list change    var selectvalue = $(this).val();     //Display 'loading' status in the target select list    $('#'+lst_location_id).html('<option value="">Loading...</option>');     if (selectvalue == "") {        //Display initial prompt in target select if blank value selected       $('#'+lst_location_id).html(initial_target_html);    } else {      //Make AJAX request, using the selected value as the GET      $.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,             success: function(output) {                //alert(output);                $('#'+lst_location_id).html(output);            },          error: function (xhr, ajaxOptions, thrownError) {            alert(xhr.status + " "+ thrownError);          }});        }    });});</script></head>  <form name="repfrm1" id="frmrep1" method="post" action="emp_reports.php">  Clients: <br><select name="lst_client" id="lst_client">    <option value="">Select a client</option><?php$connection = mysqli_connect($dbserver, $dbusername, $dbpass, $db);$result = mysqli_query($connection, "SELECT * from client");  while($row = mysqli_fetch_array($result))   {$id=$row['id'];$fname=$row['clname'];$fname = $obj1->decode($fname);?>    <option value="<?php echo $id ?>"><?php echo "$fname" ?></option><?php}?></select><br>Locations: <br><select name="lst_location" id="lst_location"></select><br>Gender: <br><select name="gender" id="gender">    <option value="all">All</option>    <option value="female">Female</option>    <option value="male">Male</option>    <option value="neuter">Neuter</option></select><br>Lower age:<br><select name="agelow"><option value ="0">All</option><option value ="16">16</option><option value ="17">17</option><option value ="18">18</option><option value ="19">19</option><option value ="20">20</option><option value ="21">21</option><option value ="22">22</option><option value ="23">23</option><option value ="24">24</option><option value ="25">25</option><option value ="26">26</option><option value ="27">27</option><option value ="28">28</option><option value ="29">29</option><option value ="30">30</option><option value ="31">31</option><option value ="32">32</option><option value ="33">33</option><option value ="34">34</option><option value ="35">35</option><option value ="36">36</option><option value ="37">37</option><option value ="38">38</option><option value ="39">39</option><option value ="40">40</option><option value ="41">41</option><option value ="42">42</option><option value ="43">43</option><option value ="44">44</option><option value ="45">45</option><option value ="46">46</option><option value ="47">47</option><option value ="48">48</option><option value ="49">49</option><option value ="50">50</option><option value ="51">51</option><option value ="52">52</option><option value ="53">53</option><option value ="54">54</option><option value ="55">55</option><option value ="56">56</option><option value ="57">57</option><option value ="58">58</option><option value ="59">59</option><option value ="60">60</option><option value ="61">61</option><option value ="62">62</option><option value ="63">63</option><option value ="64">64</option><option value ="65">65</option><option value ="66">66</option><option value ="67">67</option><option value ="68">68</option><option value ="69">69</option><option value ="70">70</option><option value ="71">71</option><option value ="72">72</option><option value ="73">73</option><option value ="74">74</option><option value ="75">75</option><option value ="76">76</option><option value ="77">77</option><option value ="78">78</option><option value ="79">79</option><option value ="80">80</option><option value ="81">81</option><option value ="82">82</option><option value ="83">83</option><option value ="84">84</option><option value ="85">85</option><option value ="86">86</option><option value ="87">87</option><option value ="88">88</option><option value ="89">89</option><option value ="90">90</option><option value ="91">91</option><option value ="92">92</option><option value ="93">93</option><option value ="94">94</option><option value ="95">95</option><option value ="96">96</option><option value ="97">97</option><option value ="98">98</option><option value ="99">99</option><option value ="100">100</option></select><br>Higher age:<br><select name="agehight"><option value ="0">All</option><option value ="16">16</option><option value ="17">17</option><option value ="18">18</option><option value ="19">19</option><option value ="20">20</option><option value ="21">21</option><option value ="22">22</option><option value ="23">23</option><option value ="24">24</option><option value ="25">25</option><option value ="26">26</option><option value ="27">27</option><option value ="28">28</option><option value ="29">29</option><option value ="30">30</option><option value ="31">31</option><option value ="32">32</option><option value ="33">33</option><option value ="34">34</option><option value ="35">35</option><option value ="36">36</option><option value ="37">37</option><option value ="38">38</option><option value ="39">39</option><option value ="40">40</option><option value ="41">41</option><option value ="42">42</option><option value ="43">43</option><option value ="44">44</option><option value ="45">45</option><option value ="46">46</option><option value ="47">47</option><option value ="48">48</option><option value ="49">49</option><option value ="50">50</option><option value ="51">51</option><option value ="52">52</option><option value ="53">53</option><option value ="54">54</option><option value ="55">55</option><option value ="56">56</option><option value ="57">57</option><option value ="58">58</option><option value ="59">59</option><option value ="60">60</option><option value ="61">61</option><option value ="62">62</option><option value ="63">63</option><option value ="64">64</option><option value ="65">65</option><option value ="66">66</option><option value ="67">67</option><option value ="68">68</option><option value ="69">69</option><option value ="70">70</option><option value ="71">71</option><option value ="72">72</option><option value ="73">73</option><option value ="74">74</option><option value ="75">75</option><option value ="76">76</option><option value ="77">77</option><option value ="78">78</option><option value ="79">79</option><option value ="80">80</option><option value ="81">81</option><option value ="82">82</option><option value ="83">83</option><option value ="84">84</option><option value ="85">85</option><option value ="86">86</option><option value ="87">87</option><option value ="88">88</option><option value ="89">89</option><option value ="90">90</option><option value ="91">91</option><option value ="92">92</option><option value ="93">93</option><option value ="94">94</option><option value ="95">95</option><option value ="96">96</option><option value ="97">97</option><option value ="98">98</option><option value ="99">99</option><option value ="100">100</option></select><BR><br><br><input type="submit" name="sub1" id="but1" value="Generate" class="success button"></form><br>===============================================================================</br><?php // if search is done	if (isset($_POST['sub1'])){// search contacts            $current_year=date("Y");                        $client=$_POST['lst_client'];            if ($client=="" ) {                echo  "Client is required";                exit;            }            $location=$_POST['lst_location'];            if ($location=="") {            $location_query="";            } else {            $location_query=" and locid='$location'";            }                         $gender=$_POST['gender'];                        $agelow=$_POST['agelow'];            $agelow_year=$current_year-$agelow;            $agelow_dob = date("$agelow_year-m-d");            if ($agelow=="0") {            $agelow_query="";            } else {            $agelow_query=" and dob<'$agelow_dob'";            }            if ($agelow=="0") {            $agelow="/";               }                           $agehight=$_POST['agehight'];            $agehight_year=$current_year-$agehight;            $agehight_dob = date("$agehight_year-m-d");            if ($agehight=="0") {            $agehight_query="";            } else {            $agehight_query=" and dob>'$agehight_dob'";            }            if ($agehight=="0") {            $agehight="/";            }            //            $year=$_POST['year'];//            if ($year=="0") {//            $year_query="";//            } else {         //            $year_query=" and dat>='$year-01-01' and dat<='$year-12-31'";    //            }                                    //gender needed?            if ($gender=="all") {            $gender_query="";            } else {            $gender_d = $obj1->encode($gender);            $gender_query=" and gender='$gender_d'";            }                         $connection =  mysqli_connect($dbserver, $dbusername, $dbpass, $db);            $result = mysqli_query($connection, "SELECT * from employee where clid='$client' $location_query $gender_query $agelow_query $agehight_query");              $row_cnt = $result->num_rows;            $query="SELECT * from employee where clid='$client' $location_query $gender_query $agelow_query $agehight_query";                        echo "<b>Employer Report for:</b><br>";             echo "Client: ".$obj1->decode(clientIdToName($client));            echo "<br>Location: ".$obj1->decode(locationIdToName($location));                    echo "<br>Gender: ".$gender;            echo "<br>Low age: ".$agelow."";            echo "<br>Hight age: ".$agehight."";                       echo "<br><br><b>Total Employers found:</b> $row_cnt";            echo '<br><br><b>Employers List <a href="xxxxls_emp.php?query=';            echo $query;            echo '">download excel</a>:</b><br>';  $table='<table>';                    $table.="<tr><td>NAME</td><td>MIDDLE NAME</td><td>LAST NAME</td><td>DATE OF BIRTH</td><td>GENDER</td><td>DEPARTMENT</td><td>POSITION</td><td>DESG</td><td>TYPE</td><td>HIRING YEAR</td><td>PHOTO</td><td>H PLAN</td><td>STATUS</td></tr>";                  while($row = mysqli_fetch_array($result))   {                $employer_id=$row['id'];                                   $employer_name=$row['fname'];                              $employer_name=$obj1->decode($employer_name);                $employer_mname=$row['mname'];                              $employer_mname=$obj1->decode($employer_mname);                                $employer_lname=$row['lname'];                  $employer_lname=$obj1->decode($employer_lname);                $employer_dob=$row['dob'];                $employer_gender=$row['gender'];                  $employer_gender=$obj1->decode($employer_gender);                 $employer_dept=$row['dept'];                  $employer_dept=$obj1->decode($employer_dept);                     $employer_pos=$row['pos'];                  $employer_pos=$obj1->decode($employer_pos);                 $employer_desg=$row['desg'];                  $employer_desg=$obj1->decode($employer_desg);                 $employer_type=$row['type'];                  $employer_type=$obj1->decode($employer_type);                  $employer_hyear=$row['hyear'];                  $employer_hyear=$obj1->decode($employer_hyear);                  $employer_imgpath=$row['imgpath'];                  $employer_imgpath=$obj1->decode($employer_imgpath);                $employer_hplan=$row['hplan'];                  $employer_hplan=$obj1->decode($employer_hplan);                  $employer_status=$row['status'];                  $employer_status=$obj1->decode($employer_status);                    $table.="<tr><td>$employer_name</td><td>$employer_mname</td><td>$employer_lname</td><td>$employer_dob</td><td>$employer_gender</td><td>$employer_dept</td><td>$employer_pos</td><td>$employer_desg</td><td>$employer_type</td><td>$employer_hyear</td><td><img src='$employer_imgpath'></td><td>$employer_hplan</td><td>$employer_status</td></tr>";    }     $table.="</table>";           echo $table;        }?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         				</div>				</div>					</div>	</div>  </body></html>