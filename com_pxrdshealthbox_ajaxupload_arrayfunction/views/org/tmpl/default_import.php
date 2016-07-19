<?php
defined('_JEXEC') or die;

?>
<form action="" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
	<div id="upload_container">
	
		<button class="btn btn-primary" id='choose_file'>
			<span class="icon-file-add"></span>
			Choose file
		</button>
		&nbsp;
		<button class="btn btn-success" id='upload_file'>
			<span class="icon-upload"></span>
			Upload
		</button>
	
		<div id="upload_options">
			<input type="checkbox" name='override_duplicate' > Override Duplicate
			
		</div>

		<div id="upload_message">
		
		</div>

		<div id="upload_status">
			<div id="upload_status_inner"></div>
		</div>


	</div>

	<input type="file" id="file_target" name="file_target" hidden="true">
	<input type="hidden" name='task' value=''>
	<?php echo JHtml::_('form.token'); ?>
</form>

<script>
	jQuery(document).ready(function($){
		

		$('#choose_file').click(function(e) {
			
			$('#file_target').click();
			return false;
		}); // end function

		$("#file_target").change(function(){

            var fileName = $(this).prop("files");
            
            var len = fileName.length; 
            var html ='';           
            $("#upload_message").empty();

            for(var i=0; i<len; i++)
            {
            	html += '<p>'+fileName[i].name+'</p>';
            }

            $("#upload_message").html(html);

        });// end function


        $('#upload_file').click(function(){

            $('#upload_status').show();

            var file_data = $("#file_target").prop("files")[0];
            
            var form_options = $("input[name='override_duplicate']").is(':checked');
            
            var form_data = new FormData();

			form_data.append('file_target', file_data );
			form_data.append('form_options', form_options );
			console.log( form_data );
                                       
            $.ajax({
                        url: 'index.php?option=com_pxrdshealthbox&view=org&task=org.saveimport', 
                        dataType: 'text',  
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         
                        type: 'post',
                        xhr: function() {

                            var myXhr = $.ajaxSettings.xhr();
                            if(myXhr.upload)
                            {
                                myXhr.upload.addEventListener('progress',attachProgress, false);
                            }
                            return myXhr;
                        },
                        success: function(res)
                        {
                            $("#upload_message").empty();
                            $("#upload_message").html(res);
                            return false;
                        }
            });
			return false;
       
        });// end function

		function attachProgress(e)
        {

            if(e.lengthComputable)
            {
                var max = e.total;
                var current = e.loaded;

                var Percentage = (current * 100)/max;

                $('#upload_status_inner').css('width',Percentage);   
                console.log(Percentage);             

                if(Percentage >= 100)
                {
                   $('#upload_status').hide();
                   //$("#attach_filenames").empty();
                }
            }  
        }// end function


	});//end document ready
</script>

<style>
	#upload_container{
		margin: 10px;
		padding: 50px;
		text-align: center;
		border: 3px dashed #ccc;
	}
	#upload_options{
		margin: 10px;
		padding: 10px;
		text-align: center;
		font-weight: bold;
	}
	#upload_message{
		margin: 10px;
		padding: 10px;
		text-align: center;
		font-weight: bold;
		color: #409740;
	}
	#upload_status{
		margin: auto;
		padding: 0px;
		width: 500px;
		height: 10px;
		border: 1px solid #ccc;
		border-radius: 3px;
		display: none;
	}
	#upload_status_inner{
		margin: 0px;
		padding: 0px;
		width: 1%;
		height: 90%;
		background-color: #142849;
		border: 1px solid #142849;
		border-radius: 3px;
	}

</style>