<?php
// ������ ������� �������.
defined('_JEXEC') or die;

 
// ���������� ���������� ������������� Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML ������������� ������ ��������� ���������� HelloWorld.
 */
class gustVMtoolsViewShop extends JViewLegacy
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
		JRequest::setVar('view', 'shop');
        $this->items = $this->get('Items'); 
		JToolBarHelper::apply();
        parent::display($tpl);
    }
}