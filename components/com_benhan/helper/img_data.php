<?php
?>
<blockquote id="img-gallery" class="rounded" align="center">
	<h3><img src="/components/com_photoeditor/img/photo.jpg" width="30px" alt=""> Image Data</h3>
	<p>
		<a href="<?php echo '/component/photoeditor/?view=edit&userid='.$userid ?>">
			<i class="fa fa-wrench" aria-hidden="true"></i>
			Photo Editor
		</a>
	</p>
	<div id="img-list">
		<?php
			echo $imgGallery;
		?>
	</div>
	<div class="clearfix"></div>
	<p><a href="" id="loadmore" style="font-weight:bold">More...</a></p>
</blockquote>
<script>

	$(document).ready(function(){
		
		var images = $('#img-list img');
		if(images.length <= 0)
		{
			$('#loadmore').remove();
		}
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
			e.preventDefault();
		});
	});
</script>