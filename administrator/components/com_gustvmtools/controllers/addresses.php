<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerAddresses extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("addresses");
		$nets->set_net_settings($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=addresses&task=adresses');
	}	
	function addaddress(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=address&task=addaddress');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("addresses");
		$nets->delete_net($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=addresses&task=adresses');
	}
	function unpublish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("addresses");
		$nets->unpublish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=addresses&task=adresses');
	}
	function publish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("addresses");
		$nets->publish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=addresses&task=adresses');
	}
}