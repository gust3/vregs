<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerOpisaniya extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function addopisanie(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=opisanie&task=addnet');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$opisaniya = $this->getModel("opisaniya");
		$opisaniya->delete_otziv($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=opisaniya&task=opisaniya');
	}
	function unpublish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$opisaniya = $this->getModel("opisaniya");
		$opisaniya->unpublish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=opisaniya&task=opisaniya');
	}
	function publish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$opisaniya = $this->getModel("opisaniya");
		$opisaniya->publish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=opisaniya&task=opisaniya');
	}
}