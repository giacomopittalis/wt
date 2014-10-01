$("#info-btn").click(function()
{
    $(".consult-list li").removeClass("active");
    $(this).addClass("active");
    $("#info").fadeIn();$("#topic").fadeOut();$("#soap").fadeOut();
});

$("#topic-btn").click(function()
{
    $(".consult-list li").removeClass("active");
    $(this).addClass("active");
    $("#info").fadeOut();$("#topic").fadeIn();$("#soap").fadeOut();
});

$("#soap-btn").click(function(){
    $(".consult-list li").removeClass("active");
    $(this).addClass("active");
    $("#info").fadeOut();$("#topic").fadeOut();$("#soap").fadeIn();
});

/**
 * Employee Script
 *
 * @author		Sandi Andrian
 * @since 		Oct 1, 2014
 **/
$(function()
{
	$('#client_id_employee').change(function()
	{
		Employee.getData();
		//alert('halo');
	});

	$('#location_id_employee').change(function()
	{
		Employee.getData();
		//alert('Halo!');
	});

	var Employee = new function()
	{
		this.url		  = './employee/ajax/employees';
		this.client_id 	  = $('#client_id_employee').val();
		this.location_id  = $('#location_id_employee').val();

		this.getData = function()
		{
			console.log('CLIENT ID: ' + this.client_id);
			console.log('LOCATION ID: ' + this.location_id);

			if(this.client_id != 0 && this.location_id != 0)
			{
				console.log('AJAX STARTED');
				
				//run ajax
				$.ajax({
				  type: "GET",
				  url: this.url,
				  data: { client_id: this.client_id, location_id: location_id }
				})
				.done(function(oResp)  
				{
				    console.log('DATA: ' + oResp);
				});
				console.log('AJAX STOPPED');
			}
		};
	}
});