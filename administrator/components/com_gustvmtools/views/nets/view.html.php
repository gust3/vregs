<?php
// ������ ������� �������.
defined('_JEXEC') or die;

 
// ���������� ���������� ������������� Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML ������������� ������ ��������� ���������� HelloWorld.
 */
class gustVMtoolsViewNets extends JView
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
		JRequest::setVar('view', 'nets');
		/*JToolBarHelper::title( JText::_( 'gustVMtools regions'), 'generic.png' );*/
        $this->items = $this->get('Items'); 
        // �������� ������ ������������ ���������.
        $this->pagination = $this->get('Pagination'); 
        // ���� �� ������.
		$this->state = $this->get('State');
		
        if (count($errors = $this->get('Errors'))) 
        {
            JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
        }
        // ���������� �������������.
		
        parent::display($tpl);
    }
}