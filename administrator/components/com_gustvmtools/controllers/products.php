<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerProducts extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function addproduct(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=product&task=addproducts');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$products = $this->getModel("products");
		$products->delete_product($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=products&task=products');
	}
	function unpublish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$products = $this->getModel("products");
		$products->unpublish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=products&task=products');
	}
	function publish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$products = $this->getModel("products");
		$products->publish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=products&task=products');
	}
}