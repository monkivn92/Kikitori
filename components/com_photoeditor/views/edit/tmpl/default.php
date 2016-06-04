<?php
defined('_JEXEC') or die('Restricted access'); 
$doc = JFactory::getDocument();
$doc->addStyleSheet('/components/com_photoeditor/asset/style.css');

$uid = $this->uid;
$userid = $this->uid;

?>
<script type="text/javascript" src="/components/com_photoeditor/asset/base64.js"></script>
<h2 id="photo-tool-title">
	<img src="/components/com_photoeditor/img/image-editing.png" width="50px" alt="">
	&nbsp;
	<span>
		Photo Toolbox
	</span>
</h2>
<span id="add-image" class="btn btn-primary">
        <i class="fa fa-search" aria-hidden="true"></i>
        Choose image
</span> 


<div id="photo-list" class="default-hide">
	<p><img src="/components/com_photoeditor/img/loading.gif" alt=""></p>		
</div>

<div id="photo-toolbox">
	
    <span id="img-full-size" class="btn btn-default default-hide show-latter">
        <i class="fa fa-search-plus" aria-hidden="true"></i>
        <span>View full size</span>
    </span>
    <span id="r90deg" class="btn btn-default default-hide show-latter">
        <i class="fa fa-repeat" aria-hidden="true"></i>
        90deg
    </span> 
    <span id="r180deg" class="btn btn-default default-hide show-latter">
        <i class="fa fa-repeat" aria-hidden="true"></i>
        180deg
    </span>
    <span id="r270deg" class="btn btn-default default-hide show-latter">
        <i class="fa fa-undo" aria-hidden="true"></i>
        90deg
    </span>
    <span id="photo_edit_reset" class="btn btn-warning default-hide show-latter">                
        Reset
    </span>
    <a id="photo_edit_save" class="btn btn-danger default-hide show-latter" href="<?php echo JRoute::_("component/benhan/?view=user&task=showprofile&userid=$uid");?>">
        <i class="fa fa-floppy-o" aria-hidden="true"></i>
        Save
    </a>
    <a id="photo_edit_save_set" class="btn btn-primary default-hide show-latter" href="<?php echo JRoute::_("component/benhan/?view=user&task=showprofile&userid=$uid");?>">
        <i class="fa fa-floppy-o" aria-hidden="true"></i>
        Save and Set as avatar
    </a>
    <p style="font-size:12px; color:red">
        <i>  
            *Note: Use 'Save and Set as avatar' function will cause deleting the old avatar. Be careful!      
        </i>
    </p>
</div>

<div id="photo-container" class="default-hide">
			
</div>

<script>

	jQuery(document).ready(function($){		
		
		$('#add-image').click(function(e){	

			$('#photo-list').removeClass('default-hide');
			var img = $('#photo-list > img');
			if(img.length > 0)
			{
				return;
			}

			$.ajax({
						url: '<?php echo 'index.php?option=com_photoeditor&view=edit&task=getlist&userid='.$userid ?>',
						method:'GET',	
						dataType: 'text',  // what to expect back from the PHP script, if anything
		                cache: false,
		                contentType: false,	       		
					   	 
					   	success: function(data) {
					   		$('#photo-list').empty();
					      	$('#photo-list').html(data);
					      	getChosenPhoto();
				      	}
					});
			return false;			
		});

		function getChosenPhoto()
		{
			$('#photo-list img').click(function(e){	

				$(this).parent().addClass('default-hide');

				$('.show-latter').removeClass('default-hide');

				$('#photo-container').removeClass('default-hide').empty().html($(this).clone());	

				$('#photo-container img').css({'width':'auto','height':'auto'});		

			});
		}

		$("#photo_edit_reset").click(function(){
            $("#photo-container img").removeClass();    
            return false;        

        });

        $("#r90deg").click(function(){
            $("#photo-container img").removeClass();
            $("#photo-container img").addClass('rotatel90');            
            return false;
        });

        $("#r180deg").click(function(){
            $("#photo-container img").removeClass();
            $("#photo-container img").addClass('rotatel180');
            return false;
        });

        $("#r270deg").click(function(){
            $("#photo-container img").removeClass();
            $("#photo-container img").addClass('rotatel270');
            return false;
        });

        $("#img-full-size").click(function(){
        	  
        	var uid =  "<?php echo $uid ?>";   
        	var img = $("#photo-container img").attr('alt');	
        	

        	if( $("#img-full-size i").hasClass('fa-search-plus') )
        	{
        		$("#img-full-size i").removeClass().addClass('fa fa-search-minus');
            	$("#img-full-size span").empty().html('View small size');

            	var elm = '<img src="'+'/patient/'+uid+'/'+img+'" alt="'+img+'" >'; 

            	$("#photo-container").empty().html(elm);
        	}
        	else
        	{
        		$("#img-full-size i").removeClass().addClass('fa fa-search-plus');
            	$("#img-full-size span").empty().html('View full size');	

            	var elm = '<img src="'+'/patient/'+uid+'/resized/'+img+'" alt="'+img+'" >'; 

            	$("#photo-container").empty().html(elm);
        	}
            
        });

        $("#photo_edit_save").click(function(){
            
            var clss = $("#photo-container img").attr('class');
            var image_name = $("#photo-container img").attr('alt');
            var img_name_enc = Base64.encode(image_name);
            var deg = 0;

            switch (clss.trim()) 
            {
                case '':
                    deg = 0;
                    break;
                case 'rotatel90':
                    deg = 90;
                    break;
                case 'rotatel180':
                    deg = 180;
                    break;
                case 'rotatel270':
                    deg = 270;
                    break;
                default:
                    // statements_def
                    break;
            }

            $.ajax({
                type:'POST',
                url: '<?php echo 'index.php?option=com_photoeditor&view=edit&task=saveedited&userid='.$userid ?>',
                cache: false,
                data:{

                    deg:deg,
                    img:img_name_enc
                },                
                
                success:function(data){
                    
                    return true;
                }

            });
            

        });

        $("#photo_edit_save_set").click(function(){
            
            var clss = $("#photo-container img").attr('class');
            var image_name = $("#photo-container img").attr('alt');
            var img_name_enc = Base64.encode(image_name);
            var deg = 0;

            switch (clss.trim()) 
            {
                case '':
                    deg = 0;
                    break;
                case 'rotatel90':
                    deg = 90;
                    break;
                case 'rotatel180':
                    deg = 180;
                    break;
                case 'rotatel270':
                    deg = 270;
                    break;
                default:
                    // statements_def
                    break;
            }

            $.ajax({
                type:'POST',
                url: '<?php echo 'index.php?option=com_photoeditor&view=edit&task=saveeditedavatar&userid='.$userid ?>',
                cache: false,
                data:{

                    deg:deg,
                    img:img_name_enc
                },                
                
                success:function(data){
                    
                    return true;
                }

            });
            return true;

        });

		
	});
</script>




