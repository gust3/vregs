<?php
// ������ ������� �������.
defined('_JEXEC') or die;

 
// ���������� ���������� ������������� Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML ������������� ������ ��������� ���������� HelloWorld.
 */
class gustVMtoolsViewgustVMtools extends JViewLegacy
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
/*  
  // �������� ������ �� ������.
        $this->items = $this->get('Items');
 
        // �������� ������ ������������ ���������.
        $this->pagination = $this->get('Pagination');

 
        // ���� �� ������.
        if (count($errors = $this->get('Errors'))) 
        {
            JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
        }
*/
 
        // ���������� �������������.
        parent::display($tpl);
    }
}