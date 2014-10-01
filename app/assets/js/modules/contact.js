/**
 * Contact Script
 *
 * @author		Sandi Andrian
 * @since 		Oct 1, 2014
 **/
$(function()
{

	$('#client_id_contact').change(function()
	{
		Contact.client_id = $(this).val();
		Contact.getData();
	});

	$('#location_id_contact').change(function()
	{
		Contact.location_id = $(this).val();
		Contact.getData();
		//alert('Halo!');
	});

	$('#contact_id').change(function()
	{
		$('input[name="contact_id"]').val($(this).val());
	});

	var Contact = new function()
	{
		this.url		  = '/contact/ajax/get-contacts';
		this.client_id 	  = $('#client_id_contact').val();
		this.location_id  = $('#location_id_contact').val();
		this.contact  = 0;

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
				  data: { client_id: this.client_id, location_id: this.location_id}
				})
				.done(function(oResp)  
				{
					if(oResp.code == '404')
					{
						alert('No Contact Found');
					}
					else
					{
						var rtn = '<option value="0" disabled="" selected="">Select Contact</option>';
						$.each(oResp.buff, function(idx) 
						{
							rtn += '<option value="'+oResp.buff[idx].id+'">Contact #'+oResp.buff[idx].id+'</option>';
				        });
				        $('#contact_id').empty()
				        			    .html(rtn);
						//$('#employee_id').append()
					}
				    console.log('DATA: ' + oResp);
				});
				console.log('AJAX STOPPED');
			}
		}
	}
	//end on Employee()
});