<blockquote id="pro5-attachments" class="rounded"  align="center">
	
		<h3><img src="/components/com_benhan/img/Downloads.ico" width="30px" alt=""> Download/Upload Attachments</h3>
		<p id="attachment_upload_area">
			<span id="add_attach" class="btn btn-danger">            
	            <i class="fa fa-plus" aria-hidden="true"></i>
	            Add file
	        </span>
	        <span id="upload_attach" class="btn btn-primary">
	            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
	            Upload
	        </span>
			<span id="show_attach" class="btn btn-default">
				<i class="fa fa-list" aria-hidden="true"></i>
				Show/Hide Attachments
			</span>
			<input id="attach_input" hidden="true" type="file" name="attach[]" multiple="multiple" />
			
			<p id="attach_filenames">
				
			</p>

			<div id="attach-progress-bar" class="default_hide">
            
	            <div id="attach-progress-bar-inner">
	                
	            </div>
        	</div>

		</p>

		<blockquote id="attachment-items" style="display:none;">
			<?php
				echo $attachments;
			?>
		</blockquote>

</blockquote>

<script>
	$(document).ready(function(){

		$('#show_attach').click(function(){

			$('#attachment-items').slideToggle();
							
		});
		$('#add_attach').click(function(){

			$('#attach_input').click();
							
		});

		$("#attach_input").change(function(){

            var fileName = $(this).prop("files");
            
            var len = fileName.length; 
            var html ='';           
            $("#attach_filenames").empty();
            for(var i=0; i<len; i++)
            {
            	html += '<p>'+fileName[i].name+'</p>';
            }
            $("#attach_filenames").html(html);

        });

        $('#upload_attach').click(function(){

            $('#attach-progress-bar').show();
            var file_data = $("#attach_input").prop("files");
            
            var form_data = new FormData();                  
            $.each(file_data, function(i, file) {
			    form_data.append('attach[]', file);
			});
                                       
            $.ajax({
                        url: '<?php echo 'index.php?option=com_benhan&view=user&task=saveattachment&userid='.$userid ?>', // point to server-side PHP script 
                        dataType: 'text',  // what to expect back from the PHP script, if anything
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
                            window.location.reload();
                        }
            });
       
        });

		function attachProgress(e)
        {

            if(e.lengthComputable){
                var max = e.total;
                var current = e.loaded;

                var Percentage = (current * 100)/max;

                $('#attach-progress-bar-inner').css('width',Percentage);                

                if(Percentage >= 100)
                {
                   $('#attach-progress-bar').hide();
                   $("#attach_filenames").empty();
                }
            }  
        }




	});
</script>