var var_locationCheckboxesSelect_runScripts = true;
$(document).ready(
	function() {
		$('#useLocationSelect').change(
			function(){
				if($('#useLocationSelect').prop('checked') == true){
					$('#locationSelect').removeClass('hidden');					
				} else{
					$('#locationSelect').addClass('hidden');
				}
			}
		)
							       // TARGET = 	<span id="locationCheckboxes">
	
		// add locations to #locationCheckboxes
		$('#sel1').change(
			function(){
				var clientID = $('#sel1').find(":selected").val();
				//console.log("sending to AJAX");
				updateLocationCheckboxes(clientID); // AJAX
			}
		)
		//initialize
		var clientID = $('#sel1').find(":selected").val();
		updateLocationCheckboxes(clientID);

	}
);


////// ADD SELECT ALL and DESELECT ALL functions


function updateLocationCheckboxes(clientID){
	try{ /*Generally non IE browsers*/
		ajax = new XMLHttpRequest();
	}
	catch (e){ /*IE 6 and down*/
		try{
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e){
			try{
				ajax = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){ /*Failure to define ajax (old or broken browser)*/
				alert("Your browser is too old, or is misconfigured");
				return false;
			}
		}
	}
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			document.getElementById("locationCheckboxes").innerHTML = ajax.responseText;
		}
	};
	ajax.open("GET", "interfaceBuilderCLASS.php?buildLocationCheckboxes=" + clientID, true);
	ajax.send(null);
}

