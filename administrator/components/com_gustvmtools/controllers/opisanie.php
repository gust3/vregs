<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class gustVMtoolsControllerOpisanie extends gustVMtoolsController
{
	function __construct(){
		parent::__construct();
	}
	function apply(){
			$id = JRequest::getVar( 'id', 1 );
			$opisanie = $this->getModel("opisanie");
			$opisanie->set_opisanie_change();
			$this->setRedirect( 'index.php?option=com_gustvmtools&view=opisanie&task=save&id='.$id );
	}
	function addnet()
	{
		$regions = $this->getModel("opisanie");
		$regions->add_opisanie();
		$this->setRedirect( 'index.php?option=com_gustvmtools&view=opisaniya&task=opisaniya');
	}
	function cancel(){
		$this->setRedirect('index.php?option=com_gustvmtools&view=opisaniya&task=opisaniya');
	}
}