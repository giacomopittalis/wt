/**
 * Opportunity Script
 *
 * @author		Sandi Andrian
 * @since 		Oct 1, 2014
 **/
$(function()
{

	$('#client_id').change(function()
	{
		OpportunityConsult.client_id = $(this).val();
		OpportunityConsult.getContact();
	});

	$('#location_id').change(function()
	{
		OpportunityConsult.location_id = $(this).val();
		OpportunityConsult.getContact();
		//alert('Halo!');
	});

	$('#contact_id').change(function()
	{	
		OpportunityConsult.getData();
	});

	var OpportunityConsult = new function()
	{
		this.url		  = '/opportunity-consult/ajax/get-opportunity-consult';
		this.client_id 	  = null;
		this.location_id  = null;
		this.contact_id   = 0;

		this.Contact = function()
		{
			if(this.client_id != 0 && this.location_id != 0)
			{
				console.log('AJAX STARTED');
				
				//run ajax
				$.ajax({
				  type: "GET",
				  url: '/contact/ajax/get-contacts',
				  data: { client_id: this.client_id, location_id: this.location_id }
				})
				.done(function(oResp)  
				{
					if(oResp.code == '404')
					{
						alert('No Opportunity Consult Found');
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

		this.getData = function()
		{
			console.log('CLIENT ID: ' + this.client_id);
			console.log('LOCATION ID: ' + this.location_id);

			if(this.client_id != 0 && this.location_id != 0 && this.contact_id != 0)
			{
				console.log('AJAX STARTED');
				
				//run ajax
				$.ajax({
				  type: "GET",
				  url: this.url,
				  data: { client_id: this.client_id, location_id: this.location_id, contact_id: this.contact_id }
				})
				.done(function(oResp)  
				{
					if(oResp.code == '404')
					{
						alert('No Opportunity Consult Found');
					}
					else
					{
						
						$.each(oResp.buff, function(idx) 
						{
							$('#comment').val(oResp.buff[idx].comment);
							$('#notes').val(oResp.buff[idx].notes);
				        });
				       
					}
				    console.log('DATA: ' + oResp);
				});
				console.log('AJAX STOPPED');
			}
		}
	}
	//end on Employee()
});