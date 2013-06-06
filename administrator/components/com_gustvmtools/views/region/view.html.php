<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

class gustVMtoolsViewRegion extends JViewLegacy
{
    protected $items;
    protected $pagination;

    public function display($tpl = null) 
    {
  		/*
		JRequest::setVar('view', 'region');
		$task = JRequest::getVar('task');
        if ($task != "addregion")
		{
			$this->items = $this->get('Items');
		}
		parent::display($tpl);*/
	$this->form = $this->get('Form');
    parent::display($tpl);
    }
    
}