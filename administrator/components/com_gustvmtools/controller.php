<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
 
// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');
 
class gustVMtoolsController extends JController
{
    /**
     * Задача по отображению.
     *
     * @return void
     */
   public function display($cachable = false, $urlparams = array()) 
    {
        // Устанавливаем представление по умолчанию, если оно не было установлено.
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'gustVMtools'));
 
        parent::display($cachable);
    }
	function apply(){
	  $view = JRequest::getVar('controller', 1);	  
	  if ($view == "shops")
	  {
		  $shops = $this->getModel("shops");
		  $shops->set_shops();
		  $this->setRedirect( 'index.php?option=com_gustvmtools&view=shops' );	
	  }
	  if ($view == "shop")
	  {
		  $id_shop = JRequest::getVar( 'id_shop', 1 );
		  $shops = $this->getModel("shop");
		  $shops->set_shop_change();
		  $this->setRedirect( 'index.php?option=com_gustvmtools&view=shop&id='.$id_shop );	
	  }
	  if ($view == "product")
	  {
		  $id_product = JRequest::getVar( 'id_product', 1 );
		  $shops = $this->getModel("product");
		  $shops->set_product_change();
		  $this->setRedirect( 'index.php?option=com_gustvmtools&view=product&id='.$id_product );	
	  }
	  if ($view == "region")
	  {
		  $id_region = JRequest::getVar( 'id_region', 1 );
		  $shops = $this->getModel("region");
		  $shops->set_region_change();
		  $this->setRedirect( 'index.php?option=com_gustvmtools&view=region&id='.$id_region );	
	  }
	}
}