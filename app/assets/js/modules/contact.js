/**
 * Contact Script
 *
 * @author		Sandi Andrian
 * @since 		Oct 1, 2014
 **/
$(function()
{

	$('#client_id').change(function()
	{
		var client_id = $(this).val();
		if(client_id != 0)
		{
			$(this).nextAll().remove();
		}
		Contact.client_id = client_id;
		Contact.getData();
	});

	$('#location_id').change(function()
	{
		var location_id = $(this).val();
		if(location_id != 0)
		{
			$(this).nextAll().remove();
		}
		Contact.location_id = location_id;
		Contact.getData();
		//alert('Halo!');
	});

	$('#contact_id').change(function()
	{
		var contact_id = $(this).val();
		if(contact_id != 0)
		{
			$(this).nextAll().remove();
		}
		$('input[name="health_consult_id"]').val(contact_id);
	});

	var Contact = new function()
	{
		this.url		  = '/contact/ajax/get-contacts';
		this.client_id 	  = 0;
		this.location_id  = 0;
		this.contact      = 0;

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
					var rtn = '<option value="0" disabled="" selected="">Select Contact ID</option>';
					if(oResp.code == '404')
					{
						alert('No Contact Found');
						$('select[name="contact_id"]').empty()
				        			    			  .html(rtn);
					}
					else
					{
						
						$.each(oResp.buff, function(idx) 
						{
							rtn += '<option value="'+oResp.buff[idx].id+'">#'+oResp.buff[idx].id+' '+oResp.buff[idx].first_name+' '+oResp.buff[idx].last_name + '</option>';
				        });
				        $('select[name="contact_id"]').empty()
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