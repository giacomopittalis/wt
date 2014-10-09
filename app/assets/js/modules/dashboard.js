/**
 * Dashboard Script
 *
 * @author		Sandi Andrian
 * @since 		Oct 4, 2014
 **/
$(function()
{
	$('#load-more').click(function()
	{
		console.log('AJAX STARTED');	
		var page = $('#page').val();
		$(this).empty().html('Loading...');
		//run ajax
		$.ajax({
		  type: "GET",
		  url: '/dashboard/ajax/load-more',
		  data: { page: page }
		})
		.done(function(oResp)  
		{
			if(oResp.code == '404')
			{
				//do nothing
			}
			else
			{
				//there's data
				var rtn = "";
				$.each(oResp.buff, function(idx) 
				{	
					rtn += '<li class="activity '+oResp.buff[idx].ftype+'">';
			        rtn += '<div class="description"><span class="user">'+oResp.buff[idx].first_name+' '+oResp.buff[idx].last_name+'</span> '+oResp.buff[idx].fcomment+'</div>';
			        rtn += '<div class="date right">'+oResp.buff[idx].created_at+'</div>';
			        rtn += '</li>';
		        });
		        $('.activities').append(rtn);
		       	$('#page').val(parseInt(page) + 1);
			}
		    console.log('DATA: ' + oResp);
		});
		$(this).empty().html('Load more activity');
		console.log('AJAX STOPPED');
	});
});