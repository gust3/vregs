<?php
// ������ ������� �������.
defined('_JEXEC') or die;

 
// ���������� ���������� ������������� Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML ������������� ������ ��������� ���������� HelloWorld.
 */
class gustVMtoolsViewOpisanie extends JViewLegacy
{
    /**
     * ���������.
     *
     * @var array 
     */
    protected $items;
 
    /**
     * ������������ ���������.
     *
     * @var object
     */
    protected $pagination;
 
    /**
     * ���������� ������ ���������.
     *
     * @return void
     */
    public function display($tpl = null) 
    {
  		    //get the hello
	$this->form = $this->get('Form');
    parent::display($tpl);
    }
}