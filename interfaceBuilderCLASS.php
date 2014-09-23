
<?php
	include_once "dataQueryclass.php";
	class interfaceBuilder extends dataQuery{


		public function buildLocationCheckboxes($clientID){
 			$locations = $this->getClientLocations($clientID);
 			if( is_array($locations) ){
 				foreach ($locations as $key => $loc) {
 					echo("<input type='checkbox' name='uselocation_".$loc['id']."' id='uselocation_".$loc['id']."' value='".$loc['id']."'><label style='display:inline;'for='uselocation_".$loc['id']."' >".$loc['locid']."</label><br/>");
 				}
 			}
		}

	}

///END CLASS
//// AJAX CATCHES

	if( isset($_GET['buildLocationCheckboxes']) ){
		$clientID = $_GET['buildLocationCheckboxes'];
		$ifb = new interfaceBuilder;
		$ifb->buildLocationCheckboxes($clientID);
	}

?>