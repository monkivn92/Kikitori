<html>
<head>
	<meta charset="utf-8">

	<script src="JQLib.js"></script>

</head>

<body>

	<div id="img-container">
		<?php
			session_start();
			$offset = 3;
			$img_ss = array();
			if ( $handle = opendir('images/comprofiler/gallery') ) 
			{

			    while ( false !== ( $entry = readdir($handle) ) ) 
			    {

			        if ($entry != "." && $entry != ".." && is_file("images/comprofiler/gallery/$entry")) 
			        {
			            
			            $img_ss[] = $entry;
			        }
			    }

			    closedir($handle);
			}

			if(count($img_ss) <= 0)
			{
				return;
			}
			else
			{
				$_SESSION['img'] = $img_ss;
				$img_max = count($img_ss);
				$return = '';
				$last_idx = $img_max > $offset ? $offset : $img_max;

				for( $i=0; $i<$last_idx; $i++)
				{
					$item = $img_ss[$i];
					$return .= "<img src='images/comprofiler/gallery/$item' width='48' img-idx='$i' max-length='$img_max'>";
				}		
				echo $return;
				
			}

		?>
	</div>

	<?php
		if($img_max > $offset)
		{
			echo '<a href="" id="loadmore">More...</a>';
		}
	?>

	<div id="lb-overlay">
		<div id="lb-content">
			
		</div>
	</div>

</body>	

<style>
	#lb-overlay{
		width: 100%;
		height: 100%;
		position: absolute;
		left: 0px;
		top:0px;
		background-color: rgba(0,0,0,0.5);
		z-index: 10;
		display: none;
	}
	#lb-content{
		width:20%;
		width:20%;	
		position: absolute;
		background-color: #fff;
		border: 3px solid red;
		border-radius: 3px;
		z-index: 11;
		display: none;
		padding:5px;
	}
	#lb-content img{
		max-height:100%; 
		max-width:100%;
	}	

</style>
<script>

	$(document).ready(function(){
		lightBox();
		$('#loadmore').click(function(e){			
			var idx = $('img').last().attr('img-idx');

			$.ajax({
						url: "/loadmore.php",
						method:'GET',
					   	data: 
					   	{
					      	task:'more',
					      	idx:idx
					   	}, 
					   	success: function(data) {

					      	$('#img-container').append(data);	
					      	lightBox();
					      	var all_img = $('img');

					      	var	len_img = all_img.length;
					  
					      	var	img_max = $(all_img[0]).attr('max-length');					      
					      	if(len_img >= img_max)
					      	{
					      		$('#loadmore').remove();
					      	}
				      	}
			});
			e.preventDefault();
		});

		$('#lb-overlay').click(function(){
			$(this).hide();
		});

		$('#lb-content').click(function(e){
			e.stopPropagation();
		});

		function lightBox()
		{	

			$('img').click(function(){

				$('#lb-overlay').show();
				$('#lb-content').show();
				var lbcontent = $('#lb-content'),
					dh = $(document).height(),
					dw = $(document).width(),
					lbh = dh*0.8,
					lbw = dw*0.8;			
			
				var temp_img = document.createElement('img');
				temp_img.src = $(this).attr('src');
				$(temp_img).css({'max-height':lbh-5,'max-width':lbw-5});

				lbcontent.empty().append( temp_img);

				var lb_img = $('#lb-content img'),
					lb_img_w = lb_img.width(),
					lb_img_h = lb_img.height(),
					lbh = lb_img_h,
					lbw = lb_img_w,
					lbleft = (dw - lbw)/2,
					lbtop  = (dh - lbh)/2;
				lbcontent.css({'left':lbleft,'top':lbtop,'width':lbw,'height':lbh});

			});
		}//End lightBox function


	});

	


</script>

</html>