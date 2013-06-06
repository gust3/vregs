<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

 
// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');
 
/**
 * HTML представление списка сообщений компонента HelloWorld.
 */
class gustVMtoolsViewOpisanie extends JViewLegacy
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
  		    //get the hello
	$this->form = $this->get('Form');
    parent::display($tpl);
    }
}