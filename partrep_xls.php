       <?phpsession_start();include 'sessionclass.php';include 'clconclass.php';include 'xxxfunctions.php';$obj = new session;$seadminguide = $obj->seadminguide();$obj1 = new clcon;//error_reporting(E_ALL);//ini_set('display_errors', 1);  $connection = mysqli_connect($dbserver, $dbusername, $dbpass, $db);?><?phpheader('Content-type: application/vnd.ms-excel');    header("Content-Disposition: attachment; filename=download.xls");    header("Pragma: no-cache");    header("Expires: 0"); ?><?php $conta_hc=0;// search contacts            $current_year=date("Y");                                                            $client=$_POST['lst_client'];            $location=$_POST['lst_location'];                                               // how many clients are searched                     $iClient = 1;            while ($iClient <= count($_POST)) {            if (isset($_POST[lst_client.$iClient])) {            ${"client" . $iClient}=$_POST[lst_client.$iClient];             ${"location" . $iClient}=$_POST[lst_location.$iClient];                         $clientsmore.= "<br>Client: ".$obj1->decode(clientIdToName(${"client" . $iClient}))." - Location: ".$obj1->decode(locationIdToName(${"location" . $iClient}))."";                        if (${"location" . $iClient}=="") {                ${"location_query" . $iClient}="";            } else {                ${"location_query" . $iClient}=" and contact.locid='${"location" . $iClient}'";                            }                        $client_query.=" or (contact.clid='".${"client" . $iClient}."'".${"location_query" . $iClient}.")";             }                $iClient++;                                }                                                $gender=$_POST['gender'];                                    $hiring_year=$_POST['hiring_year'];            $hiring_year=$obj1->encode($hiring_year);            if ($hiring_year=="0") {            $hiring_year_query="";            } else {            $hiring_year_query=" and employee.hyear='$hiring_year'";            }                        $agelow=$_POST['agelow'];            $agelow_year=$current_year-$agelow;            $agelow_dob = date("$agelow_year-m-d");            if ($agelow=="0") {            $agelow_query="";            } else {            $agelow_query=" and employee.dob<'$agelow_dob'";            }                        $agehight=$_POST['agehight'];            $agehight_year=$current_year-$agehight;            $agehight_dob = date("$agehight_year-m-d");            if ($agehight=="0") {            $agehight_query="";            } else {            $agehight_query=" and employee.dob>'$agehight_dob'";            }                        $from=$_POST['startDatepicker'];            $from_ex = explode("/", $from);            $from_ok = $from_ex[2]."-".$from_ex[0]."-".$from_ex[1]; // porción1            if ($from_ok=="--") {            $from_query="";            } else {                     $from_query=" and contact.dat>='$from_ok'";                }                        $to=$_POST['endDatepicker'];            $to_ex = explode("/", $to);            $to_ok = $to_ex[2]."-".$to_ex[0]."-".$to_ex[1]; // porción1            if ($to_ok=="--") {            $to_query="";            } else {                     $to_query=" and contact.dat<='$to_ok'";                }                                    //gender needed?            if ($gender=="all") {            $gender_query="";            } else {            $gender_d = $obj1->encode($gender);            $gender_query=" and employee.gender='$gender_d'";            }                         $connection = mysqli_connect($host, $user, $pw, $db);                        if ($location=="") {                $location_query="";            } else {                $location_query="and contact.locid='$location'";                            }            // GENERAL QUERY                         $query=$_POST[tab];            $result = mysqli_query($connection, $query);          // echo "<br><b>$query</b><br><br>";            $row_cnt = $result->num_rows;                                 while($row = mysqli_fetch_array($result))   {                $contact_date=$row['dat'];                $contact_id=$row['contact_id'];                $client_id=$row['client_id'];                 $location_id=$row['location_id'];                                $employee_id=$row['employee_id'];                                 $employee_type=$row['type'];                                $employee_dept=$row['dept'];                $employee_gender=$row['gender'];                $employee_pos=$row['pos'];                $employee_desg=$row['desg'];                $employee_hyear=$row['hyear'];                $employee_hplan=$row['hplan'];                $employee_dob=$row['dob'];                                $employer_name=$row['fname'];                              $employer_name=$obj1->decode($employer_name);                $employer_lname=$row['lname'];                  $employer_lname=$obj1->decode($employer_lname);                $contype=$row['contype'];                  $contype=$obj1->decode($contype);                                               // search consult type: 1 hcmain                $queryHC="SELECT * from hcmain where conid='$contact_id'";                $resultHC = mysqli_query($connection, $queryHC);                  $row_cntHC = $resultHC->num_rows;                  //echo "<b>Contact id $contact_id done $row_cntHC health consults</b></br>";                if ($row_cntHC>0) {                    while($rowHC = mysqli_fetch_array($resultHC))   {                    $hcconsult=$rowHC['id'];                    }                    $hc="Healt consult ($hcconsult)";                                    }                // search consult type: 1 icmain                $queryIC="SELECT * from icmain where conid='$contact_id'";                $resultIC = mysqli_query($connection, $queryIC);                  $row_cntIC = $resultIC->num_rows;                  //echo "<b>Contact id $contact_id done $row_cntHC health consults</b></br>";                if ($row_cntIC>0) {                    while($rowIC = mysqli_fetch_array($resultIC))   {                    $icconsult=$rowIC['id'];                    }                    $ic="Injury consult ($icconsult)";                                    }                                // search consult type: 1 icmain                $queryOC="SELECT * from ocmain where conid='$contact_id'";                $resultOC = mysqli_query($connection, $queryOC);                  $row_cntOC = $resultOC->num_rows;                  //echo "<b>Contact id $contact_id done $row_cntHC health consults</b></br>";                if ($row_cntOC>0) {                    while($rowOC = mysqli_fetch_array($resultOC))   {                    $occonsult=$rowOC['id'];                    }                    $oc="Injury consult ($occonsult)";                                    }                                                            // create array                 $arr[] = "$employee_id****$employer_name****$employer_lname****$employee_dob****$employee_dept****$employee_hyear****$employee_gender****$employee_pos****$employee_desg****$employee_type****$employee_hplan";    }        $result = array_unique($arr);    sort($result);    $table.= "<table border=1>";    $table.= "<tr><td>Client: $_POST[client]<br>Location: $_POST[location]<br>$_POST[clientmore]<br>Age low: $_POST[agelow]<br>Age Hight: $_POST[agehight]<br>From: $_POST[from]<br>To: $_POST[to]<br>Gender: $_POST[gender]</td><td colspan=14>TOTAL EMPLOYEES: $_POST[tot_emp]<br> TOTAL HC: $_POST[tot_hc] ($_POST[per_hc]%)<br> TOTAL IC: $_POST[tot_ic] ($_POST[per_ic]%) <br> TOTAL OC: $_POST[tot_oc] ($_POST[per_oc]%) <br>TOTAL PC: $_POST[tot_pc] ($_POST[per_pc]%)</td></tr>";            $table.= "<tr><td>LAST NAME<td><td>FIRST NAME</td><td>DEPT</td><td>DOB</td><td>Hiring Year</td><td>GENDER</td><td>POS</td><td>TYPE OF HIRING</td><td>HEALTH PLAN</td><td>CLIENT</td><td>LOCATION</td><td>Contacts</td><td>Consults</td><td>CONSULT LIST</td></tr>";    // echo "<table><tr><td><b>Total Employees with contacts in range: ".count($result)."</b></td></tr>";    foreach ($result as $clave => $valor) {    $porciones = explode("****", $valor);    $emp_id= $porciones[0];     $emp_fname= $porciones[1];    $emp_lname= $porciones[2];        $emp_dob= $porciones[3];     $emp_dept= $porciones[4];     $emp_hyear= $porciones[5];    $emp_gender= $porciones[6];    $emp_pos= $porciones[7];    $emp_desg= $porciones[8];    $emp_type= $porciones[9];    $emp_hplan= $porciones[10];            $query2="SELECT * from contact  where contact.empid = '$emp_id' $from_query $to_query  ";    $result2 = mysqli_query($connection, $query2);      $row_cnt2 = $result2->num_rows;        // show depending on number of  contact    $num_contact=$_POST[num_contact];    if ($num_contact=="") {        $num_contact="0";    }    if ($row_cnt2>=$num_contact) {             //count consults    $queryC="SELECT * from contact  where contact.empid = '$emp_id' $from_query $to_query  ";    $resultC = mysqli_query($connection, $queryC);      $row_cntC = $resultC->num_rows;    $tot_HC=0;    $tot_IC=0;    $tot_PC=0;     $tot_OC=0;    $tot=0;             while($row_cntC = mysqli_fetch_array($resultC))   {         $id_contatto=$row_cntC['id'];           $queryHC3="SELECT * from hcmain where conid='$id_contatto'";         $resultHC3 = mysqli_query($connection, $queryHC3);           $row_cntHC3 = $resultHC3->num_rows;          $tot_HC +=$row_cntHC3;                  $queryIC3="SELECT * from icmain where conid='$id_contatto'";         $resultIC3 = mysqli_query($connection, $queryIC3);           $row_cntIC3 = $resultIC3->num_rows;          $tot_IC +=$row_cntIC3;                  $queryOC3="SELECT * from ocmain where conid='$id_contatto'";         $resultOC3 = mysqli_query($connection, $queryOC3);           $row_cntOC3 = $resultOC3->num_rows;          $tot_OC +=$row_cntOC3;                          $queryPC3="SELECT * from pcmain where conid='$id_contatto'";         $resultPC3 = mysqli_query($connection, $queryPC3);           $row_cntPC3 = $resultPC3->num_rows;          $tot_PC +=$row_cntPC3;                }    $tot=$tot_HC+$tot_IC+$tot_OC+$tot_PC;    //echo "H $tot_HC I $tot_IC O $tot_OC P $tot_PC TOTALE: $tot;<br>";        //echo "EMP: $emp_id has $tot consults";   if ($tot<=$_POST[num_consults]) {     } else {                            $table.= "<tr><td>$emp_lname<td><td>$emp_fname</td><td>".$obj1->decode($emp_dept)."</td><td>$emp_dob</td><td>".$obj1->decode($emp_hyear)."</td><td>".$obj1->decode($emp_gender)."</td><td>".$obj1->decode($emp_pos)."</td><td>".$obj1->decode($emp_type)."</td><td>".$obj1->decode($emp_hplan)."</td><td>".$obj1->decode(clientIdToName($client_id))."</td><td>".$obj1->decode(locationIdToName($location_id))."</td><td>$row_cnt2</td><td>$tot</td>";            $query2="SELECT * from contact  where contact.empid = '$emp_id' $from_query $to_query  ";    $result2 = mysqli_query($connection, $query2);      $row_cnt2 = $result2->num_rows;    while($row2 = mysqli_fetch_array($result2))   {    $con_id=$row2['id'];            $con_date=$row2['dat'];    $con_type=$row2['contype'];    $con_type=$obj1->decode($con_type);        // search consult type: 1 icmain    $ic2="";        $queryIC2="SELECT * from icmain where conid='$con_id'";    $resultIC2 = mysqli_query($connection, $queryIC2);      $row_cntIC2 = $resultIC2->num_rows;      if ($row_cntIC2>0) {    while($rowIC2 = mysqli_fetch_array($resultIC2))   {    $icconsult2=$rowIC2['id'];    $conta_ic++;       $ic2="[Injury consult]";      }                      }          // search consult type: 1 icmain    $hc2="";        $queryHC2="SELECT * from hcmain where conid='$con_id'";    $resultHC2 = mysqli_query($connection, $queryHC2);      $row_cntHC2 = $resultHC2->num_rows;      if ($row_cntHC2>0) {    while($rowHC2 = mysqli_fetch_array($resultHC2))   {    $hcconsult2=$rowHC2['id'];    $conta_hc++;    $hc2.="[Health consult]";     }                       }         // search consult type: 1 icmain    $oc2="";    $queryOC2="SELECT * from ocmain where conid='$con_id'";    $resultOC2 = mysqli_query($connection, $queryOC2);      $row_cntOC2 = $resultOC2->num_rows;      if ($row_cntOC2>0) {    while($rowOC2 = mysqli_fetch_array($resultOC2))   {    $occonsult2=$rowOC2['id'];    $conta_oc++;        $oc2="[Opportunity consult]";     }                       }         // search consult type: 1 icmain    $pc2="";    $queryPC2="SELECT * from pcmain where conid='$con_id'";    $resultPC2 = mysqli_query($connection, $queryPC2);      $row_cntPC2 = $resultPC2->num_rows;      if ($row_cntPC2>0) {    while($rowPC2 = mysqli_fetch_array($resultPC2))   {    $pcconsult2=$rowPC2['id'];    $conta_pc++;        $pc2="[Proactive consult]";     }                       }         $table.= "<td>$con_date - $con_type $hc2 $ic2 $oc2 $pc2</td>";    }$table.="</tr>";    }    // end tot contact    }    // end tot consult        }          $table.= "</table>";        echo $table;      ?>                                                                                                                                                                                                                                                           					