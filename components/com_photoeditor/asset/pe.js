$(document).ready(function(){


	$('#loadmore').click(function(e){			
		var idx = $('#img-list img').last().attr('img-idx');

		$.ajax({
					url: '<?php echo 'index.php?option=com_benhan&view=user&task=getimgajax&userid='.$userid ?>',
					method:'GET',	
					dataType: 'text',  // what to expect back from the PHP script, if anything
	                cache: false,
	                contentType: false,		                		
				   	data: 
				   	{
				      	idx:idx
				   	}, 
				   	success: function(data) {
				   		
				      	$('#img-list').append(data);

				      	SqueezeBox.assign($$('a.jmodal'), {
							parse: 'rel'
						});	
				      
				      	var all_img = $('#img-list img');

				      	var	len_img = all_img.length;
				  
				      	var	img_max = $(all_img[0]).attr('max-length');	
				      				      
				      	if(len_img >= img_max)
				      	{
				      		$('#loadmore').remove();
				      	}
			      	}
		});
				return false;	
	});
});