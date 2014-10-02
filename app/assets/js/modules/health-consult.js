/**
 * Proactive Consult Script
 *
 * @author		Sandi Andrian
 * @since 		Oct 2, 2014
 **/
$(function()
{

	$('#contact_id_health').change(function()
	{	
		HealthConsult.client_id  = $('#client_id').val();
		HealthConsult.location_id = $('#location_id').val(); 
		HealthConsult.contact_id = $(this).val();
		HealthConsult.getData();
		$('input[name="id"]').val($(this).val());
	});

	var HealthConsult = new function()
	{
		this.url		  = '/health-consult/ajax/get-health-consult';
		this.client_id 	  = 0;
		this.location_id  = 0;
		this.contact_id   = 0;

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
							if(oResp.buff[idx].under_medical_care == 1)
							{
								$("#under_medical_care").prop('checked',true);
							}

							//comment
							var comment = JSON.parse(oResp.buff[idx].comment);
							//console.log('COMMENT: ' + comment.comment_type);
							$('#type').val(comment.type);
							$('#comment').val(comment.comment);

							if(oResp.buff[idx].follow_up == 1)
							{
								$("#follow_up").prop('checked',true);
							}
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