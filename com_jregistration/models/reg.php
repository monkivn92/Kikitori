<?php
jimport( 'joomla.application.component.model' );

class JregistrationModelReg extends JModel
{	
	function __construct()
	{		
		parent::__construct();
	}	

	function getCBfield()
	{

		global $_CB_framework,$_CB_database, $ueConfig, $_PLUGINS;
			
		$cbUser =& CBuser::getInstance( null );
		$CBfields = array();
		//$reason = 'list': show fields that aren't shown in registration page
		// Note: check field whether is pulish or not
		$CBfields['cb_registrantfirstname'] = $cbUser->getField( 'cb_registrantfirstname', null, 'htmledit', 'div');
		$CBfields['cb_registrantlastname'] = $cbUser->getField( 'cb_registrantlastname', null, 'htmledit', 'div');
		$CBfields['cb_degrees'] = $cbUser->getField( 'cb_degrees', null, 'htmledit', 'div','list');
		$CBfields['cb_degreesother'] = $cbUser->getField( 'cb_degreesother', null, 'htmledit', 'div','list');
		$CBfields['email'] = $cbUser->getField( "email", null, 'htmledit', 'div', 'register',0,false);
		$CBfields['confirmemail'] = $cbUser->getField( "confirmemail", null, 'htmledit', 'div', 'register',0,false);
		$CBfields['cb_address'] = $cbUser->getField( 'cb_address', null, 'htmledit', 'div','search');
		$CBfields['cb_addresstwo'] = $cbUser->getField( 'cb_addresstwo', null, 'htmledit', 'div','list');
		$CBfields['cb_addressthree'] = $cbUser->getField( 'cb_addressthree', null, 'htmledit', 'div','list');
		$CBfields['cb_city'] = $cbUser->getField( 'cb_city', null, 'htmledit', 'div','list');
		$CBfields['cb_state'] = $cbUser->getField( 'cb_state', null, 'htmledit', 'div','list');
		$CBfields['cb_province'] = $cbUser->getField( 'cb_province', null, 'htmledit', 'div','list');
		$CBfields['cb_postalcode'] = $cbUser->getField( 'cb_postalcode', null, 'htmledit', 'div','list');		
		$CBfields['cb_country'] = $cbUser->getField( 'cb_country', null, 'htmledit', 'div','list');
		$CBfields['cb_phone'] = $cbUser->getField( 'cb_phone', null, 'htmledit', 'div','list');
		$CBfields['cb_secondphone'] = $cbUser->getField( 'cb_secondphone', null, 'htmledit', 'div','list');
		$CBfields['cb_website'] = $cbUser->getField( 'cb_website', null, 'htmledit', 'div','list');
		
		$CBfields['cb_orgname'] = $cbUser->getField( 'cb_orgname', null, 'htmledit', 'div','list');
		$CBfields['cb_orgtype'] = $cbUser->getField( 'cb_orgtype', null, 'htmledit', 'div','list');
		$CBfields['cb_orgtypeother'] = $cbUser->getField( 'cb_orgtypeother', null, 'htmledit', 'div','list');
		$CBfields['cb_orgdepartment'] = $cbUser->getField( 'cb_orgdepartment', null, 'htmledit', 'div','list');
		$CBfields['cb_orgaffiliation'] = $cbUser->getField( 'cb_orgaffiliation', null, 'htmledit', 'div','list');
		$CBfields['cb_orgspecialty'] = $cbUser->getField( 'cb_orgspecialty', null, 'htmledit', 'div','list');
		$CBfields['cb_orgspecialtyother'] = $cbUser->getField( 'cb_orgspecialtyother', null, 'htmledit', 'div','list');
		$CBfields['cb_orgsecondaryspecialty'] = $cbUser->getField( 'cb_orgsecondaryspecialty', null, 'htmledit', 'div','list');
		$CBfields['cb_orgsecondaryspecialtyother'] = $cbUser->getField( 'cb_orgsecondaryspecialtyother', null, 'htmledit', 'div','list');
		$CBfields['cb_altemail2'] = $cbUser->getField( 'cb_altemail2', null, 'htmledit', 'div','list');

		$CBfields['cb_orgcontactname'] = $cbUser->getField( 'cb_orgcontactname', null, 'htmledit', 'div','list');
		$CBfields['cb_orgcontacttitle'] = $cbUser->getField( 'cb_orgcontacttitle', null, 'htmledit', 'div','list');
		$CBfields['cb_orgcontactemail'] = $cbUser->getField( 'cb_orgcontactemail', null, 'htmledit', 'div','list');
		$CBfields['cb_orgcontactphone'] = $cbUser->getField( 'cb_orgcontactphone', null, 'htmledit', 'div','list');
		$CBfields['cb_orgcontacturl'] = $cbUser->getField( 'cb_orgcontacturl', null, 'htmledit', 'div','list');
		
		$CBfields['cb_accesspurposelist'] = $cbUser->getField( 'cb_accesspurposelist', null, 'htmledit', 'div','list');
		$CBfields['cb_accesspurpose'] = $cbUser->getField( 'cb_accesspurpose', null, 'htmledit', 'div','list');
		
		$CBfields['username'] = $cbUser->getField( 'username', null, 'htmledit', 'div','register');
		$CBfields['password'] = $cbUser->getField('password', null, 'htmledit', 'div', 'register');

		$CBfields['cb_agreeterms'] = $cbUser->getField( 'cb_agreeterms', null, 'htmledit', 'div','list');
		$CBfields['cb_agreedatapolicy'] = $cbUser->getField( 'cb_agreedatapolicy', null, 'htmledit', 'div','list');
		
		return $CBfields;

	}
     
