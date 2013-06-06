<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerNet extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$net = $this->getModel("net");
			$net->set_net_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=net&task=save&id='.$id );
	}
	function addnet()
	{
		$regions = $this->getModel("net");
		$regions->add_net();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=nets&task=nets');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=nets&task=nets');
	}
	function saveandclose(){
			$net = $this->getModel("net");
			$net->set_net_change();
			$this->setRedirect('index.php?option=com_gustvmtools&view=nets&task=nets');
	}
	
}