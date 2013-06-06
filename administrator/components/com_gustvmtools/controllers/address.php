<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerAddress extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$address = $this->getModel("address");
			$address->set_address_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=address&task=save&id='.$id );
	}
	function addadress()
	{
		$address = $this->getModel("address");
		$address->add_address();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=addresses&task=adresses');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=addresses&task=adresses');
	}
}