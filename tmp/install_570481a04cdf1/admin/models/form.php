<?php
/** ensure this file is being included by a parent file **/
if ( ! defined( '_JEXEC' ) ) { die( 'Direct Access to this location is not allowed.' ); }
jimport( 'joomla.application.component.model' );
class MedschdModelSchedule extends JModel
{
	function show()
	{
		$mainframe = JFactory::getApplication();	
		$db = JFactory::getDBO();

		// Pagination	
		$limit = JRequest::getVar('limit',$mainframe->getCfg('list_limit'));
		$limitstart = JRequest::getVar('limitstart', 0);
		//filter_order_Dir: 'D' must be uppcased!!! ----- make sortable table
		$order = $mainframe->getUserStateFromRequest( "com_medschd.schedule.filter_order", 'filter_order', 'ordering','string' );
		$order_dir = $mainframe->getUserStateFromRequest( "com_medschd.schedule.filter_order_Dir", 'filter_order_Dir', 'desc','string' );	
		//Search
		$search = $mainframe->getUserStateFromRequest("com_medschd.schedule.search",'search','','string' );
		$search = JString::strtolower( $search );
		$where = "WHERE title LIKE '%".$db->getEscaped($search)."%'";

		$query = "SELECT count(*) FROM #__jmed_schd";
		$db->setQuery( $query );
		$total = $db->loadResult();
		if($search)
		{
			$query = "SELECT * FROM #__jmed_schd $where ORDER BY $order $order_dir";
		}
		else
		{
			$query = "SELECT * FROM #__jmed_schd ORDER BY $order $order_dir";
		}
		
		$db->setQuery( $query, $limitstart, $limit );
		$rows = $db->loadObjectList();
		if ($db->getErrorNum()) 
		{
		echo $db->stderr();
		return false;
		}
		$list['rows'] = $rows;
		$list['total'] = $total;
		$list['search'] = $search;
		return $list;
	}
	function edit()
    {
        
        $row = JTable::getInstance('schedule', 'Table');
        $cid = JRequest::getVar( 'cid', array(), '', 'array' );
        $task = JRequest::getVar('task');
        $id = $cid[0];
        $row->load($id);
        return $row;

    }
    function save()
    {
        
       
        $task = JRequest::getVar('task');
        $row = JTable::getInstance('schedule', 'Table');
        if (!$row->bind(JRequest::get('post'))) 
        {
            echo "<script> alert('".$row->getError()."'); 
            window.history.go(-1); </script>\n";
            exit();
        }
        $row->title = JRequest::getVar( 'title', '', 'post', 'string', JREQUEST_ALLOWRAW );
        $row->ordering = JRequest::getVar( 'ordering', '', 'post','string', JREQUEST_ALLOWRAW );       
        if (!$row->store()) {
            echo "<script> alert('".$row->getError()."'); window.history.
            go(-1); </script>\n";
            exit();
        }
        return $row;        

    }
    function saveorder()
	{
		
		// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$total	= count( $cid );
		$order= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));	 
		$row = JTable::getInstance('schedule', 'Table');
	 
		// update ordering values
		for( $i=0; $i < $total; $i++ )
		{
			$row->load( (int) $cid[$i] );
	 		if ($row->ordering != $order[$i]) 
			{		
				/*		
				$step = $row->ordering - $order[$i];				
				if($step<0)
				{
					for($j=0; $j<(-$step); $j++)
					{
						$row->move(1);
					}
				}
				else
				{
					for($j=0; $j<$step; $j++)
					{
						$row->move(-1);
					}
				}
				*/
				$row->ordering = $order[$i];

				if (!$row->store()) 
				{
					JError::raiseError(500, $db->getErrorMsg() );
				}
				
			}
		}
		$row->reorder();
		$rows = $this->show();
		return $rows;
	}
	function orderup()
	{
		
		// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array');
		$id = $cid[0];							 
		$row = JTable::getInstance('schedule', 'Table');	
		// update ordering values		
		$row->load( (int)$id );
 		$row->move(-1);
 	
		if (!$row->store()) 
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}			
		$rows = $this->show();
		return $rows;
	}
	function orderdown()
	{

			// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array');
		$id = $cid[0];							 
		$row = JTable::getInstance('schedule', 'Table');	
		// update ordering values		
		$row->load( (int)$id );
 		$row->move(1);
 	
		if (!$row->store()) 
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}			
		$rows = $this->show();
		return $rows;
	}
	 
    function remove()
    {        
               
        $cid = JRequest::getVar( 'cid', array(), '', 'array' );
     	$db = JFactory::getDBO();
		if(count($cid))
		{
			$cids = implode( ',', $cid );
			$query = "DELETE FROM #__jmed_schd WHERE id IN ( $cids )";
			$db->setQuery( $query );
			if (!$db->query()) 
			{
				echo "<script> alert('".$db->getErrorMsg()."'); window.
				history.go(-1); </script>\n";
			}
		}
    }
}

?>
