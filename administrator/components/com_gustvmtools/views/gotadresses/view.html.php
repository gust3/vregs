<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

class gustVMtoolsViewGotadresses extends JViewLegacy
{
    protected $items;
    protected $pagination;

    public function display($tpl = null) 
    {
  		JRequest::setVar('view', 'gotadresses');
		parent::display($tpl);
    }
}