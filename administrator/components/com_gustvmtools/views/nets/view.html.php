<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

 
// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML представление списка сообщений компонента HelloWorld.
 */
class gustVMtoolsViewNets extends JView
{
    /**
     * Сообщения.
     *
     * @var array 
     */
    protected $items;
 
    /**
     * Постраничная навигация.
     *
     * @var object
     */
    protected $pagination;
 
    /**
     * Отображаем список сообщений.
     *
     * @return void
     */
    public function display($tpl = null) 
    {
		JRequest::setVar('view', 'nets');
		/*JToolBarHelper::title( JText::_( 'gustVMtools regions'), 'generic.png' );*/
        $this->items = $this->get('Items'); 
        // Получаем объект постраничной навигации.
        $this->pagination = $this->get('Pagination'); 
        // Есть ли ошибки.
		$this->state = $this->get('State');
		
        if (count($errors = $this->get('Errors'))) 
        {
            JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
        }
        // Отображаем представление.
		
        parent::display($tpl);
    }
}