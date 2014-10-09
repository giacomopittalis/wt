/**
 * Proactive Consult Script
 *
 * @author		Sandi Andrian
 * @since 		Oct 2, 2014
 **/
$(function()
{

	$('#contact_id_injury').change(function()
	{	
		InjuryConsult.client_id  = $('#client_id').val();
		InjuryConsult.location_id = $('#location_id').val(); 
		InjuryConsult.contact_id = $(this).val();
		InjuryConsult.getData();
		//$('input[name="id"]').val($(this).val());
	});

	var InjuryConsult = new function()
	{
		this.url		  = '/injury-consult/ajax/get-injury-consult';
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
						alert('No Injury Consult Found');
					}
					else
					{
						
						$.each(oResp.buff, function(idx) 
						{
							$('input[name="id"]').val(oResp.buff[idx].id);

							if(oResp.buff[idx].under_medical_care == 1)
							{
								$("#under_medical_care").prop('checked',true);
							}

							var info = $.parseJSON(oResp.buff[idx].info);
							if(info)
							{
								var general = info.general;
								if(general)
								{
									var work = general.work;
									if(work)
									{
										$.each(work.toString().split(','), function (index, value) 
										{
										  $('input[name="info[general][work][]"][value="' + value.toString() + '"]').prop("checked", true);
										});
									}
									
									if(general.moi)
									{
										$('textarea[name="info[general][moi]"]').val(general.moi);
									}
									
									var criteria = general.criteria;
									if(criteria)
									{
										$.each(criteria.toString().split(','), function (index, value) 
										{
										  $('input[name="info[general][criteria][]"][value="' + value.toString() + '"]').prop("checked", true);
										});
									}
								}

								var pain_level = info.pain_level;
								if(pain_level)
								{
									if(pain_level.general)
									{
										$('select[name="info[pain_level][general]"]').val(pain_level.general);
									}
									
									if(pain_level.criteria)
									{
										var criteria = pain_level.criteria;
										if(criteria)
										{
											$.each(criteria.toString().split(','), function (index, value) 
											{
											  $('input[name="info[pain_level][criteria][]"][value="' + value.toString() + '"]').prop("checked", true);
											});
										}
									}
								}

								if(info.lost_time)
								{
									$('input[name="info[lost_time]"]').val(info.lost_time);
								}
								
								if(info.md_seen == 1)
								{
									$('input[name="info[md_seen]"').prop('checked',true);
								}

								$('select[name="info[body_part]"]').val(info.body_part);
								$('select[name="info[injury_type]"]').val(info.injury_type);
								$('select[name="info[severity_rate]"]').val(info.severity_rate);
								$('select[name="info[pain_rate]"]').val(info.pain_rate);
								$('select[name="info[body_part]"]').val(info.body_part);
								$('select[name="info[improvement_level]"]').val(info.improvement_level);
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