    function getRegFormData()
    {
        $user_info = new \stdClass();        
        $jreg_user_info = array();   
        
        $user_info->cb_registrantfirstname = JRequest::getCmd('cb_registrantfirstname');     
        $user_info->cb_registrantlastname = JRequest::getCmd('cb_registrantlastname');   
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

        //check username if it has already existed     
        $_CB_database->query('SELECT id FROM #__users WHERE username="'.$user_info->username.'"');
        $r_user = $_CB_database->loadResult();

        if($r_user)
        {
            $error .= "<p>The username has already existed.</p>";              
        }

        //*********check fields' format*****\\
        //Contact Information
        if($user_info->cb_registrantfirstname)
        {
            preg_match('/^[a-zA-Z ]+$/', $user_info->cb_registrantfirstname, $fname_matches);
            if(!$fname_matches)
            {
                $error .= '<p>Please enter a valid Firstname.</p>';
            }
        }
        else
        {
            $error .= '<p>Firstname is required.</p>';
        }

        if($user_info->cb_registrantlastname)
        {
            preg_match('/^[a-zA-Z ]+$/', $user_info->cb_registrantlastname, $lname_matches);
            if(!$lname_matches)
            {
                $error .= '<p>Please enter a valid Lastname.</p>';
            }
        }
        else
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
            if($user_info->email != $user_info->confirmemail)
            {
                $error .= '<p>Please enter the same email again</p>';
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
        else
        {
            $error .= '<p>Password is required.</p>';
        }
        //Terms of Use
        if($user_info->cb_agreeterms != 1)
        {
            $error .= "<p>You must agree to the Terms & Conditions and the Privacy Policy.</p>";             
        }

        if($user_info->cb_agreedatapolicy != 1)
        {
            $error .= "<p>You must agree to the Data Access and Publication Policy.</p>";             
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
				$script .= " jQuery('input[name = \"$cbfname\"]').prop('checked', true); ";
			}
            elseif($cbfname == 'cb_accesspurpose') 
            {
                $script .= " jQuery('textarea[name = \"$cbfname\"]').val('$cbfvalue'); ";
            }
            elseif ($cbfname = 'cb_accesspurposelist' || $cbfname = 'cb_degrees') 
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
			
	    }
	    $script .= '</script>';
	    echo $script;
	    
	}

