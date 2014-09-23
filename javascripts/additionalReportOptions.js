
$(document).ready(
	function() {
			console.log("OVERRIDE ACTIVATED");

		$('#useParticipatingEmpsOveride').change(
			function(){
				console.log("OVERRIDE BUTTON CLICKED");
				if($('#useParticipatingEmpsOveride').prop('checked') == true){
					$('#participatingEmpsOveride').removeClass('hidden');					
				} else{
					$('#participatingEmpsOveride').addClass('hidden');
				}
			}
		)
							       // TARGET = 	<span id="locationCheckboxes">
	}
);




