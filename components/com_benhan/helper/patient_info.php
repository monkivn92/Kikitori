<?php
   
$uid = $userid;

switch (true) 
{
    case (is_file("patient/$uid/resized/avatar.png")):
        $avatar = "patient/$uid/resized/avatar.png";
        break;
    case (is_file("patient/$uid/resized/avatar.PNG")):
        $avatar = "patient/$uid/resized/avatar.PNG";
        break;
    case (is_file("patient/$uid/resized/avatar.jpg")):
        $avatar = "patient/$uid/resized/avatar.jpg";
        break;
    case (is_file("patient/$uid/resized/avatar.JPG")):
        $avatar =  "patient/$uid/resized/avatar.JPG";
        break;
    
    default:
        $avatar = 'components/com_benhan/img/no_avatar.png';
        break;
}
        
    

?>

<blockquote class="rounded" align="center">
	<h2 style="color:#1ba1e2;font-weight:bolder"><?php echo $user_name ?></h2>
	<div id="profile-avatar" style="margin-bottom:2px">
		<?php
		if($avatar)
		{
			echo "<img style='height:100px' class='pro5-avatar' src='/".$avatar."'  />";
		}
			
		?>
		
	</div>
	<p id="change_avatar" style="font-size:12px;">

		<a  style="color:blue !important; " href=""><i class="fa fa-wrench" aria-hidden="true"></i></i> Change/Edit Avatar</a>
	</p>	
    <div id="avatar_upload_area" class="default_hide" >
        <input hidden="true" id="avatar_input" type="file" name="avatar" />
        <span id="add_avatar" class="btn btn-danger">            
            <i class="fa fa-plus" aria-hidden="true"></i>
            Choose image
        </span>
        <span id="upload_avatar" class="btn btn-primary">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            Upload
        </span>
        <div id='avatar_fileName'>
                
        </div>
        <div id="progress-bar" class="default_hide">
            
            <div id="progress-bar-inner">
                
            </div>
        </div>
        <div id="avatar_tool_box" >
            <span id="r90deg" class="btn btn-default">
                <i class="fa fa-repeat" aria-hidden="true"></i>
                90deg
            </span> 
            <span id="r180deg" class="btn btn-default">
                <i class="fa fa-repeat" aria-hidden="true"></i>
                180deg
            </span>
            <span id="r270deg" class="btn btn-default">
                <i class="fa fa-undo" aria-hidden="true"></i>
                90deg
            </span>
            <span id="avatar_edit_reset" class="btn btn-default">                
                Reset
            </span>
            <span id="avatar_edit_done" class="btn btn-warning">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                Save
            </span>

        </div>
        <div id="avatar-edit-zone">
            <?php
                echo "<img style='height:100px' class='pro5-avatar' src='/".$avatar."'  />";
            ?>
            
        </div>
    </div>

	<p>
		<?php
			$link = "/component/benhan/?view=user&task=edituser&userid=".$userid;
			echo "<a  class='btn btn-success' target='_blank' style='margin:10px' href='$link'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit Profile</a>";
		?>
		
	</p>

	<p>
		<?php
			$link = "/component/benhan/?view=ba&userid=".$userid;
			echo "<a class='btn btn-warning' target='_blank' style='margin:10px' href='$link'><i class='fa fa-medkit' aria-hidden='true'></i> Medical Report</a>";
		?>
		
	</p>
</blockquote>

<script>

    $(document).ready(function(){

        $('#change_avatar').click(function(){

            $('#avatar_upload_area').slideToggle();
            return false;

        });

        $('#add_avatar').click(function(){

            $('#avatar_input').click();
        });

        $('#upload_avatar').click(function(){

            var file_data = $("#avatar_input").prop("files")[0];  
            $('#progress-bar').show();
            var form_data = new FormData();                  
            form_data.append('file', file_data);
                                       
            $.ajax({
                        url: '<?php echo 'index.php?option=com_benhan&view=user&task=saveavatar&userid='.$userid ?>', // point to server-side PHP script 
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
                                myXhr.upload.addEventListener('progress',avatarProgress, false);
                            }
                            return myXhr;
                        },
                        success: function(res)
                        {
                            $('#avatar-edit-zone').empty(); 
                            $('#avatar_tool_box').show(); 

                            $('#avatar-edit-zone').append(res);
                        }
            });
       
        });

        $("#avatar_input").change(function(){

            var fileName = $(this).prop("files")[0];
            
            $("#avatar_fileName").empty();
            $("#avatar_fileName").append(fileName.name);

        });

        function avatarProgress(e)
        {

            if(e.lengthComputable){
                var max = e.total;
                var current = e.loaded;

                var Percentage = (current * 100)/max;

                $('#progress-bar-inner').css('width',Percentage);                

                if(Percentage >= 100)
                {
                   $('#progress-bar').hide();
                   $("#avatar_fileName").empty();
                }
            }  
        }

        //////Rotate IMG

        $("#avatar_edit_reset").click(function(){
            $("#avatar-edit-zone img").removeClass();    
            return false;        

        });

        $("#r90deg").click(function(){
            $("#avatar-edit-zone img").removeClass();
            $("#avatar-edit-zone img").addClass('rotatel90');            
            return false;
        });

        $("#r180deg").click(function(){
            $("#avatar-edit-zone img").removeClass();
            $("#avatar-edit-zone img").addClass('rotatel180');
            return false;
        });

        $("#r270deg").click(function(){
            $("#avatar-edit-zone img").removeClass();
            $("#avatar-edit-zone img").addClass('rotatel270');
            return false;
        });

        $("#avatar_edit_done").click(function(){
            
            var clss = $("#avatar-edit-zone img").attr('class');
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
                url: '<?php echo 'index.php?option=com_benhan&view=user&task=rotateavatar&userid='.$userid ?>',

                data:{deg:deg},                
                
                success:function(data){

                    window.location.reload();
                }

            });
            return false;

        });


        
    });//document ready
</script>
