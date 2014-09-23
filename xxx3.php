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