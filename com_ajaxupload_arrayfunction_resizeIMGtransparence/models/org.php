<?php
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class PxrdshealthboxModelOrg extends JModelAdmin
{
	protected $text_prefix = 'COM_PXRDSHEALTHBOX';

	public function getTable($type = 'Pxrdshealthbox', $prefix = 'PxrdshealthboxTable', $config = array())	
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_pxrdshealthbox.org', 'org', 
									array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
		return false;
		}
		return $form;
	}

	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_pxrdshealthbox.edit.org.data', array());

		if (empty($data))
		{
		$data = $this->getItem();
		}

		return $data;
	}
	
	protected function prepareTable($table)
	{
		$table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);		
	}


	public function save()
	{
		$input = JFactory::getApplication()->input;
        $task = $input->post->get('task');
        $data = $input->post->get('jform', array(), 'array');	
        
        //**Get Logo
        $logo = JRequest::getVar('logo',null,'files');	    

    	$tmp_path = $logo['tmp_name'];    	
		$file_name = time() .'_'. JFile::makeSafe(  $logo['name'] );
		$dest_path = JPATH_SAVED_LOGOS .DIRECTORY_SEPARATOR. $file_name;		
 
		if( !JFolder::exists(JPATH_SAVED_LOGOS) )
		{
			JFolder::create(JPATH_SAVED_LOGOS);
		}

		if( !JFolder::exists(JPATH_SAVED_LOGOS.'/thumb') )
		{
			JFolder::create(JPATH_SAVED_LOGOS.'/thumb');
		}

		if( JFile::upload($tmp_path, $dest_path) )
		{
			$data['logo'] = $file_name;
			require_once(JPATH_HELPERS.'/resize-class.php');
			$resizeClass = new resize($dest_path);
			$resizeClass->resizeImage(100,100,'auto');
			$resizeClass->saveImage(JPATH_SAVED_LOGOS."/thumb/$file_name");
		}
		else
		{
			unset($data['logo'] );
		}

    	//**Save all data
    	
    	if(parent::save($data))
    	{
    		$msg = 'Saved!';
    		$mode="message";
    	}
    	else
    	{
    		$msg = 'Save failed!';
    		$mode="error";
    	}

    	$id = $data['id'] ? $data['id'] : $this->_db->insertid();
		
		$app = JFactory::getApplication();

		$app->enqueueMessage($msg, $mode);

    	if($task=='org.apply')
    	{
    		$app->redirect('index.php?option=com_pxrdshealthbox&view=org&id='.$id, false);
    	}
    	if($task=='org.save')
    	{
    		$app->redirect('index.php?option=com_pxrdshealthbox',false);
    	}

	}

	public function delete()
	{
		$input = JFactory::getApplication()->input;
		$cid = $input->post->get('cid', array(), 'array');		
	
		$ids = implode(',', $cid);

		$sql = "SELECT logo FROM #__xrds_portals WHERE id IN ($ids)";

		$this->_db->setQuery($sql);

		$logos = $this->_db->loadObjectList();

		if(parent::delete($cid))
		{	
			foreach ($logos as $logo) 
			{
				$path = JPATH_SITE.'/components/com_pxrdshealthbox/images/logos/'.$logo->logo;				
				unlink($path);
			}

			$msg = 'Deleted!';
    		$mode="message";

		}
		else
		{
			$msg = 'Delete Failed!';
    		$mode="error";
		}
		JFactory::getApplication()->enqueueMessage($msg, $mode);
		JFactory::getApplication()->redirect('index.php?option=com_pxrdshealthbox',false);
	}

	public function saveImport()
	{
		$csv = JRequest::getVar('file_target',null,'files');	
		$fo = JRequest::getVar('form_options');// override duplicate option
		$msg = '';
		$csv_saved_path = JPATH_SAVED_LOGOS.'/csv';
		$csv_tmp_path = $csv['tmp_name'];		

		$csv_file_name = time() .'_'. JFile::makeSafe( $csv['name'] );
		$csv_dest_path = $csv_saved_path .'/'. $csv_file_name;
		//die($csv_dest_path);
 
		if( !JFolder::exists($csv_saved_path) )
		{
			JFolder::create($csv_saved_path);
		}

		if( JFile::upload($csv_tmp_path, $csv_dest_path) )
		{
			$msg .= '<p>Upload Successfully</p>';
			$data  = $this->parseCSV($csv_dest_path);
			$msg .= $this->updateDatabase($data, $fo);
		}
		else
		{
			$msg = 'Some errors occured!';
		}
		echo $msg;
		JFactory::getApplication()->close();
	}

	function parseCSV($filepath)
	{
		$compare_key = 'name';		
		$db = $this->_db;		
		$row = 0;
		$max_line_number = 1000;

		$fh = fopen($filepath, 'r');

		// Get field header
		$line_1st = fgetcsv($fh, $max_line_number, ",");
		$fields = array();
		$data = new stdClass();
		foreach ($line_1st as $key => $value) 
		{
			$value = strtolower($value);	
			if($value !=='#' && trim($value) !=='' && $value !== 'account')
			{
				$fields[$key] = $value;
				$data->{$value} = array();
			}

		}

		// Retrieve data from csv file
		while ( $line_next = fgetcsv($fh, $max_line_number, ",")) 
		{
			if($line_next[0] === '') // `name` field is not blank
			{
				continue;
			}
			foreach ($fields as $key => $value) 
			{
				
				$data->{$value}[] = $line_next[$key];								
			}
		}

		//Find the same organizations between the current data and the data from uploaded csv file
		$sql = "SELECT $compare_key FROM #__xrds_portals";
		$db->setQuery($sql);
		$current_data = $db->loadColumn();
		$return = array();
 		$return['diff_keys'] = array_keys(array_diff($data->{$compare_key},$current_data));
 		$return['same_keys'] = array_keys(array_intersect($data->{$compare_key}, $current_data));
 		$return['fields'] = $fields;
 		$return['data'] = $data;

 		return $return;
	}

	function updateDatabase($data, $options)
	{
		$msg = '';		
		$compare_key = 'name';
		$db = $this->_db;
		
		//Insert new data	
		if($data['diff_keys'])	
		{
			$fields = implode(',', $data['fields']);
			$values_stmt = '';
			$delimiter_1 = ' ';
			foreach ($data['diff_keys'] as  $key) 
			{
				$values_stmt .= $delimiter_1 .'(';
				$delimiter_2 = '';
				foreach ($data['fields'] as  $field) 
				{
					$values_stmt .= $delimiter_2 .$db->quote( $data['data']->{$field}[$key] );
					$delimiter_2 = ',';
				}
				$values_stmt .= ') ';
				$delimiter_1 = ',';
			}

			$sql = "INSERT INTO #__xrds_portals($fields) VALUES $values_stmt";	
			$db->setQuery($sql);

			if($db->query())
			{
				$msg .= '<p>Import New Data Done!</p>';
			}
			else
			{
				$msg .= '<p>Import New Data Failed!</p>';
			}
		}
		//Update database in case there are duplicate rows
		if($data['same_keys'])
		{
			if($options === 'false') // Not override duplicate
			{			
				
				foreach ($data['same_keys'] as  $key) 
				{				
					
					echo  ('<p>' . $data['data']->{$compare_key}[$key] . ' has already existed.</p>');
				}
					
			}
			else
			{
				$delimiter_1 = ' ';
				$set_stmt = '';
				$where_in = array();
				$compare_key_remove = array_shift($data['fields']); // No needs to update `name` field

				foreach ($data['fields'] as  $field) 
				{
					$set_stmt .= $delimiter_1 . " $field = CASE $compare_key ";
					
					foreach ($data['same_keys'] as  $key) 
					{		
						$set_stmt .= ' WHEN ' . $db->quote($data['data']->{$compare_key}[$key]) . ' THEN '. $db->quote($data['data']->{$field}[$key]) ;
						
					}
					$set_stmt .= ' END ';
					$delimiter_1 = ',';				
				}

				foreach ($data['same_keys'] as  $key) 
				{		
					$where_in[] = $db->quote($data['data']->{$compare_key}[$key]);
				}

				$where_in = implode(',', $where_in);
				
				$sql = "UPDATE #__xrds_portals SET $set_stmt WHERE $compare_key IN ($where_in)";			
				$db->setQuery($sql);

				if($db->query())
				{
					$msg .= '<p>Update Data Done!</p>';
				}
				else
				{
					$msg .= '<p>Update Data Failed!</p>';
				}

			}
		}
		return $msg;
		
	}

}