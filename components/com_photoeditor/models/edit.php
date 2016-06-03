<?php
jimport( 'joomla.application.component.model' );

class JregistrationModelEdit extends JModel
{	
	function __construct()
	{		
		parent::__construct();
	}	

	function getCBfield($userid)
	{

		global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;	

		$cbUser =& CBuser::getInstance( $userid );
		$CBfields = array();
		//$reason = 'list': show fields that aren't shown in registration page
		// Note: check field whether is pulish or not
		$CBfields['firstname'] = $cbUser->getField( 'firstname', null, 'htmledit', 'div','profile', 0, true);
        $CBfields['firstname'] = preg_replace('#(?<=<label).*(?=label>)#', ' for="firstname" id="cblabfirstname">Firstname:</', $CBfields['firstname']);
		$CBfields['lastname'] = $cbUser->getField( 'lastname', null, 'htmledit', 'div','profile', 0, true);
        $CBfields['lastname'] = preg_replace('#(?<=<label).*(?=label>)#', ' for="lastname" id="cblablastname">Lastname:</', $CBfields['lastname']);
		$CBfields['cb_degrees'] = $cbUser->getField( 'cb_degrees', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_degreesother'] = $cbUser->getField( 'cb_degreesother', null, 'htmledit', 'div','register', 0, true);
		$CBfields['email'] = $cbUser->getField( "email", null, 'htmledit', 'div', 'register',0,true);
		$CBfields['confirmemail'] = $cbUser->getField( "confirmemail", null, 'htmledit', 'div', 'register',0,true);
		$CBfields['cb_address'] = $cbUser->getField( 'cb_address', null, 'htmledit', 'div', 'search',0,true);
		$CBfields['cb_addresstwo'] = $cbUser->getField( 'cb_addresstwo', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_addressthree'] = $cbUser->getField( 'cb_addressthree', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_city'] = $cbUser->getField( 'cb_city', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_state'] = $cbUser->getField( 'cb_state', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_province'] = $cbUser->getField( 'cb_province', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_postalcode'] = $cbUser->getField( 'cb_postalcode', null, 'htmledit', 'div','register', 0, true);		
		$CBfields['cb_country'] = $cbUser->getField( 'cb_country', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_phone'] = $cbUser->getField( 'cb_phone', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_secondphone'] = $cbUser->getField( 'cb_secondphone', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_website'] = $cbUser->getField( 'cb_website', null, 'htmledit', 'div','register', 0, true);
		
		$CBfields['cb_orgname'] = $cbUser->getField( 'cb_orgname', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgtype'] = $cbUser->getField( 'cb_orgtype', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgtypeother'] = $cbUser->getField( 'cb_orgtypeother', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgdepartment'] = $cbUser->getField( 'cb_orgdepartment', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgaffiliation'] = $cbUser->getField( 'cb_orgaffiliation', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgspecialty'] = $cbUser->getField( 'cb_orgspecialty', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgspecialtyother'] = $cbUser->getField( 'cb_orgspecialtyother', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgsecondaryspecialty'] = $cbUser->getField( 'cb_orgsecondaryspecialty', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgsecondaryspecialtyother'] = $cbUser->getField( 'cb_orgsecondaryspecialtyother', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_altemail2'] = $cbUser->getField( 'cb_altemail2', null, 'htmledit', 'div','register', 0, true);

		$CBfields['cb_orgcontactname'] = $cbUser->getField( 'cb_orgcontactname', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgcontacttitle'] = $cbUser->getField( 'cb_orgcontacttitle', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgcontactemail'] = $cbUser->getField( 'cb_orgcontactemail', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgcontactphone'] = $cbUser->getField( 'cb_orgcontactphone', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_orgcontacturl'] = $cbUser->getField( 'cb_orgcontacturl', null, 'htmledit', 'div','register', 0, true);
		
		$CBfields['cb_accesspurposelist'] = $cbUser->getField( 'cb_accesspurposelist', null, 'htmledit', 'div','register', 0, true);
		$CBfields['cb_accesspurpose'] = $cbUser->getField( 'cb_accesspurpose', null, 'htmledit', 'div','register', 0, true);
		
		$CBfields['username'] = $cbUser->getField( 'username', null, 'html', 'div','profile', 0, true);
		//$CBfields['password'] = $cbUser->getField('password', null, 'htmledit', 'div','register', 0, true);		
		//$CBfields['password'] = str_replace('required', '',$CBfields['password'] );
        $CBfields['cb_changepass'] = $cbUser->getField('cb_changepass', null, 'htmledit', 'div','register', 0, true);       

		return $CBfields;

	}
     
    function getRegFormData()
    {
        $user_info = new \stdClass();        
        $jreg_user_info = array();   
        
        $user_info->firstname = JRequest::getCmd('firstname');     
        $user_info->lastname = JRequest::getCmd('lastname');   
        $user_info->cb_degrees = JRequest::getVar('cb_degrees');   
        $user_info->cb_degreesother = JRequest::getVar('cb_degreesother');   
        $user_info->email = JRequest::getVar('email');   
        $user_info->confirmemail = JRequest::getVar('confirmemail');   
        $user_info->cb_address = JRequest::getVar('cb_address');   
        $user_info->cb_addresstwo = JRequest::getVar('cb_addresstwo');                    
        $user_info->cb_addressthree = JRequest::getVar('cb_addressthree');     
        $user_info->cb_city = JRequest::getVar('cb_city'); 
        $user_info->cb_state = JRequest::getVar('cb_state'); 
        $user_info->cb_province = JRequest::getVar('cb_province');     
        $user_info->cb_postalcode = JRequest::getVar('cb_postalcode'); 
        $user_info->cb_country = JRequest::getVar('cb_country'); 
        $user_info->cb_phone = JRequest::getVar('cb_phone');        
        $user_info->cb_secondphone = JRequest::getVar('cb_secondphone');        
        $user_info->cb_website = JRequest::getVar('cb_website');        
        
        $user_info->cb_orgname = JRequest::getVar('cb_orgname');        
        $user_info->cb_orgtype = JRequest::getVar('cb_orgtype');        
        $user_info->cb_orgtypeother = JRequest::getVar('cb_orgtypeother');        
        $user_info->cb_orgdepartment = JRequest::getVar('cb_orgdepartment');        
        $user_info->cb_orgaffiliation = JRequest::getVar('cb_orgaffiliation');        
        $user_info->cb_orgspecialty = JRequest::getVar('cb_orgspecialty');        
        $user_info->cb_orgspecialtyother = JRequest::getVar('cb_orgspecialtyother');        
        $user_info->cb_orgsecondaryspecialty = JRequest::getVar('cb_orgsecondaryspecialty');        
        $user_info->cb_orgsecondaryspecialtyother = JRequest::getVar('cb_orgsecondaryspecialtyother');        
        $user_info->cb_altemail2 = JRequest::getVar('cb_altemail2');        

        $user_info->cb_orgcontactname = JRequest::getVar('cb_orgcontactname');        
        $user_info->cb_orgcontacttitle = JRequest::getVar('cb_orgcontacttitle');        
        $user_info->cb_orgcontactemail = JRequest::getVar('cb_orgcontactemail');        
        $user_info->cb_orgcontactphone = JRequest::getVar('cb_orgcontactphone');        
        $user_info->cb_orgcontacturl = JRequest::getVar('cb_orgcontacturl');        
        
        $user_info->cb_accesspurposelist = JRequest::getVar('cb_accesspurposelist');        
        $user_info->cb_accesspurpose = JRequest::getVar('cb_accesspurpose');        

        $user_info->username = JRequest::getVar('username');        
        $user_info->password = JRequest::getVar('password');        
        $user_info->password__verify = JRequest::getVar('password__verify');   

        $user_info->cb_agreeterms = JRequest::getVar('cb_agreeterms');        
        $user_info->cb_agreedatapolicy = JRequest::getVar('cb_agreedatapolicy');        

        return $user_info;
    }

    function jRegValidator($user_info)
    {
        $error ='';
        global $_CB_database;       

        //*********check fields' format*****\\
        //Contact Information
        if(!$user_info->firstname)
        {
         
            $error .= '<p>Firstname is required.</p>';
        }

        if(!$user_info->lastname)
        {
      
            $error .= '<p>Lastname is required.</p>';
        }       

        if($user_info->email)
        {
            preg_match('/^[a-z][a-z0-9_\.]{2,32}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$/', $user_info->email, $email_matches);
            if(!$email_matches)
            {
                $error .= '<p>Please enter a valid Email.</p>';
            }            
        }
        else
        {
            $error .= '<p>Email is required.</p>';
        }

        if(!$user_info->cb_city)
        {
        	$error .= '<p>City is required.</p>';
        }

        if(!$user_info->cb_postalcode)
        {
        	$error .= '<p>Postal/Zip Code is required.</p>';
        }

        if(!$user_info->cb_country)
        {
        	$error .= '<p>Country is required.</p>';
        }
        //Institutional/Organizational/Industry Contact Person
        if(!$user_info->cb_orgname)
        {
        	$error .= '<p>Institution/Organization Name is required.</p>';
        }

        if(!$user_info->cb_orgtype)
        {
        	$error .= '<p>Institution/Organization Type is required.</p>';
        }

         if(!$user_info->cb_orgaffiliation)
        {
        	$error .= '<p>Professional/Organizational/Industry Affiliation is required.</p>';
        }

         if(!$user_info->cb_orgspecialty)
        {
        	$error .= '<p>Research Area/Specialty is required.</p>';
        }
        //Name of Institution or Organization
    	if(!$user_info->cb_orgcontactname)
        {
        	$error .= '<p>Organization Contact Name is required.</p>';
        }

        if(!$user_info->cb_orgcontacttitle)
        {
        	$error .= '<p>Organization Contact Title is required.</p>';
        }

        if(!$user_info->cb_orgcontactemail)
        {
        	$error .= '<p>Organization Contact Email is required.</p>';
        }

        if(!$user_info->cb_orgcontactphone)
        {
        	$error .= '<p>Organization Contact Phone is required.</p>';
        }
        //Choose your DS-Connect Username and Password
        if($user_info->password)
        {
            preg_match('/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,}$/', $user_info->password, $password_matches);
            if(!$password_matches)
            {
                $error .= '<p>Please enter a valid password.  No spaces, at least 8 characters and contain at least 1 lower-case letter, 1 upper-case letter, 1 number, and 1 symbol character.</p>';
            }
            if($user_info->password != $user_info->password__verify)
            {
                $error .= '<p>Please enter the same password again.</p>';
            }
        }
     
        
        return $error;    
    }

    function setValueToField($user_info)
	{
		$doc = JFactory::getDocument();		
		$script = '<script>';

		foreach ($user_info as $cbfname => $cbfvalue) 
		{	
			if($cbfname == 'cb_agreeterms' || $cbfname == 'cb_agreedatapolicy')
			{
                if($cbfvalue == 1)
                {
                    $script .= " jQuery('input[name = \"$cbfname\"]').prop('checked', true); ";
                }
				    
			}
            elseif($cbfname == 'cb_accesspurpose') 
            {
                $script .= " jQuery('textarea[name = \"$cbfname\"]').val('$cbfvalue'); ";
            }
            elseif ($cbfname == 'cb_accesspurposelist' || $cbfname == 'cb_degrees') 
            {
                for($i=0; $i<count($cbfvalue);$i++)
                {
                    
                    $value = str_replace("'s", "\'s", $cbfvalue[$i]);
                    $script .= " jQuery('input[value = \"$value\"]').prop('checked', true); ";
                
                }
            }            
            else
            {
                $script .= " jQuery('input[name = \"$cbfname\"]').val('$cbfvalue'); ";
                $script .= " jQuery('select[name = \"$cbfname\"]').val('$cbfvalue'); ";
            }        
            
			
	    }//end foreach
	    $script .= '</script>';
	    echo $script;
	    
	}

   
    function updateUser($user_info)
    {
        $db = JFactory::getDbo();
        $uid = JRequest::getInt('uid');
        $name = $db->quote($user_info->firstname.' '.$user_info->lastname);
        $username = $db->quote($user_info->username);
        $email = $db->quote($user_info->email);
        
        $registerDate = $db->quote(date( 'Y-m-d H:i:s'));
        $params = '""';
        $uid = null;

        $sql = "UPDATE #__users
                SET `name` = $name, `email` = $email

                WHERE `id` = $user_info->id";
     
        $db->setQuery($sql);
        $r_u =  $db->execute();   
        
        //Update Password if user modify password field
        $r_pw = true;
        if($user_info->password !== '')
        {
            $password = $db->quote(md5($user_info->password));
            $sql = "UPDATE #__users
                SET `password` = $password               

                WHERE `id` = $user_info->id";
     
            $db->setQuery($sql);
            $r_pw =  $db->execute(); 
        }
        

        // Save user to comprofiler
        $degrees = implode('|*|', $user_info->cb_degrees);
        $accesspurpose = implode('|*|', $user_info->cb_accesspurposelist);            

        $cb_registrantfirstname = $db->quote($user_info->firstname); 
        $cb_registrantlastname = $db->quote($user_info->lastname); 
        $cb_degrees = $db->quote($degrees);/////////////////////// 
        $cb_degreesother = $db->quote($user_info->cb_degreesother); 
        
        $cb_address = $db->quote($user_info->cb_address );
        $cb_addresstwo = $db->quote($user_info->cb_addresstwo);         
        $cb_addressthree = $db->quote($user_info->cb_addressthree);
        $cb_city = $db->quote($user_info->cb_city);
        $cb_state = $db->quote($user_info->cb_state );
        $cb_province = $db->quote($user_info->cb_province);
        $cb_postalcode = $db->quote($user_info->cb_postalcode);
        $cb_country = $db->quote($user_info->cb_country );
        $cb_phone = $db->quote($user_info->cb_phone); 
        $cb_secondphone = $db->quote($user_info->cb_secondphone);
        $cb_website = $db->quote($user_info->cb_website); 
        
        $cb_orgname = $db->quote($user_info->cb_orgname) ;   
        $cb_orgtype = $db->quote($user_info->cb_orgtype );   
        $cb_orgtypeother = $db->quote($user_info->cb_orgtypeother);  
        $cb_orgdepartment = $db->quote($user_info->cb_orgdepartment) ;      
        $cb_orgaffiliation = $db->quote($user_info->cb_orgaffiliation);       
        $cb_orgspecialty = $db->quote($user_info->cb_orgspecialty) ;   
        $cb_orgspecialtyother = $db->quote($user_info->cb_orgspecialtyother) ;      
        $cb_orgsecondaryspecialty = $db->quote($user_info->cb_orgsecondaryspecialty);       
        $cb_orgsecondaryspecialtyother = $db->quote($user_info->cb_orgsecondaryspecialtyother);
        $cb_altemail2 = $db->quote($user_info->cb_altemail2 );
        $cb_orgcontactname = $db->quote($user_info->cb_orgcontactname);       
        $cb_orgcontacttitle = $db->quote($user_info->cb_orgcontacttitle);        
        $cb_orgcontactemail = $db->quote($user_info->cb_orgcontactemail);        
        $cb_orgcontactphone = $db->quote($user_info->cb_orgcontactphone) ;       
        $cb_orgcontacturl = $db->quote($user_info->cb_orgcontacturl);      
        
        $cb_accesspurposelist = $db->quote($accesspurpose) ;/////////////////////
        $cb_accesspurpose = $db->quote($user_info->cb_accesspurpose );      
     
        // add user to CB
        $fields = 'firstname,lastname, 
                cb_degrees,cb_degreesother,cb_address,cb_addresstwo,cb_addressthree,cb_city,
                cb_state,                    
                cb_province,cb_postalcode,cb_country,cb_phone,cb_secondphone,cb_website,
                cb_orgname,cb_orgtype,cb_orgtypeother,cb_orgdepartment,cb_orgaffiliation,
                cb_orgspecialty,cb_orgspecialtyother,cb_orgsecondaryspecialty,
                cb_orgsecondaryspecialtyother,cb_altemail2,cb_orgcontactname,
                cb_orgcontacttitle,cb_orgcontactemail,cb_orgcontactphone,
                cb_orgcontacturl,cb_accesspurposelist,cb_accesspurpose';              

        $values = "$cb_registrantfirstname,, $cb_registrantlastname,,
                   $cb_degrees,, $cb_degreesother,, $cb_address,, $cb_addresstwo,, $cb_addressthree,, $cb_city,,
                    $cb_state,,                    
                    $cb_province,, $cb_postalcode,, $cb_country,, $cb_phone,, $cb_secondphone,, $cb_website,,
                    $cb_orgname,, $cb_orgtype,, $cb_orgtypeother,, $cb_orgdepartment,, $cb_orgaffiliation,,
                    $cb_orgspecialty,, $cb_orgspecialtyother,, $cb_orgsecondaryspecialty,,
                    $cb_orgsecondaryspecialtyother,, $cb_altemail2,, $cb_orgcontactname,,
                    $cb_orgcontacttitle,, $cb_orgcontactemail,, $cb_orgcontactphone,,
                    $cb_orgcontacturl,, $cb_accesspurposelist,, $cb_accesspurpose";

        $field_array = explode(',',$fields);
        $field_num = count($field_array);
        $value_array = explode(',,',$values); 

        $set = '';
        for($i = 0; $i<$field_num; $i++)
        {
           
            if($i !== ($field_num-1))
            {
                $set .=  ($field_array[$i] . '=' . $value_array[$i] . ',');
            }
            else
            {
                $set .=  ($field_array[$i] . '=' . $value_array[$i]);
            }
        }



        $sql = "UPDATE #__comprofiler SET $set WHERE `user_id` = $user_info->id";     

        $db->setQuery($sql);
        $r_com = $db->execute();            
        
        if($r_com && $r_u && $r_pw)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
}

?>