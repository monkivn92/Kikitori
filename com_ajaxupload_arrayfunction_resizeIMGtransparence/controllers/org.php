<?php
defined('_JEXEC') or die;

class PxrdshealthboxControllerOrg extends JControllerForm
{

	public function save()
	{
		$model = $this->getModel('org');
		$model->save();		
	}

	public function delete()
	{
		$model = $this->getModel('org');
		$model->delete();		
	}

	public function import()
	{
		$view  = $this->getView( 'org','html' );
        $view->importForm();		
	}

	public function saveimport()
	{
		$model = $this->getModel('org');
		$model->saveImport();		
	}

	function thumb()
	{
		$view  = $this->getView( 'org','html' );
        $view->runScript();		
		
	}

}