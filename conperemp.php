       <?phpsession_start();include 'sessionclass.php';include 'clconclass.php';include 'xxxfunctions.php';$obj = new session;$seadminguide = $obj->seadminguide();$obj1 = new clcon;//error_reporting(E_ALL);//ini_set('display_errors', 1);?><!DOCTYPE html>    <html class="no-js" lang="en">    <head>        <meta charset="utf-8" />        <meta name="viewport" content="width=device-width" />        <title>Wellness - Admin Dashboard</title>        <link rel="stylesheet" href="stylesheets/foundation.min.css">        <link rel="stylesheet" href="style-G.css"><!--        <link rel="stylesheet" href="stylesheets/app.css">-->        <script src="javascripts/modernizr.foundation.js"></script>    </head>    <body>        <?php include('header.php'); ?>         <script src="javascripts/foundation.min.js"></script>        <script src="javascripts/app.js"></script>                         <div class="left-column">            <?php include "inc_left_column.php" ?>        </div>        <div class="right-column">            <div id="activity-feed">                                                                                                                                                        <script>  	function getloc(){	var ghi = document.getElementById("sel1").value;	try     { /*Generally non IE browsers*/     ajR4 = new XMLHttpRequest();    }catch (e)    { /*IE 6 and down*/try         {ajR4 = new ActiveXObject("Msxml2.XMLHTTP");        }    catch (e)        {try             {ajR4 = new ActiveXObject("Microsoft.XMLHTTP");            }        catch (e)            { /*Failure to define ajax (old or broken browser)*/             alert("Your browser is too old, or is misconfigured");             return false;            }        }    }//receive dataajR4.onreadystatechange = function(){	if(ajR4.readyState == 4){		document.getElementById("repobj1").innerHTML = ajR4.responseText;	}};ajR4.open("GET", "mconrepajax.php?clid=" + ghi, true);ajR4.send(null);};  </script><script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script><script>    $(document).ready(function($) {  var lst_location_id = 'lst_location'; //first select list ID  var lst_client_id = 'lst_client'; //second select list ID  var initial_target_html = '<option value="">First select a client</option>'; //Initial prompt for target select   $('#'+lst_location_id).html(initial_target_html); //Give the target select the prompt option   $('#'+lst_client_id).change(function(e) {    //Grab the chosen value on first select list change    var selectvalue = $(this).val();     //Display 'loading' status in the target select list    $('#'+lst_location_id).html('<option value="">Loading...</option>');     if (selectvalue == "") {        //Display initial prompt in target select if blank value selected       $('#'+lst_location_id).html(initial_target_html);    } else {      //Make AJAX request, using the selected value as the GET      $.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,             success: function(output) {                //alert(output);                $('#'+lst_location_id).html(output);            },          error: function (xhr, ajaxOptions, thrownError) {            alert(xhr.status + " "+ thrownError);          }});        }    });});</script><h4>CONTACTS PER EMPLOYEE</h4><form name="repfrm1" id="frmrep1" method="post" action="conperemp.php">  Clients: <br><select name="lst_client" id="lst_client">    <option value="">Select a client</option><?php$connection =  mysqli_connect($dbserver, $dbusername, $dbpass, $db);$result = mysqli_query($connection, "SELECT * from client");  while($row = mysqli_fetch_array($result))   {$id=$row['id'];$fname=$row['clname'];$fname = $obj1->decode($fname);?>    <option value="<?php echo $id ?>"><?php echo "$fname" ?></option><?php}?></select><br>Locations: <br><select name="lst_location" id="lst_location"></select><br>Gender: <br><select name="gender" id="gender">    <option value="all">All</option>    <option value="female">Female</option>    <option value="male">Male</option>    <option value="neuter">Neuter</option></select><br>Lower age:<br><select name="agelow"><option value ="0">All</option><option value ="16">16</option><option value ="17">17</option><option value ="18">18</option><option value ="19">19</option><option value ="20">20</option><option value ="21">21</option><option value ="22">22</option><option value ="23">23</option><option value ="24">24</option><option value ="25">25</option><option value ="26">26</option><option value ="27">27</option><option value ="28">28</option><option value ="29">29</option><option value ="30">30</option><option value ="31">31</option><option value ="32">32</option><option value ="33">33</option><option value ="34">34</option><option value ="35">35</option><option value ="36">36</option><option value ="37">37</option><option value ="38">38</option><option value ="39">39</option><option value ="40">40</option><option value ="41">41</option><option value ="42">42</option><option value ="43">43</option><option value ="44">44</option><option value ="45">45</option><option value ="46">46</option><option value ="47">47</option><option value ="48">48</option><option value ="49">49</option><option value ="50">50</option><option value ="51">51</option><option value ="52">52</option><option value ="53">53</option><option value ="54">54</option><option value ="55">55</option><option value ="56">56</option><option value ="57">57</option><option value ="58">58</option><option value ="59">59</option><option value ="60">60</option><option value ="61">61</option><option value ="62">62</option><option value ="63">63</option><option value ="64">64</option><option value ="65">65</option><option value ="66">66</option><option value ="67">67</option><option value ="68">68</option><option value ="69">69</option><option value ="70">70</option><option value ="71">71</option><option value ="72">72</option><option value ="73">73</option><option value ="74">74</option><option value ="75">75</option><option value ="76">76</option><option value ="77">77</option><option value ="78">78</option><option value ="79">79</option><option value ="80">80</option><option value ="81">81</option><option value ="82">82</option><option value ="83">83</option><option value ="84">84</option><option value ="85">85</option><option value ="86">86</option><option value ="87">87</option><option value ="88">88</option><option value ="89">89</option><option value ="90">90</option><option value ="91">91</option><option value ="92">92</option><option value ="93">93</option><option value ="94">94</option><option value ="95">95</option><option value ="96">96</option><option value ="97">97</option><option value ="98">98</option><option value ="99">99</option><option value ="100">100</option></select><br>Higher age:<br><select name="agehight"><option value ="0">All</option><option value ="16">16</option><option value ="17">17</option><option value ="18">18</option><option value ="19">19</option><option value ="20">20</option><option value ="21">21</option><option value ="22">22</option><option value ="23">23</option><option value ="24">24</option><option value ="25">25</option><option value ="26">26</option><option value ="27">27</option><option value ="28">28</option><option value ="29">29</option><option value ="30">30</option><option value ="31">31</option><option value ="32">32</option><option value ="33">33</option><option value ="34">34</option><option value ="35">35</option><option value ="36">36</option><option value ="37">37</option><option value ="38">38</option><option value ="39">39</option><option value ="40">40</option><option value ="41">41</option><option value ="42">42</option><option value ="43">43</option><option value ="44">44</option><option value ="45">45</option><option value ="46">46</option><option value ="47">47</option><option value ="48">48</option><option value ="49">49</option><option value ="50">50</option><option value ="51">51</option><option value ="52">52</option><option value ="53">53</option><option value ="54">54</option><option value ="55">55</option><option value ="56">56</option><option value ="57">57</option><option value ="58">58</option><option value ="59">59</option><option value ="60">60</option><option value ="61">61</option><option value ="62">62</option><option value ="63">63</option><option value ="64">64</option><option value ="65">65</option><option value ="66">66</option><option value ="67">67</option><option value ="68">68</option><option value ="69">69</option><option value ="70">70</option><option value ="71">71</option><option value ="72">72</option><option value ="73">73</option><option value ="74">74</option><option value ="75">75</option><option value ="76">76</option><option value ="77">77</option><option value ="78">78</option><option value ="79">79</option><option value ="80">80</option><option value ="81">81</option><option value ="82">82</option><option value ="83">83</option><option value ="84">84</option><option value ="85">85</option><option value ="86">86</option><option value ="87">87</option><option value ="88">88</option><option value ="89">89</option><option value ="90">90</option><option value ="91">91</option><option value ="92">92</option><option value ="93">93</option><option value ="94">94</option><option value ="95">95</option><option value ="96">96</option><option value ="97">97</option><option value ="98">98</option><option value ="99">99</option><option value ="100">100</option></select><BR>Year<br><select name="year" id="sel6"><option value="0">All</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option></select><!--<br>Month<br><select name="month"><option value="0">All</option><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>--><br><br><input type="submit" name="sub1" id="but1" value="Generate" class="success button"></form><br>===============================================================================</br><?php // if search is done	if (isset($_POST['sub1'])){// search contacts            $current_year=date("Y");                        $client=$_POST['lst_client'];            if ($client=="" ) {                echo  "Client is required";                exit;            }            $location=$_POST['lst_location'];            if ($location=="") {            $location_query="";            } else {            $location_query=" and T1.locid='$location'";            }                         $gender=$_POST['gender'];                        $agelow=$_POST['agelow'];            $agelow_year=$current_year-$agelow;            $agelow_dob = date("$agelow_year-m-d");            if ($agelow=="0") {            $agelow_query="";            } else {            $agelow_query=" and T2.dob<'$agelow_dob'";            }                        $agehight=$_POST['agehight'];            $agehight_year=$current_year-$agehight;            $agehight_dob = date("$agehight_year-m-d");            if ($agehight=="0") {            $agehight_query="";            } else {            $agehight_query=" and T2.dob>'$agehight_dob'";            }                        $year=$_POST['year'];            if ($year=="0") {            $year_query="";            } else {                     $year_query=" and T1.dat>='$year-01-01' and T1.dat<='$year-12-31'";                }                                    //gender needed?            if ($gender=="all") {            $gender_query="";            } else {            $gender_d = $obj1->encode($gender);            $gender_query=" and T2.gender='$gender_d'";            }                         $connection = mysqli_connect($dbserver, $dbusername, $dbpass, $db);            $result = mysqli_query($connection, "SELECT * from contact T1 INNER JOIN employee T2 ON T1.empid = T2.id where T1.clid='$client' $location_query $gender_query $agelow_query $agehight_query $year_query GROUP BY T2.id");                         $query = "SELECT * from contact T1 INNER JOIN employee T2 ON T1.empid = T2.id where T1.clid='$client' $location_query $gender_query $agelow_query $agehight_query $year_query GROUP BY T2.id";             $row_cnt = $result->num_rows;                                echo "<b>Contact Report for:</b><br>";             echo "Client: ".$obj1->decode(clientIdToName($client));            echo "<br>Location: ".$obj1->decode(locationIdToName($location));                    echo "<br>Gender: ".$gender;            echo "<br>Low age: ".$agelow." (Employers born after: $agelow_dob)";            echo "<br>Hight age: ".$agehight." (Employers born before: $agehight_dob)";                       echo "<br><br><b>Total contacts found:</b> $row_cnt";            echo '<br><br><b>Contact List <a href="xxxxls_comperemp.php?query=';            echo $query;            echo '">download excel</a>:</b><br>';     $table='<table>';                    $table.="<tr><td>CONTACT DATE</td><td>EMPLOYER NAME</td><td>EMPLOYER LAST NAME</td><td>CONTACT TYPE</td><td>U NAME</td><td>TOTAL CONTACTS</td></tr>";                  while($row = mysqli_fetch_array($result))   {                $contact_date=$row['dat'];                $employer_name=$row['fname'];                  $employer_id=$row['empid'];                  $employer_name=$obj1->decode($employer_name);                $employer_lname=$row['lname'];                  $employer_lname=$obj1->decode($employer_lname);                $employer_contype=$row['contype'];                  $employer_contype=$obj1->decode($employer_contype);                 $employer_uname=$row['uname'];                  $employer_uname=$obj1->decode($employer_uname);                $resultC = mysqli_query($connection, "SELECT * from contact where empid='$employer_id'");              $row_cntC = $resultC->num_rows;                                               $table.="<tr><td>$contact_date</td><td>$employer_name</td><td>$employer_lname</td><td>$employer_contype</td><td>$employer_uname</td><td>$row_cntC</td></tr>";    }     $table.="</table>";                  echo $table;        }?>                                                                                                       			                                                                                                                                                                                                                                                                            </div>                    </div>    </body></html>