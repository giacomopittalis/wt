var var_dateRangeSelect_runScripts = true;
$(document).ready(
	function() {
		$('#startMonth').change( 
			function(){ 
				setDaysRange("start"); 
			} 
		),
		$('#startYear').change( 
			function(){
				setDaysRange("start");
			}
		),
		$('#endMonth').change( 
			function(){
				setDaysRange("end");
			}
		),
		$('#endYear').change( 
			function(){
				setDaysRange("end");
			}
		),
		$('#useDateRange').change(
			function(){
				if($('#useDateRange').prop('checked') == true){
					$('#dateRangeSelect').removeClass('hidden');					
				} else{
					$('#dateRangeSelect').addClass('hidden');
				}
			}
		)
	}
);
// function to print the days range according to the month and leap year
function setDaysRange(target){
	if(target == "start"){
		var month = $('#dateRangeSelect').find('#startMonth option:selected').val();
		var year = $('#dateRangeSelect').find('#startYear option:selected').val();
		var targetElement = document.getElementById('startDay');
		var selectedDay = $('#startDay').val();
		while ( targetElement.childNodes.length >= 1 ){
    		targetElement.removeChild(targetElement.firstChild);       
		}
	} else if(target == "end"){
		var month = $('#dateRangeSelect').find('#endMonth option:selected').val();
		var year = $('#dateRangeSelect').find('#endYear option:selected').val();
		var targetElement = document.getElementById('endDay');
		var selectedDay = $('#endDay').val();
		while ( targetElement.childNodes.length >= 1 ){
    		targetElement.removeChild(targetElement.firstChild);       
		}
	}
	var x ="";
	var days = 0;
	switch(month){
		case "January":
			days = 31;
			break;
		case "February":
			if ( isLeapYear(year) ){
		 		days = 29;
			}
			else{
		 		days = 28;	
		  	}
			break;
		case "March":
			days = 31;
			break;
		case "April":
			days = 30;
			break;
		case "May":
			days = 31;
			break;
		case "June":
			days = 30;
			break;
		case "July":
			days = 31;
			break;
		case "August":
			days = 31;
			break;
		case "September":
			days = 30;
		 	break;
		case "October":
			days = 31;
			break;
		case "November":
			days = 30;
			break;
		case "December":
			days = 31;
		  	break;		
		default:
			break;
	}
	console.log(x);
	for(var i = 1; i <= days; i++){
		newOption = document.createElement('option');
    	newOption.value=i;
    	newOption.text=i;
    	if(i == selectedDay){
    		console.log(selectedDay + " "+i+" is the selected day");
    		newOption.selected = true;
    	}
		targetElement.appendChild(newOption);
	}
	console.log(days);

}

function isLeapYear(year){
	var remainder = year % 4;
	if(remainder == 0){
		return true;
	}
	else{
		return false;
	}

}