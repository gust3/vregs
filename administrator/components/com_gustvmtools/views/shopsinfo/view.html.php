<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

 
// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML представление списка сообщений компонента HelloWorld.
 */
class gustVMtoolsViewShopsInfo extends JViewLegacy
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
/*  
  // Получаем данные из модели.
        $this->items = $this->get('Items');
 
        // Получаем объект постраничной навигации.
        $this->pagination = $this->get('Pagination');

 
        // Есть ли ошибки.
        if (count($errors = $this->get('Errors'))) 
        {
            JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
        }
*/
		 JToolBarHelper::title( JText::_( 'магазины'), 'generic.png' );
	
		$this->items = $this->get('Items'); 
        // Получаем объект постраничной навигации.
        $this->pagination = $this->get('Pagination'); 
        // Есть ли ошибки.
		
        if (count($errors = $this->get('Errors'))) 
        {
            JFactory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
        }
        // Отображаем представление.
        parent::display($tpl);
    }
}