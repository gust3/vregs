<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerNets extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function addnet(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=net&task=addnet');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("nets");
		$nets->delete_net($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=nets&task=nets');
	}
	function unpublish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("nets");
		$nets->unpublish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=nets&task=nets');
	}
	function publish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$nets = $this->getModel("nets");
		$nets->publish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=nets&task=nets');
	}
	function chnames()
	{
		$nets = $this->getModel("nets");
		$nets->changenames();
		$this->setRedirect('index.php?option=com_gustvmtools&view=nets&task=nets');
	}
}