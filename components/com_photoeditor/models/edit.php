<?php
jimport( 'joomla.application.component.model' );

class PhotoeditorModelEdit extends JModel
{	
	function __construct()
	{		
		parent::__construct();
	}	

	function isAdmin($userid)
    {
        $db = JFactory::getDbo();     
        $sql = "SELECT group_id FROM #__user_usergroup_map WHERE user_id=$userid";
        $db->setQuery($sql);
        $r = $db->loadResult();
      
        if($r == 7 || $r == 8)
        {
            return true;
        }
            
        else

            return false;

    }
    function getUserID()
    {
        $userid = JRequest::getInt('userid');
        $user = JFactory::getUser();
        $this_user = 0;
        
        if(!$userid) 
        { 
            $this_user = $user->id;
        }
        else
        {
            if($userid == $user->id)
            {
                $this_user = $user->id;

            }
            else
            {
                if(!$this->isAdmin($user->id))
                {
                    die('You are not authorized !');
                }                    
                else
                {
                    $this_user = $userid;
                }
                    
            }
        }
        return $this_user;

    }

    function getPhotoList()
    {
        
        $uid = $this->getUserID();    
        $attach = '';   
        $ss_arr = array();

        if ( $dir = opendir("patient/$uid/resized") ) 
        {

            while (false !== ( $item = readdir($dir) ) ) 
            {
                if($item !== '.' && $item !== '..' && is_file("patient/$uid/resized/$item"))
                {
                    if( strpos($item, '.png')!==false ||
                        strpos($item, '.jpg')!==false ||
                        strpos($item, '.JPG')!==false ||
                        strpos($item, '.PNG')!==false                        
                    )
                    {
                        $ss_arr[] =  $item;                        
                    }

                }
                
            }

            closedir($handle);
        }

        $photo_num = count($ss_arr);
        if($photo_num<= 0)
        {
            return 'Have no images';
        }
        else
        {
                    
            
            for($i=0; $i<$photo_num; $i++)
            {
                $img_name = $ss_arr[$i]; 

                $attach .= "<img src='/patient/$uid/resized/$img_name' alt='$img_name' style='height:80px; width:80px'>";

            }

        }
        return $attach;
    }

    function saveEditedAvatar()
    {
        $app = JFactory::getApplication();
        $uid = $this->getUserID(); 

        $degrees = JRequest::getInt('deg');
        $img_name = JRequest::getVar('img');
        $img_name = base64_decode($img_name);
        $ext = strrchr($img_name, '.');

        if(trim($img_name)==='')
        {
            return;
        }

              
       //Delete old avatars
        if( strpos($img_name, 'avatar.') === false ) //new avatar
        {
            $oldAvatar = scandir("patient/$uid");
            foreach ($oldAvatar as  $avatar) 
            {
                if( strpos($avatar, 'avatar.') !== false ) 
                {
                    unlink("patient/$uid/$avatar");
                    unlink("patient/$uid/resized/$avatar");
                    
                }
            }
        }        

        if( $degrees === 0 )
        {
            return;
        }  

        $new_img_path = "patient/$uid/resized/$img_name";
        $new_img_path_full = "patient/$uid/$img_name";

        $this->imgEditorRotateImg($new_img_path,-$degrees,$invert);

        rename($new_img_path, "patient/$uid/resized/avatar".$ext);
        rename($new_img_path_full, "patient/$uid/avatar".$ext);
        
        $app->close();
    }
    function saveEdited()
    {
        $app = JFactory::getApplication();
        $uid = $this->getUserID();

        $degrees = JRequest::getInt('deg');
        $img_name = JRequest::getVar('img');
        $img_name = base64_decode($img_name);
        $img_path = "patient/$uid/resized/$img_name";
        $invert = 0;

        if( trim($img_name)==='' || $degrees===0)
        {
            return;
        }        
      
        $this->imgEditorRotateImg($img_path,-$degrees,$invert);
        echo $img_path.$degrees.$invert;
        
        $app->close();
    }

    function imgEditorRotateImg($img_path,$degrees,$invert)
    {
        $filename = $img_path;
       
        // Load
        $ext = strrchr($img_path, '.');
        if($ext === '.jpg' || $ext === '.JPG')
        {
            $source = imagecreatefromjpeg($img_path);
            $rotate = imagerotate($source, $degrees, $invert);
            unlink($img_path);
            imagejpeg($rotate,$img_path);
        }
        elseif ($ext === '.png' || $ext === '.PNG') 
        {
            $source = imagecreatefrompng($img_path);
            $rotate = imagerotate($source, $degrees, $invert);
            unlink($img_path);
            imagepng($rotate,$img_path);
        }
        
        // Free the memory
        imagedestroy($source);
        imagedestroy($rotate);
    }
	
}//end class

?>