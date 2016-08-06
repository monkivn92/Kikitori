<?php
jimport( 'joomla.application.component.model' );

class BenhanModelUser extends JModel
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
    function getUserInfo()
    {
        
        $this_user = $this->getUserID();   
        
        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;
        $cbUser =& CBuser::getInstance( $this_user );
        return $cbUser;
    }
    function getFormData()
    {
        $user_info = new \stdClass();
        $db = JFactory::getDbo();
        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $fields = $db->loadResultArray();

        foreach ($fields as $value)
        {
            $user_info->$value = JRequest::getVar($value);
        }

        return $user_info;

    }

    function getCBfield()
    {
        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;   
        $db = JFactory::getDbo();         
        $cbUser =& CBuser::getInstance( null );
        $CBfields = array();    
        $return = new \stdClass(); 
        $this_user = $cbUser->_cbuser->id;

        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadResultArray();  

        foreach ($names as $name) 
        {
            $CBfields[$name] = $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
        }      
        
        return $CBfields;

    }
    function getCBfieldEdit()
    {
        global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;   
        $db = JFactory::getDbo();         
       
        $CBfields = array();    
        $return = new \stdClass();        

        $cbUser = $this->getUserInfo();
        $this_user = $cbUser->_cbuser->id;

        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadResultArray();  

        foreach ($names as $name) 
        {
            if($name === 'password')
            {
                $CBfields[$name] = $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
                $CBfields[$name] = str_replace('required', '', $CBfields[$name]);
            }
            else
            {
                $CBfields[$name] = $cbUser->getField( $name, null, 'htmledit', 'div','register', 0, true);
            }
            
        }      
        
        return $CBfields;

    }

    function saveuser()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $name = '';
        $username = '';
        $email = '';
        $password = '';
        $registerDate = '';
        $params = '""';
        $uid = null;

        $user_info = $this->getFormData();

        $name = $db->quote($user_info->name);
       
        $email = $db->quote($user_info->email);
      
        $registerDate = $db->quote(date( 'Y-m-d H:i:s'));
        $params = '""';
        $uid = null;

        $sql = 'INSERT INTO #__users (name, email, block, sendEmail,registerDate,params)'
                .' VALUES ('
                            .$name.','                           
                            .$email.','                           
                            .'0,'
                            .'0,'
                            .$registerDate.','
                            .$params.
                          ')';
        
        $db->setQuery($sql);
        $r_u =  $db->execute();     
        $uid = $db->insertid();
        $r_group = false;
        $r_com = false;
        if($r_u)
        {

            // add new user to group user
            $sql = 'INSERT INTO #__user_usergroup_map(user_id, group_id)'
                    .' VALUES ("'.$uid.'","2")';       
            $db->setQuery($sql);
            $r_group = $db->execute(); 


            // add new user to comprofiler
            $id = $uid;
            $user_id = $uid;
            $values = array();
            $fields = array();
               
            include_once( JPATH_ADMINISTRATOR . '/components/com_comprofiler/comprofiler.class.php' );              
            $registeripaddr = $db->quote(cbGetIPlist()); 
            //$degrees = implode('|*|', $user_info->cb_degrees);

            foreach ($user_info as $key => $value) 
            {
                if($key !== 'email'&& $key !== 'name')
                {
                    $fields[] = $key;
                    $values[] = $db->quote($value);
                }
                
            }
            $fields[] = 'id';
            $fields[] = 'user_id';
            $fields[] = 'registeripaddr';
            $values[] = $id;
            $values[] = $user_id;
            $values[] = $db->quote($registeripaddr);
            $f = implode(',', $fields);
            $v = implode(',', $values);


            $sql = "INSERT INTO #__comprofiler($f) VALUES($v)";   
            $db->setQuery($sql);
            $r_com = $db->execute();
        }
        if($r_com&&$r_group&&$r_u)
        {
            $msg = 'Add a new patient successfully. You can add medical report for this patient.';
            $app->enqueueMessage($msg,'Message');
            $app->redirect("/component/benhan/?view=ba&userid=$uid", false);
        }
        else
        {
            $msg = 'Add patient failed. Something wrong have occured.';
            $view = &$this->getView('user','html');
            $model = & $this->getModel('user');       
            $view->setModel($model, true);
            $view->showForm($msg);
            $model->setValueToField(); 
        }
    }
    function updateuser()
    {
        $db = JFactory::getDbo();
        $set = array();         
        $app = JFactory::getApplication();      
        if(JRequest::getVar('name') != '') 
        { 
            
            $set[] =  'name='.$db->quote(JRequest::getVar('name'));

        }

        if(JRequest::getVar('email') != '') 
        { 
            
            $set[] =  'email='.$db->quote(JRequest::getVar('email'));
        }
        
        $s = implode(',', $set);        
      
        $cbUser = $this->getUserInfo();
        $this_user = $cbUser->_cbuser->id;

        $sql = "UPDATE #__users SET $s WHERE id = $this_user ";   
            
        $db->setQuery($sql);
        $r_u =  $db->execute();          
       
        $r_com = false;

        if($r_u)
        {

            // update user to comprofiler

            $sql = 'SELECT name FROM #__comprofiler_fields
                    WHERE published=1 AND registration=1 ORDER BY ordering';
            $db->setQuery($sql);
            $names = $db->loadResultArray();  
            $set = '';
            foreach ($names as $n) 
            {
                if($n !== 'email'&& $n !== 'name')
                {
                    $val = JRequest::getVar($n);
                
                    if( trim($val) != '' && strpos($n, 'cb_') !== false )
                    {
                        $set[] = $n.'='.$db->quote($val);
                    }
                }
                
            }
             
            $set = implode(',', $set) ;            
            //$degrees = implode('|*|', $user_info->cb_degrees);
            $sql = "UPDATE #__comprofiler SET $set WHERE user_id = $this_user";   

            $db->setQuery($sql);
            $r_com = $db->execute();
        }
        if($r_com&&$r_u)
        {
           
            $msg = 'Update  patient successfully.';
            $app->enqueueMessage($msg,'Message');
            $app->redirect('/component/benhan/?view=user&task=edituser&userid='.$this_user, false);
        }
        else
        {
            $msg = 'Update patient failed. Something wrong have occured.';
            $app->enqueueMessage($msg,'error');
            $app->redirect('/component/benhan/?view=user&task=edituser&userid='.$this_user, false);
        }
    }

    function setValueToField()
    {
        $doc = JFactory::getDocument();     
        $db = JFactory::getDbo();

        $sql = 'SELECT name FROM #__comprofiler_fields
                WHERE published=1 AND registration=1 ORDER BY ordering';
        $db->setQuery($sql);
        $names = $db->loadResultArray();  

        $user_info = new \stdClass();
        $script = '<script>';
        foreach ($names as $n) 
        {
            $val = $db->quote(JRequest::getVar($n));
            $script .= " jQuery('input[name = \"$n\"]').val($val); ";            
        }  

        $script .= '</script>';  

        echo $script;
    }
    function searchUser()
    {
        $db = JFactory::getDbo();
        $name = JRequest::getVar('name');
        $mrid = JRequest::getVar('mrid');
        $ktphth = JRequest::getVar('ktphth');
        $fs = ['name'=>$name,'cb_so_benh_an_vao_vien'=>$mrid, 'cb_iv_ppdtr_kt_phau_thuat'=>$ktphth];
        $where='';

        if(trim($name)=='' && trim($mrid)=='' && trim($ktphth)=='' )
        {
            $where =' 1=1 ';
        }
        else
        {
            $logic = '';
            $cnt = count($fs);
            $key = array_keys($fs);
            for($i=0; $i<$cnt; $i++)
            {
                $k = $key[$i];
                $v = $fs[$k];

                if( trim($v) !== '' )
                {
                    $where .= ( $logic . " $k LIKE '%$v%' ");
                    $logic = ' AND ';
                }
                
            }            
            
        }

        $sql = "SELECT u.id,u.name, c.cb_so_benh_an_vao_vien, c.cb_ma_luu_tru,
                        c.cb_ngay_thang_nam_sinh, c.cb_ii_ngay_vao_vien
                FROM #__users AS u, #__comprofiler AS c 
                WHERE u.id=c.user_id AND $where";
        //die($sql);
        $db->setQuery($sql);
        $names = $db->loadObjectList(); 
        if(!$names) { return '<p><b>No results found.</b></p>';}
        $return='';
         $return .= '<table id="results_list"> ';        
            $return .= '<thead> ';
                $return .= '<tr> ';

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Tên</strong>'  ;  
                    $return .= '</td> ';    

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Năm Sinh</strong>';    
                    $return .= '</td> '; 

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Ngày Vào Viện</strong>'  ;  
                    $return .= '</td> ';   

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Số bệnh án</strong>' ;   
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Mã Lưu Trữ</strong>';    
                    $return .= '</td> ';

                $return .= '</tr> ';
            $return .= '<tbody> ';        

        foreach ($names as $n) 
        {
                $link = '/component/benhan/?view=user&task=showprofile&userid='.$n->id;
                $return .= '<tr>';

                    $return .= '<td align="center"> ';
                        $return .=  "<a href='$link' target='_blank'>" . $n->name . '</a>'; 
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $dt_obj = new DateTime($n->cb_ngay_thang_nam_sinh);
                        $return .= $dt_obj->format('d-m-Y');    
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $dt_obj = new DateTime($n->cb_ii_ngay_vao_vien);
                        $return .= $dt_obj->format('d-m-Y');    
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $return .= $n->cb_so_benh_an_vao_vien;    
                    $return .= '</td> ';

                   $return .= '<td align="center"> ';
                        $return .= $n->cb_ma_luu_tru;    
                    $return .= '</td> ';

                $return .= '</tr>';
        }  
            $return .= '</tbody> ';
        $return .= '</table> ';

        return $return; 
    }
    function getUserRecentlyAdd()
    {
        $db = JFactory::getDbo();
        $sql = "SELECT u.id,u.name, c.cb_so_benh_an_vao_vien, c.cb_ma_luu_tru,
                        c.cb_ngay_thang_nam_sinh, c.cb_ii_ngay_vao_vien
                FROM #__users AS u, #__comprofiler AS c 
                WHERE u.id=c.user_id ORDER BY registerDate DESC LIMIT 5";
        //die($sql);
        $db->setQuery($sql);
        $names = $db->loadObjectList(); 
        if(!$names) { return '<p><b>No results found.</b></p>';}
        $return = '';
        $return .= '<table id="results_list"> ';        
            $return .= '<thead> ';
                $return .= '<tr> ';

                    $return .= '<td align="center"> ';
                        $return .= "<strong>Tên</strong>"  ;  
                    $return .= '</td> ';    

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Năm Sinh</strong>';    
                    $return .= '</td> '; 

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Ngày Vào Viện</strong>'  ;  
                    $return .= '</td> ';   

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Số bệnh án</strong>' ;   
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $return .= '<strong>Mã Lưu Trữ</strong>';    
                    $return .= '</td> ';

                $return .= '</tr> ';
            $return .= '<tbody> ';        

        foreach ($names as $n) 
        {
                $link = '/component/benhan/?view=user&task=showprofile&userid='.$n->id;
                $return .= '<tr>';

                    $return .= '<td align="center"> ';
                        $return .= "<a href='$link' target='_blank'>" . $n->name . '</a>';    
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $dt_obj = new DateTime($n->cb_ngay_thang_nam_sinh);
                        $return .= $dt_obj->format('d-m-Y');    
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $dt_obj = new DateTime($n->cb_ii_ngay_vao_vien);
                        $return .= $dt_obj->format('d-m-Y');    
                    $return .= '</td> ';

                    $return .= '<td align="center"> ';
                        $return .= $n->cb_so_benh_an_vao_vien;    
                    $return .= '</td> ';

                   $return .= '<td align="center"> ';
                        $return .= $n->cb_ma_luu_tru;    
                    $return .= '</td> ';

                $return .= '</tr>';
        }  
            $return .= '</tbody> ';
        $return .= '</table> ';
        return $return; 
    }

    function saveAvatar()
    {
        $app = JFactory::getApplication();
        $uid = $this->getUserID();

        if( !is_dir("patient/$uid") )
        {
            mkdir("patient/$uid");
        }
        if( !is_dir("patient/$uid/resized") )
        {
            mkdir("patient/$uid/resized");
        }
        
        $path_parts = pathinfo($_FILES["file"]["name"]);
        $extension = $path_parts['extension'];
        $filepath = "patient/$uid/avatar.".$extension;
        $filepath_resized = "patient/$uid/resized/avatar.".$extension;

        //Delete old avatars
        $oldAvatar = scandir("patient/$uid");
        foreach ($oldAvatar as  $avatar) 
        {
            if( strpos($avatar, 'avatar.') !== false ) 
            {
                unlink("patient/$uid/$avatar");
                unlink("patient/$uid/resized/$avatar");
            }
        }
        
        if( 0 < $_FILES['file']['error'] ) 
        {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        }
        else 
        {
            move_uploaded_file($_FILES['file']['tmp_name'], $filepath);
            $this->imgEditorResizeImg($filepath, $filepath_resized, 0.1);
        }

        $img = "<img src='/$filepath_resized' class='pro5-avatar' style='height:100px'/>";
        echo $img;
        $app->close();
    }
    function rotateAvatar()
    {
        $app = JFactory::getApplication();
        $uid = $this->getUserID();
        $degrees = JRequest::getInt('deg');
        $img_path = '';
        $invert = 0;
        switch (true) 
        {
            case (is_file("patient/$uid/resized/avatar.png")):
                $img_path = "patient/$uid/resized/avatar.png";
                break;
            case (is_file("patient/$uid/resized/avatar.PNG")):
                $img_path = "patient/$uid/resized/avatar.PNG";
                break;
            case (is_file("patient/$uid/resized/avatar.jpg")):
                $img_path = "patient/$uid/resized/avatar.jpg";
                break;
            case (is_file("patient/$uid/resized/avatar.JPG")):
                $img_path = "patient/$uid/resized/avatar.JPG";
                break;           
           
        }
        
        if($degrees == 270)
        {
            $invert = 0;
        }
        $this->imgEditorRotateImg($img_path,-$degrees,$invert);
        
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

    /**
    * @percentage : From 0.0 To 1.0
    */
    function imgEditorResizeImg($img_path, $save_path, $percentage)
    {
        // Get new sizes
        list($width, $height) = getimagesize($img_path);
        $newwidth = $width * $percentage;
        $newheight = $height * $percentage;

        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);

        $ext = strrchr($img_path, '.');
        if($ext === '.jpg' || $ext === '.JPG')
        {
            $source = imagecreatefromjpeg($img_path);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagejpeg($thumb,$save_path);
        }
        elseif ($ext === '.png' || $ext === '.PNG') 
        {
            $source = imagecreatefrompng($img_path);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagepng($thumb,$save_path);
        }   

        imagedestroy($thumb);
    }

    function saveAttachment()
    {
        $app = JFactory::getApplication();
        $uid = $this->getUserID();

        if( !is_dir("patient/$uid") )
        {
            mkdir("patient/$uid");
        }
        if( !is_dir("patient/$uid/resized") )
        {
            mkdir("patient/$uid/resized");
        } 

        $cnt = 0;
        $cnt = count($_FILES["attach"]["name"]);
        

        if($cnt == 0)
        {
            die('No files chosen');
        }

        for($i=0; $i<$cnt; $i++)
        {
            $file_path = $_FILES["attach"]["name"]["$i"];
            $path_parts = pathinfo($file_path);            
            $file_name = str_replace(' ', '-', $path_parts['basename']);
            $extension = $path_parts['extension'];
            $time = time();
            $filepath = "patient/$uid/$time".'_'.$file_name;
            $save_path = "patient/$uid/resized/$time".'_'.$file_name;

            $isImg = true;
            if($extension !== 'jpg' && $extension !== 'JPG' &&$extension !== 'png' &&$extension !== 'PNG')
            {
                $isImg = false;
            }
            
            if( 0 < $_FILES['attach']['error']["$i"] ) 
            {
                die('Error: ' . $_FILES['attach']['error']["$i"] . '<br>');
            }
            else 
            {
                move_uploaded_file($_FILES['attach']['tmp_name']["$i"], $filepath);
                if($isImg)
                {
                    $this->imgEditorResizeImg($filepath, $save_path, 0.1); 
                }
                            
            }  
        }
        $items = $this->getAttachment();
        echo $items;     
        
        $app->close();
    }
    function getAttachment()
    {
        $uid = $this->getUserID();
        $attach = '';
        if ( $dir = opendir("patient/$uid") ) 
        {

            while (false !== ( $item = readdir($dir) ) ) 
            {
                if($item !== '.' && $item !== '..' && is_file("patient/$uid/$item"))
                {                                       
                    $attach .= "<p><a href='/patient/$uid/$item' download>$item</a></p>";                  
                    
                }
                
            }

            closedir($handle);
        }
        if(trim($attach)=='')
        {
            return 'Have no items';
        }
        else
        {
            return $attach;
        }
        
    }

    function getImgGallery()
    {
        $session = JFactory::getSession();
        $session->clear('img_ga_data');
        $uid = $this->getUserID();
        $offset = 5;
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

        if(count($ss_arr)<= 0)
        {
            return 'Have no images';
        }
        else
        {
            $session->set('img_ga_data',$ss_arr);
            $maxlen = count($ss_arr);
            $last_idx = $offset > $maxlen ? $maxlen : $offset;
            for($i=0; $i<$last_idx; $i++)
            {
                $img_name = $ss_arr[$i];    
                $exif = exif_read_data("patient/$uid/$img_name");
                $taken_date = $exif['DateTimeOriginal'];
                $imgh = $exif['COMPUTED']['Height'];
                $imgw = $exif['COMPUTED']['Width'];                   
                               
                $taken_date = $exif['DateTimeOriginal'];

                $attach .= '<div class="img-ga-contaner">';
                $attach .= "<a class='jmodal' rel=\"{size:{x:400,y:400}}\" href='/patient/$uid/$img_name' >";
                
                
                $attach .= "<img img-idx='$i' max-length='$maxlen' src='/patient/$uid/resized/$img_name' style='height:150px; width:150px' class='img-item'>";
                

                $attach .= "</a>";
                $attach .= "<p><strong>$img_name</strong></p>";
                $attach .= "<p>Date Taken: $taken_date </p>";
                $attach .= '</div>';
            }

        }
        return $attach;
    }

    function getImgAjax()
    {
        $session = JFactory::getSession();
        $uid = $this->getUserID();
        $offset = 5;
        $images = $session->get('img_ga_data');
        $idx = JRequest::getInt('idx');
        if( !$idx )
        {
            return;
        }
        
        $img_ss_len = count($images);   
        $attach = '';

        if($idx < $img_ss_len-1)
        {
            $last_idx = ($img_ss_len - 1) > ($idx + $offset) ? ($idx + $offset) : ($img_ss_len - 1);
            $return = '';
            for($i = $idx+1; $i <= $last_idx; $i++)
            {
                $img_name = $images[$i];    
                $exif = exif_read_data("patient/$uid/$img_name");
                $taken_date = $exif['DateTimeOriginal'];
                $imgh = $exif['COMPUTED']['Height'];
                $imgw = $exif['COMPUTED']['Width'];                   
                               
                $taken_date = $exif['DateTimeOriginal'];

                $attach .= '<div class="img-ga-contaner">';
                $attach .= "<a class='jmodal' rel=\"{size:{x:400,y:400}}\" href='/patient/$uid/$img_name' >";
                
                if($imgh >= $imgw)
                {
                    $attach .= "<img img-idx='$i' max-length='$img_ss_len' src='/patient/$uid/resized/$img_name' height='200' class='img-item'>";
                }
                else
                {
                    $attach .= "<img img-idx='$i' max-length='$img_ss_len' src='/patient/$uid/resized/$img_name' width='200' class='img-item'>";
                }

                $attach .= "</a>";
                $attach .= "<p><strong>$img_name</strong></p>";
                $attach .= "<p>Date Taken: $taken_date </p>";
                $attach .= '</div>';
                
            }
            echo $attach;
        }
        else
        {
            return;
        }

    }

}//end class

?>