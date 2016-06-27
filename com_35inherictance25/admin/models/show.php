<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
jimport( 'joomla.application.component.model' );

/**
 * Controller for a single contact
 *
 * @since  1.6
 */
class PxrdshealthboxModelShow extends JModelList
{
	function getData()
    {
       	$app = JFactory::getApplication();	
		$db = $this->_db;

		// Pagination	
		$limit = JRequest::getVar('limit',$app->getCfg('list_limit'));
		$limitstart = JRequest::getVar('limitstart', 0);
		
		$order = $app->getUserStateFromRequest( "com_pxrdshealthbox.show.filter_order", 'filter_order', 'ordering','string' );
		$order_dir = $app->getUserStateFromRequest( "com_pxrdshealthbox.show.filter_order_Dir", 'filter_order_Dir', 'ASC','string' );	
		//Search
		$search = JRequest::getVar('search');	
		
		$where = "WHERE name LIKE '%".$db->escape($search)."%'";
		
		$query = "SELECT count(*) FROM #__xrds_portals";
		$db->setQuery( $query );
		$total = $db->loadResult();

		if($search)
		{
			$query = "SELECT * FROM #__xrds_portals $where ORDER BY $order $order_dir";
		}
		else
		{
			$query = "SELECT * FROM #__xrds_portals ORDER BY $order $order_dir";
		}
		
		$db->setQuery( $query, $limitstart, $limit );
		$rows = $db->loadObjectList();
		if ($db->getErrorNum()) 
		{
		echo $db->stderr();
		return false;
		}
		$data = new stdClass();
		$pageNav = new JPagination($total, $limitstart, $limit);	

		$data->records = $rows;
		$data->pagenav = $pageNav;
		$data->search = $search;
		$data->limit = $limit;
		$data->order_dir = $order_dir;
		$data->order = $order;
		return $data;
    }

    function getRow()
    {
        
        $row = JTable::getInstance('show', 'Table');
        $cid = JRequest::getVar( 'cid', array(), '', 'array' );
        $task = JRequest::getVar('task');
        $id = $cid[0];
        $row->load($id);
        return $row;
    }

