<?php
/** ensure this file is being included by a parent file **/
if ( ! defined( '_JEXEC' ) ) { die( 'Direct Access to this location is not allowed.' ); }
jimport( 'joomla.application.component.model' );
class BenhanModelForm extends JModel
{
	function getRecords()
	{
		$app = JFactory::getApplication();	
		$db = JFactory::getDBO();

		// Pagination	
		$limit = JRequest::getVar('limit',$app->getCfg('list_limit'));
		$limitstart = JRequest::getVar('limitstart', 0);
		//filter_order_Dir: 'D' must be uppcased!!! ----- make sortable table
		$order = $app->getUserStateFromRequest( "com_benhan.form.filter_order", 'filter_order', 'ordering','string' );
		$order_dir = $app->getUserStateFromRequest( "com_benhan.form.filter_order_Dir", 'filter_order_Dir', 'desc','string' );	
		//Search
		$search = $app->getUserStateFromRequest("com_benhan.form.search",'search','','string' );
		$search = JString::strtolower( $search );
		$where = "WHERE title LIKE '%".$db->getEscaped($search)."%'";

		$query = "SELECT count(*) FROM #__com_benhan_form";
		$db->setQuery( $query );
		$total = $db->loadResult();
		if($search)
		{
			$query = "SELECT * FROM #__com_benhan_form $where ORDER BY $order $order_dir";
		}
		else
		{
			$query = "SELECT * FROM #__com_benhan_form ORDER BY $order $order_dir";
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
	function getEditor()
    {
        
        $row = JTable::getInstance('form', 'Table');
        $cid = JRequest::getVar( 'cid');         
        $task = JRequest::getVar('task');
        $id = $cid[0];
        $row->load($id);
        return $row;

    }
    function save()
    {
      
        $task = JRequest::getVar('task');
        $id = JRequest::getVar('id');
        $row = JTable::getInstance('form', 'Table');
        if (!$row->bind(JRequest::get('post'))) 
        {
            echo "<script> alert('".$row->getError()."'); 
            window.history.go(-1); </script>\n";
            exit();
        }
        $row->title = JRequest::getVar( 'title', '', 'post', 'string', JREQUEST_ALLOWRAW );
        $row->fields = JRequest::getVar( 'fields', '', 'post', 'string', JREQUEST_ALLOWRAW );
        if(!$id)
        {
        	$row->ordering = 999;       
        	$row->published = 1;
        }
               
        if (!$row->store()) {
            echo "<script> alert('".$row->getError()."'); window.history.
            go(-1); </script>\n";
            exit();
        } 
        $row->reorder();   
        return $row;            

    }
    function publish($published)
    {
    	$db = JFactory::getDBO();
    	$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );

    	if( count($cid) )
        {
            JArrayHelper::toInteger($cid);
            $cids = implode( ',', $cid );

            $query = "UPDATE #__com_benhan_form
                   	SET published = $published
                   WHERE id IN ($cids)";
                
            $db->setQuery( $query );

            if(!$db->query()) 
            {
                $this->setError($db->getErrorMsg());
                return false;
            }
        }
        return true;
    }
    function saveorder()
	{
		
		// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$total	= count( $cid );
		$order= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));	 
		$row = JTable::getInstance('form', 'Table');
	 
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
		
	}
	function orderup()
	{
		
		// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array');
		$id = $cid[0];							 
		$row = JTable::getInstance('form', 'Table');	
		// update ordering values		
		$row->load( (int)$id );
 		$row->move(-1);
 	
		if (!$row->store()) 
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}		
	
	}
	function orderdown()
	{

			// Initialize variables
		$db	= JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array');
		$id = $cid[0];							 
		$row = JTable::getInstance('form', 'Table');	
		// update ordering values		
		$row->load( (int)$id );
 		$row->move(1);
 	
		if (!$row->store()) 
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}			
		
	}
	 
    function remove()
    {        
               
        $cid = JRequest::getVar( 'cid', array(), '', 'array' );
     	$db = JFactory::getDBO();
		if(count($cid))
		{
			$cids = implode( ',', $cid );
			$query = "DELETE FROM #__com_benhan_form WHERE id IN ( $cids )";
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
