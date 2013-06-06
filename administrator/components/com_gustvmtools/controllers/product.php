<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerProduct extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$product = $this->getModel("product");
			$product->set_product_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=product&task=save&id='.$id );
	}
	function addproduct()
	{
		$product = $this->getModel("product");
		$product->add_product();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=products&task=products');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=products&task=products');
	}
}