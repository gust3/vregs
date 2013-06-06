<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerRegion extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$region = $this->getModel("region");
			$region->set_region_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=region&task=save&id='.$id );
	}
	function addregion()
	{
		$regions = $this->getModel("region");
		$regions->add_region();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=regions&task=regions');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=regions&task=regions');
	}
}