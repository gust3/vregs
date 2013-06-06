<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerVideo extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$video = $this->getModel("video");
			$video->set_video_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=video&task=save&id='.$id );
	}
	function addvideo()
	{
		$regions = $this->getModel("video");
		$regions->add_video();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=videos&task=videos');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=videos&task=videos');
	}
}