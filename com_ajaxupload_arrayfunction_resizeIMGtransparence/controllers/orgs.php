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
class PxrdshealthboxControllerOrgs extends JControllerAdmin
{
	public function getModel($name = 'Org', $prefix = 'PxrdshealthboxModel', $config = array('ignore_request'=> true))    
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }

    public function saveOrderAjax()
    {
        $input = JFactory::getApplication()->input;
        $pks = $input->post->get('cid', array(), 'array');
        $order = $input->post->get('order', array(), 'array');
        JArrayHelper::toInteger($pks);
        JArrayHelper::toInteger($order);

        $model = $this->getModel();
        $return = $model->saveorder($pks, $order);
        if ($return)
        {
            echo "1";
        }
        JFactory::getApplication()->close();
    }
}
