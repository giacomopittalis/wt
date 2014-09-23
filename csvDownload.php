<?php
session_start();
include 'sessionclass.php';
include 'dataExportClass.php';

/*http://stackoverflow.com/questions/217424/create-a-csv-file-for-a-user-in-php*/
$dataExport = new dataExport;
if (isset($_POST['generateANDexportData'])){
  $clientID = $_POST['lc'];

  //DATE RANGE
  if( isset($_POST['useDateRange']) ){
    // if it is set it should be on - does not report when unchecked
    //$useDateRange = $_POST['useDateRange'];
    $useDateRange = true;
  } else{
    //$useDateRange = "off";
    $useDateRange = false;
  }

  $startMonth = getNumericMonth( $_POST['startMonth'] );
  $startDay = $_POST['startDay'];
  $startYear = $_POST['startYear'];
  $endMonth = getNumericMonth( $_POST['endMonth'] );
  $endDay = $_POST['endDay'];
  $endYear = $_POST['endYear'];
  $dateRange = array(
    'useDateRange' => $useDateRange,
    'startMonth' => $startMonth,
    'startDay' => $startDay,
    'startYear' => $startYear,
    'endMonth' => $endMonth,
    'endDay' => $endDay,
    'endYear' => $endYear,
  );
  //END DATE RANGE
  
  //LOCATIONS OPTIONS // array of all post values - check for useLocation_ key - chop out value and save in $location array
  $postkeys = array_keys($_POST);
  $locs = array();
  foreach($postkeys as $pk){
    if( strpos($pk, "uselocation_") !== false){
      array_push($locs,preg_replace( "/uselocation_/", "",$pk) );
    }
  }
  if(isset($_POST['useLocationSelect'])){
    $useLocationSelect=true;
  }else{
    $useLocationSelect=false;
  }
  $locations = array(
    'useLocations' => $useLocationSelect,
    'ids' => $locs,
  );
  //END LOCATIONS OPTIONS

  $reportType = $_POST['reportType'];
  //$csvReturn =  $dataExport->createClientCSV($clientID,$useDateRange,$startDay,$startMonth,$startYear,$endDay,$endMonth,$endYear);
  
  $dev=false;
  switch ($reportType){
    case "Full":
      $csvReturn =  $dataExport->createCSV_FullEmployeeReport($clientID,$dateRange);
      // ran in 168 seconds for Hancock Estabrook // way too slow - was more like 15 before
      //$csvReturn = $dataExport->createClientCSV($clientID,$dateRange);
      //$csvReturn = $dataExport->createClientCSVplainSQL($clientID,$dateRange);
      break;
    case "ContactConsultOverview":
      $csvReturn =  $dataExport->createCSV_ContactConsultOverview($clientID,$dateRange);
      break;
    case "ContactMethodOverview":
      $csvReturn =  $dataExport->createCSV_ContactMethodOverview($clientID,$dateRange);
      break;
    case "ParticipationByLocation":
      $csvReturn =  $dataExport->createCSV_ParticipationByLocation($clientID,$dateRange);
      break;
    case "Test":
      $csvReturn =  $dataExport->Test($clientID,$dateRange);
      break;
    case "HealthConsultTopics":
      $csvReturn =  $dataExport->createCSV_HealthConsultTopics($clientID,$dateRange,$locations,$dev);
      break;
    case "ProactiveConsultTopics":
      $csvReturn =  $dataExport->createCSV_ProactiveConsultTopics($clientID,$dateRange,$locations,$dev);
      break;
    case "InjuryConsultTopics":
      $csvReturn =  $dataExport->createCSV_InjuryConsultTopics($clientID,$dateRange,$locations,$dev);
      break;
    case "ExecutiveSummary":
      $csvReturn =  $dataExport->createCSV_ExecutiveSummary($clientID,$dateRange);
      break;
    case "Metrics":
      //$csvReturn =  $dataExport->createCSV_Metrics($clientID,$dateRange);
      $csvReturn =  $dataExport->createCSV_Metrics($clientID,$dateRange,$locations,$dev);
      break;


  }
  $_SESSION['csvText']= $csvReturn['csv'];
  $_SESSION['csvFileName'] = $csvReturn['name'];
}

function getNumericMonth($monthName){
  switch($monthName){
    case 'January':
      return 1;
    case 'February':
      return 2;
    case 'March':
      return 3;
    case 'April':
      return 4;
    case 'May':
      return 5;
    case 'June':
      return 6;
    case 'July':
      return 7;
    case 'August':
      return 8;
    case 'September':
      return 8;
    case 'October':
      return 10;
    case 'November':
      return 11;
    case 'December':
      return 12;
  }
}
                                                                                          /*
                                                                                          header("Content-type: text/csv");
                                                                                          //header("Content-Disposition: attachment; filename=file.csv");
                                                                                          header('Content-Disposition: attachment; filename="'. $name.'.csv"');
                                                                                          header("Pragma: no-cache");
                                                                                          header("Expires: 0");
                                                                                          $data = $_SESSION['csvText'];
                                                                                          outputCSV($data);
                                                                                          function outputCSV($data) {
                                                                                              $output = fopen("php://output", "w");
                                                                                              //foreach ($data as $row) {
                                                                                              //    fputcsv($output, $row);
                                                                                              //}
                                                                                              fputcsv($data, 0);
                                                                                              fclose($output);
                                                                                          }
                                                                                          */
  // Output CSV-specific headers
$name = $_SESSION['csvFileName'];
$data = $_SESSION['csvText'];

provideCSV($data,$name);
                                                                                                    //$data = 'This,is,the,first,line';
                                                                                                    //echo('-------');
                                                                                                    //echo($data);
                                                                                                    /*
                                                                                                    header('Pragma: public');
                                                                                                    header('Expires: 0');
                                                                                                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                                                                                                    header('Cache-Control: private', false);
                                                                                                    header('Content-Type: application/octet-stream');
                                                                                                    header('Content-Disposition: attachment; filename="' . $name . '.csv";');
                                                                                                    header('Content-Transfer-Encoding: utf8_encode(data)');
                                                                                                    // Stream the CSV data
                                                                                                    exit($data);
                                                                                                    */
                                                                                                    /*
                                                                                                    echo('asd asd,asd ');
                                                                                                    header('Pragma: public');
                                                                                                    header('Expires: 0');
                                                                                                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                                                                                                    header('Cache-Control: private', false);
                                                                                                    header('Content-Type: application/csv');
                                                                                                    header('Content-Disposition: attachment; filename="'.$name.'.csv";');
                                                                                                    header('Content-Transfer-Encoding: utf8_encode(data)');
                                                                                                    // Stream the CSV data
                                                                                                    exit($data);
                                                                                                    */


 
function provideCSV($data,$name){
  header('Pragma: public');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Cache-Control: private', false);
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$name.'.csv";');
  header('Content-Transfer-Encoding: utf8_encode(data)');
  // Stream the CSV data
  exit($data);
}


?>