    function getAdminMail()
    {
        
        global $_CB_database;
        $email = JRequest::getVar('email');
        $_CB_database->query('SELECT u.email 
                            FROM #__users AS u,#__user_usergroup_map AS ugm 
                            WHERE u.id = ugm.user_id
                            AND ugm.group_id = 8 ');
        $r = $_CB_database->loadResultArray();
        return $r;       
    }
    function sendMailtoAdmin($user_info,$uid)
    {
        $app = JFactory::getApplication();
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array( 
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' ) 
        );                 
        $mailer->setSender($sender);
       
        $recipient = $this->getAdminMail();
        $mailer->addRecipient($recipient);  

        $subject = 'Have a new researcher registered'; 
        $body = "The new researcher user's information:\n\nUser's ID: $uid\n\nFistname: $user_info->fname\n\nLastname: $user_info->lname\n\nUsername: $user_info->username\n\nEmail: $user_info->email";       
          
        $mailer->setSubject($subject);
        $mailer->setBody($body);
        $send = $mailer->Send();//send mail to admin to get approval
        if ( $send !== true ) {
            echo 'Error sending email: ' . $send->__toString();
        } else {
            echo 'Mail sent';
        }        


    }
   
   
    function addUser($user_info)
    {
        $db = JFactory::getDbo();

        $name = $db->quote($user_info->cb_registrantfirstname.' '.$user_info->cb_registrantlastname);
        $username = $db->quote($user_info->username);
        $email = $db->quote($user_info->email);
        $password = $db->quote(md5($user_info->password));
        $registerDate = $db->quote(date( 'Y-m-d H:i:s'));
        $params = '""';
        $uid = null;

        $sql = 'INSERT INTO #__users (name, username, email, password, block, sendEmail,registerDate,params)'
                .' VALUES ('
                            .$name.','
                            .$username.','
                            .$email.','
                            .$password.','
                            .'0,'
                            .'0,'
                            .$registerDate.','
                            .$params.
                          ')';
        
        $db->setQuery($sql);
        $r =  $db->execute();
       
        if($r)
        {
            $sql = 'SELECT id FROM #__users WHERE username='.$username;
            $db->setQuery($sql);
            $uid = $db->loadResult();            
        }
        else
        {
            return false;            
        }

        if($uid)
        {

            // Save user to comprofiler
            $degrees = implode('|*|', $user_info->cb_degrees);
            $accesspurpose = implode('|*|', $user_info->cb_accesspurposelist);           

            $cb_registrantfirstname = $db->quote($user_info->cb_registrantfirstname); 
            $cb_registrantlastname = $db->quote($user_info->cb_registrantlastname); 
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
                 
            $cb_agreeterms = $db->quote($user_info->cb_agreeterms);
            $cb_agreedatapolicy = $db->quote($user_info->cb_agreedatapolicy) ;

            include_once( JPATH_ADMINISTRATOR . '/components/com_comprofiler/comprofiler.class.php' );              
            $registeripaddr = $db->quote(cbGetIPlist()); 

            // add new user to group user
            $sql = 'INSERT INTO #__user_usergroup_map(user_id, group_id)'
                    .' VALUES ("'.$uid.'","2"),("'.$uid.'","16")';       
            $db->setQuery($sql);
            $r_group = $db->execute();                    
         
            // add user to CB
            $fields = 'id,user_id,firstname,lastname,approved, confirmed, registeripaddr, 
                    cb_degrees,cb_degreesother,cb_address,cb_addresstwo,cb_addressthree,cb_city,
                    cb_state,                    
                    cb_province,cb_postalcode,cb_country,cb_phone,cb_secondphone,cb_website,
                    cb_orgname,cb_orgtype,cb_orgtypeother,cb_orgdepartment,cb_orgaffiliation,
                    cb_orgspecialty,cb_orgspecialtyother,cb_orgsecondaryspecialty,
                    cb_orgsecondaryspecialtyother,cb_altemail2,cb_orgcontactname,
                    cb_orgcontacttitle,cb_orgcontactemail,cb_orgcontactphone,
                    cb_orgcontacturl,cb_accesspurposelist,cb_accesspurpose,
                    cb_agreeterms,cb_agreedatapolicy';

            $values = "$uid, $uid, $cb_registrantfirstname, $cb_registrantlastname, 1, 1, $registeripaddr,
                       $cb_degrees, $cb_degreesother, $cb_address, $cb_addresstwo, $cb_addressthree, $cb_city,
                        $cb_state,                    
                        $cb_province, $cb_postalcode, $cb_country, $cb_phone, $cb_secondphone, $cb_website,
                        $cb_orgname, $cb_orgtype, $cb_orgtypeother, $cb_orgdepartment, $cb_orgaffiliation,
                        $cb_orgspecialty, $cb_orgspecialtyother, $cb_orgsecondaryspecialty,
                        $cb_orgsecondaryspecialtyother, $cb_altemail2, $cb_orgcontactname,
                        $cb_orgcontacttitle, $cb_orgcontactemail, $cb_orgcontactphone,
                        $cb_orgcontacturl, $cb_accesspurposelist, $cb_accesspurpose,
                        $cb_agreeterms, $cb_agreedatapolicy";

            $sql = "INSERT INTO #__comprofiler($fields) VALUES($values)";   
            $db->setQuery($sql);
            $r_com = $db->execute();            
        }
        return $uid;
    }
	
}

?>