   	function save()
    {
        $app = JFactory::getApplication();       
        $session = JFactory::getSession();       
        $id = JRequest::getInt('id');
        $task = JRequest::getVar('task');
        $row = JTable::getInstance('show', 'Table');
        if (!$row->bind(JRequest::get('post'))) 
        {
            echo "<script> alert('".$row->getError()."'); 
            window.history.go(-1); </script>\n";
            exit();
        }
      
		$row->name = JRequest::getVar( 'name', '', 'post', 'string', JREQUEST_ALLOWRAW );		
		$row->home_url = JRequest::getVar( 'home_url', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->login_url = JRequest::getVar( 'login_url', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->registration_url = JRequest::getVar( 'registration_url', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->keywords = JRequest::getVar( 'keywords', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->description = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->address = JRequest::getVar( 'address', '', 'post', 'string', JREQUEST_ALLOWRAW );		
		$row->published= JRequest::getVar( 'published', '', 'post', 'interger', JREQUEST_ALLOWRAW );
		$logo = $this->getLogoUpload();

		if(!$logo)
		{
			$row->logo='';
		}
		else
		{
			$row->logo = $logo;
		}


		if(!$id)
		{
			$row->ordering = 0;			
		}

		$session->set('ORG_FORM_DATA', (object)$row);

		if(trim($row->name) ==='')
		{
			$app->enqueueMessage('Please enter the name of organization!','warning');        
        	$link = 'index.php?option=com_pxrdshealthbox&view=show&task=edit&ref=error&cid[]='.$row->id;
        	$app->redirect($link,false);
        
		}

        if (!$row->store()) {
            echo "<script> alert('".$row->getError()."'); window.history.
            go(-1); </script>\n";
            exit();
        }

        if(!$id)
		{			
			$row->reorder();
		}
        
        
        $app->enqueueMessage('Saved!','message');  
        $link = '';
        if($task=='save')
        {
        	$link = 'index.php?option=com_pxrdshealthbox&view=show';
        }
        if($task == 'apply')
        {
        	$link = 'index.php?option=com_pxrdshealthbox&view=show&task=edit&ref=apply&cid[]='.$row->id;
        }
        $app->redirect($link,false);

    }

    function getLogoUpload()
    {
    	
    	$logo = JRequest::getVar('logo',null,'files');
    	$file_name = preg_replace('/[^a-zA-Z0-9\_\-\.]/', '', $logo['name']);
    	$des_path = JPATH_ROOT.DS.'components/com_pxrdshealthbox/images/logos/'.$file_name;
    	$tmp_path = $logo['tmp_name'];
    	
    	if(is_file($des_path))
    	{
    		unlink($des_path);
    	}

    	if(move_uploaded_file($tmp_path,$des_path))
    	{
    		return $file_name;
    	}   
    	else
    	{
    		return false;
    	}	
    }
    function publish()
    {        
       
        $task = JRequest::getVar('task');
        $cid = JRequest::getVar( 'cid', array(), '', 'array' );
        if( $task == 'publish')
        {
            $publish = 1;
        }
        else
        {
            $publish = 0;
        }
        $scheduleTable = JTable::getInstance('show', 'Table');
        $scheduleTable->publish($cid, $publish);//<===============<=======================<   
        $app = JFactory::getApplication();           
       
        $link = 'index.php?option=com_pxrdshealthbox&view=show';
       
        $app->redirect($link,false);    

    }
    function remove()
    {        
               
        $cid = JRequest::getVar( 'cid', array(), '', 'array' );
     	$db = JFactory::getDBO();
		if(count($cid))
		{
			$cids = implode( ',', $cid );
			$query = "DELETE FROM #__xrds_portals WHERE id IN ( $cids )";
			$db->setQuery( $query );
			if (!$db->query()) 
			{
				echo "<script> alert('".$db->getErrorMsg()."'); window.
				history.go(-1); </script>\n";
			}
		}

		$app = JFactory::getApplication();
        $app->enqueueMessage('Deleted!','message');       
       
        $link = 'index.php?option=com_pxrdshealthbox&view=show';
       
        $app->redirect($link,false);
    }

    function saveorder()
	{
		
		// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$total	= count( $cid );
		$order= JRequest::getVar( 'order', array(0), 'post', 'array' );

		JArrayHelper::toInteger($order, array(0));	 
		$row = JTable::getInstance('show', 'Table');
	 
		// update ordering values
		for( $i=0; $i < $total; $i++ )
		{
			$row->load( (int) $cid[$i] );
	 		if ($row->ordering != $order[$i]) 
			{		
				
				$row->ordering = $order[$i];

				if (!$row->store()) 
				{
					JError::raiseError(500, $db->getErrorMsg() );
				}
				
			}
		}
		$row->reorder();	

		$app = JFactory::getApplication();       
        $link = 'index.php?option=com_pxrdshealthbox&view=show';
        $app->redirect($link,false);	
	}
	function orderup()
	{
		
		// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array');
		$id = $cid[0];							 
		$row = JTable::getInstance('show', 'Table');	
		// update ordering values		
		$row->load( (int)$id );
 		$row->move(-1);
 	
		if (!$row->store()) 
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}			
		$app = JFactory::getApplication();       
        $link = 'index.php?option=com_pxrdshealthbox&view=show';
        $app->redirect($link,false);
	}
	function orderdown()
	{
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array');
		$id = $cid[0];							 
		$row = JTable::getInstance('show', 'Table');	
		// update ordering values		
		$row->load( (int)$id );
 		$row->move(1);
 	
		if (!$row->store()) 
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}			
		$app = JFactory::getApplication();       
        $link = 'index.php?option=com_pxrdshealthbox&view=show';
        $app->redirect($link,false);
	}

}
