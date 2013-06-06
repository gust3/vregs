<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerOtzivi extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function addotziv(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=otziv&task=addnet');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$otzivi = $this->getModel("otzivi");
		$otzivi->delete_otziv($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=otzivi&task=otzivi');
	}
	function unpublish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$otzivi = $this->getModel("otzivi");
		$otzivi->unpublish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=otzivi&task=otzivi');
	}
	function publish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$otzivi = $this->getModel("otzivi");
		$otzivi->publish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=otzivi&task=otzivi');
	}
}