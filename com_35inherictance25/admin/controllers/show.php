<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Controller for a single contact
 *
 * @since  1.6
 */
class PxrdshealthboxControllerShow extends JControllerLegacy
{
	function __construct($default = array())
    {
        parent::__construct($default);
       
        $this->registerTask('add', 'edit');        
        $this->registerTask('apply', 'save');      
        $this->registerTask('unpublish', 'publish');
      
        
    }
    
	function show()
	{
        $model = $this->getModel('show');        
        $view = $this->getView('show','html');   
        $view->setModel($model, true); 
        $view->show(null);
	}
    function edit()
    {
        $model = $this->getModel('show');        
        $view = $this->getView('show','html');   
        $view->setModel($model, true); 
        $view->edit(null);
    }

    function save()
    {      
        $model = $this->getModel('show');   
        $model->save();
    }

    function remove()
    {      
        $model = $this->getModel('show');   
        $model->remove();
    }

    function publish()
    {      
        $model = $this->getModel('show');   
        $model->publish();
    }
    function saveorder()
    {
        $model = $this->getModel('show');   
        $model->saveorder();
    }
    function orderup()
    {
        $model = $this->getModel('show');   
        $model->orderup();
        
    }
    function orderdown()
    {
        $model = $this->getModel('show');   
        $model->orderdown();
        
    }
}
