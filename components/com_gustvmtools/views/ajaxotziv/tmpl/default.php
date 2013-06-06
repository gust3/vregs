<?php
defined('_JEXEC') or die;
	$session =& JFactory::getSession();
	$form = JRequest::get('post');
	if ($session->get('captcha_string') == $form[captcha])
	{		
		$form['premoderation'] = 1;
		$form['published'] = 0;
		if ($form['reiting'] > 5) 
		{
			$form['reiting'] = 5;
		}
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_gustvmtools'.DS.'tables');
		$row =& JTable::getInstance('otziv', 'Table');
		$row->bind($form);
		$row->check($form);
		$row->store($form, true);
		echo "1";
	}
	else
	{
		echo "неправильная контрольная строка";
	}	
?>