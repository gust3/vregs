<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

 
// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML представление списка сообщений компонента HelloWorld.
 */
class gustVMtoolsViewShop extends JViewLegacy
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
		JRequest::setVar('view', 'shop');
        $this->items = $this->get('Items'); 
		JToolBarHelper::apply();
        parent::display($tpl);
    }
}