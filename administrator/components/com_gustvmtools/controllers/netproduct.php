<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerNetproduct extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$net = $this->getModel("netproduct");
			$net->set_net_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=netproduct&task=save&id='.$id );
	}
	function addnetproduct()
	{
		$regions = $this->getModel("netproduct");
		$regions->add_net();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=netproducts&task=netproducts');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=netproducts&task=netproducts');
	}
}