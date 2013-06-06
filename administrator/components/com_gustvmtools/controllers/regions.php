<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerRegions extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function addregion(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=region&task=addregion');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools');
	}
	function remove(){		
		$arr = JRequest::getVar( 'cid',  array(), 'post' );
		$regions = $this->getModel("region");
		$regions->delete_regions($arr);
		$this->setRedirect('index.php?option=com_gustvmtools&view=regions&task=regions');
	}
}