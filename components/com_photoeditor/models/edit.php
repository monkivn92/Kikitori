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
	
}//end class

?>