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
						alert('No Health Consult Found');
					}
					else
					{
						
						$.each(oResp.buff, function(idx) 
						{
							$('input[name="health_consult_id"]').val(oResp.buff[idx].id);
							if(oResp.buff[idx].under_medical_care == 1)
							{
								$("#under_medical_care").prop('checked',true);
							}

							//info
							var info = $.parseJSON(oResp.buff[idx].info);
							if(info)
							{
								$('input[name="info[height]"]').val(info.height);
								$('input[name="info[weight]"]').val(info.weight);
								$('input[name="info[bmi]"]').val(info.bmi);
								$('input[name="info[body_fat]"]').val(info.body_fat);
								$('input[name="info[height]"]').val(info.height);
								$('input[name="info[hydration]"]').val(info.hydration);
								$('input[name="info[height]"]').val(info.height);
								$('input[name="info[bmr]"]').val(info.bmr);
								$('input[name="info[visceral_fat]"]').val(info.visceral_fat);
								$('input[name="info[bone_mass]"]').val(info.bone_mass);
								$('input[name="info[muscle_mass]"]').val(info.muscle_mass);
								$('input[name="info[waist_circumference]"]').val(info.waist_circumference);
								$('input[name="info[hip_circumference]"]').val(info.hip_circumference);
								$('input[name="info[thigh_circumference]"]').val(info.thigh_circumference);
								$('input[name="info[arm_circumference]"]').val(info.arm_circumference);
								$('input[name="info[chest_circumference]"]').val(info.chest_circumference);
								$('input[name="info[systolic]"]').val(info.systolic);
								$('input[name="info[diastolic]"]').val(info.diastolic);
								$('input[name="info[heart_rate]"]').val(info.heart_rate);
								$('input[name="info[glucose]"]').val(info.glucose);
								$('input[name="info[total_cho]"]').val(info.total_cho);
								$('input[name="info[hdl]"]').val(info.hdl);
								$('input[name="info[ldl]"]').val(info.ldl);
								$('input[name="info[ratio]"]').val(info.ratio);
								$('input[name="info[triglycerides]"]').val(info.triglycerides);
							}

							if(oResp.buff[idx].topics)
							{
								$.each(oResp.buff[idx].topics.toString().split(','), function (index, value) 
								{
								  $('input[name="topic[]"][value="' + value.toString() + '"]').prop("checked", true);
								});
							}

							if(oResp.buff[idx].soap)
							{
								$.each(oResp.buff[idx].soap.toString().split(','), function (index, value) 
								{
								  $('input[name="soap[]"][value="' + value.toString() + '"]').prop("checked", true);
								});
							}

							if(oResp.buff[idx].follow_up == 1)
							{
								$('input[name="follow_up"]').prop('checked',true);
							}
							$('textarea[name="notes"]').val(oResp.buff[idx].notes);
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