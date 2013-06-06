<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerVideos extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function addvideo(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=video&task=addvideo');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$videos = $this->getModel("videos");
		$videos->delete_video($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=videos&task=videos');
	}
	function unpublish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$videos = $this->getModel("videos");
		$videos->unpublish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=videos&task=videos');
	}
	function publish(){		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$videos = $this->getModel("videos");
		$videos->publish($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=videos&task=videos');
	}
}