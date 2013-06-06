<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerOtziv extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$net = $this->getModel("otziv");
			$net->set_otziv_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=otziv&task=save&id='.$id );
	}
	function addnet()
	{
		$regions = $this->getModel("otziv");
		$regions->add_otziv();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=otzivi&task=otzivi');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=otzivi&task=otzivi');
	}
	function saveandclose(){
		$id = JRequest::getVar( 'id', 1 );
		$net = $this->getModel("otziv");
		$net->set_otziv_change();
		$this->setRedirect('index.php?option=com_gustvmtools&view=otzivi&task=otzivi');
	}
}