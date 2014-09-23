<script>
var jArray= <?php echo json_encode($names ); ?>;  
var jArray2= <?php echo json_encode($ids ); ?>; 
$(document).ready(function() {
    $("#add").click(function() {
        var intId = $("#addclient div").length + 1;
        

        
        var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
        var select0 = "<select id='lst_client" + intId + "' name='lst_client" + intId + "'>";
        var select1 = "<option value=xxx>Select a client</option>";
        
    var select2= "";
    var i;
    
    // must find a better way to count the clients
    for (i = 0; i < 10; i++) {
        select2+= "<option value=" + jArray2[i] + ">" + jArray[i] + "</option>";
    }
            
            
        var select3 = "</select>";
        var fType = select0 + select1 + select2 + select3;
        var location1 ="<select name=lst_location" + intId + " id=lst_location" + intId + "><option value=>First select a client</option></select>  "
        var removeButton = $("<input type=\"button\" class=\"remove\" value=\"-\" />");
        removeButton.click(function() {
            $(this).parent().remove();
        });
        fieldWrapper.append(fType);
        fieldWrapper.append(location1);
        fieldWrapper.append(removeButton);
        $("#addclient").append(fieldWrapper);
        
if ($("#lst_client" + intId).length > 0){ // if new client is added to search
 
 
//////////////////////////////////////////////////////////////11111111111111 
var lst_location_id1 = 'lst_location1'; //first select list ID
var lst_client_id1 = 'lst_client1'; //second select list ID
$('#'+lst_client_id1).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id1).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id1).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id1).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////11111111111111
//////////////////////////////////////////////////////////////22222222222222 
var lst_location_id2 = 'lst_location2'; //first select list ID
var lst_client_id2 = 'lst_client2'; //second select list ID
$('#'+lst_client_id2).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id2).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id2).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id2).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////2222222222
//////////////////////////////////////////////////////////////33333333333333 
var lst_location_id3 = 'lst_location3'; //first select list ID
var lst_client_id3 = 'lst_client3'; //second select list ID
$('#'+lst_client_id3).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id3).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id3).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id3).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////3333333333
//////////////////////////////////////////////////////////////44444444444444 
var lst_location_id4 = 'lst_location4'; //first select list ID
var lst_client_id4 = 'lst_client4'; //second select list ID
$('#'+lst_client_id4).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id4).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id4).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id4).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////4444444444
//////////////////////////////////////////////////////////////55555555555555 
var lst_location_id5 = 'lst_location5'; //first select list ID
var lst_client_id5 = 'lst_client5'; //second select list ID
$('#'+lst_client_id5).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id5).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id5).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id5).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////5555555555
//////////////////////////////////////////////////////////////66666666666666 
var lst_location_id6 = 'lst_location6'; //first select list ID
var lst_client_id6 = 'lst_client6'; //second select list ID
$('#'+lst_client_id6).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id6).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id6).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id6).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////6666666666
//////////////////////////////////////////////////////////////77777777777777 
var lst_location_id7 = 'lst_location7'; //first select list ID
var lst_client_id7 = 'lst_client7'; //second select list ID
$('#'+lst_client_id7).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id7).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id7).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id7).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////7777777777
//////////////////////////////////////////////////////////////88888888888888 
var lst_location_id8 = 'lst_location8'; //first select list ID
var lst_client_id8 = 'lst_client8'; //second select list ID
$('#'+lst_client_id8).change(function(e) {
var selectvalue = $(this).val();
$('#'+lst_location_id8).html('<option value="">Loading...</option>');
if (selectvalue == "") {
$('#'+lst_location_id8).html(initial_target_html);
} else {
$.ajax({url: 'xxxlocationCall.php?svalue='+selectvalue,
success: function(output) {
$('#'+lst_location_id8).html(output);
},
error: function (xhr, ajaxOptions, thrownError) {
alert(xhr.status + " "+ thrownError);
}});
}
});
//////////////////////////////////////////////////////////////8888888888
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
 
 
 
} else {
 alert("no");    
    }
//        $('#'+lst_client1_id).change(function(e) {
//              alert("caz");
//          });
    });
   
});
</script>