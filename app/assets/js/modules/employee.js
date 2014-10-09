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
		Employee.client_id = $(this).val();
		Employee.getData();
		//alert('halo');
	});

	$('#location_id_employee').change(function()
	{
		Employee.location_id = $(this).val();
		Employee.getData();
		//alert('Halo!');
	});

	$('#employee_id').change(function()
	{
		var employee_id = $(this).val();
		Employee.employee_id = employee_id;
		Employee.getInfo();
	});

	var Employee = new function()
	{
		this.url		  = '/employee/ajax/get-employees';
		this.client_id 	  = $('#client_id_employee').val();
		this.location_id  = $('#location_id_employee').val();
		this.employee_id  = 0;

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
				  data: { client_id: this.client_id, location_id: this.location_id }
				})
				.done(function(oResp)  
				{
					if(oResp.code == '404')
					{
						alert('No Employee Found');
						$('#create-employee').find('input:text, input:password, input:file, textarea').val('');
					    $('#create-employee').find('input:radio, input:checkbox')
					         				 .removeAttr('checked').removeAttr('selected');

					    //employee_id
					    var rtn = '<option value="0" disabled="" selected="">Select Employee</option>';
					    $('#employee_id').empty()
				        				 .html(rtn);
				        //sex
				        $('select[name="sex"], select[name="hire_year"], select[name="hire_type"]').val('0');

					}
					else
					{
						var rtn = '<option value="0" disabled="" selected="">Select Employee</option>';
						$.each(oResp.buff, function(idx) 
						{
							rtn += '<option value="'+oResp.buff[idx].id+'">'+oResp.buff[idx].first_name+' '+oResp.buff[idx].last_name+'</option>';
				            //alert(oResp.buff[index].id);
				            //alert(oResp.buff[index].first_name);
				        });
				        $('#employee_id').empty()
				        				 .html(rtn);
						//$('#employee_id').append()
					}
				    console.log('DATA: ' + oResp);
				});
				console.log('AJAX STOPPED');
			}
		}

		this.getInfo = function()
		{
			if(this.employee_id != 0)
			{
				console.log('AJAX STARTED');
					
					//run ajax
					$.ajax({
					  type: "GET",
					  url: '/employee/ajax/get-info',
					  data: { id: this.employee_id }
					})
					.done(function(oResp)  
					{
						if(oResp.code == '404')
						{
							alert('No Employee Found');
						}
						else
						{
							$.each(oResp.buff, function(idx) 
							{
								$('input[name="employee_id"]').val(oResp.buff[idx].id);
								//Nomenclature
								$('#first_name').val(oResp.buff[idx].first_name);
								$('#middle_name').val(oResp.buff[idx].middle_name);
								$('#last_name').val(oResp.buff[idx].last_name);
								//Personal Demographics
								$('#sex').val(oResp.buff[idx].sex);
								var dob = oResp.buff[idx].dob;
								if(dob)
								{
									var ndob = dob.split('-');
									$('#dob_year').val(ndob[0]);
									$('#dob_month').val(ndob[1]);
									$('#dob_day').val(ndob[2]);
								}
								
								//Official Demographics
								$('input[name="department"]').val(oResp.buff[idx].department);
								$('input[name="position"]').val(oResp.buff[idx].position);
								$('input[name="employee_number"]').val(oResp.buff[idx].employee_number);
								$('#hire_year').val(oResp.buff[idx].hire_year);
								$('#hire_type').val(oResp.buff[idx].hire_type);
								$('#health_plan').val(oResp.buff[idx].health_plan);
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