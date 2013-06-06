<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerNetproducts extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function addnetproduct(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=netproduct&task=addnetproduct');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("netproducts");
		$nets->delete_netproduct($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=netproducts&task=netproducts');
	}
	function unpublish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("netproducts");
		$nets->unpublish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=netproducts&task=netproducts');
	}
	function publish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("netproducts");
		$nets->publish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=netproducts&task=netproducts');
	}
}