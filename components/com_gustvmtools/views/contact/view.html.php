<?php

/**
 * @version		$Id: view.html.php 15 2009-11-02 18:37:15Z chdemko $
 * @package		Joomla16.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @author		Christophe Demko
 * @link		http://joomlacode.org/gf/project/helloworld_1_6/
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class gustVMtoolsViewContact extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		/*
		// Assign data to the view
		$this->items = $this->get('Items'); */
		$model = & $this->getModel();		
        $this->info = $model->getInfo(JRequest::getVar('id'));
		// Получаем объект постраничной навигации.
		/*       
	   $this->pagination = $this->get('Pagination'); 
        // Есть ли ошибки.
		$this->state = $this->get('State');
		*/
		$db = JFactory::getDBO();
		$document = JFactory::getDocument();
		$mainframe = JFactory::getApplication();
		$pathway = $mainframe->getPathway();

		if (JRequest::getVar('layout', 'default') == 'products')
		{
			$document->setTitle('Контакты - '.str_replace("'","",$this->info[0]->label)." - Продукты");
			$pathway->addItem(str_replace("'","",$this->info[0]->label)." - продукты");
			$id = JRequest::getVar("id");
			
			//$query ='SELECT DISTINCT ru.mf_name, vp.virtuemart_manufacturer_id FROM #__vmtools_nets_products as np, #__virtuemart_product_manufacturers as vp, #_virtuemart_manufacturers_ru_ru as ru WHERE vp.virtuemart_product_id = np.id_product AND id_net='.$id;
			$query ='SELECT DISTINCT ru.mf_name, vp.virtuemart_manufacturer_id FROM #__vmtools_nets_products as np, #__virtuemart_product_manufacturers as vp, #__virtuemart_manufacturers_ru_ru as ru WHERE ru.virtuemart_manufacturer_id = vp.virtuemart_manufacturer_id AND vp.virtuemart_product_id = np.id_product AND np.id_net='.$id;
			$db->setquery($query);
			$this->man = $db->loadobjectlist();
			
			
			if (JRequest::getInt('man', 0) > 0)
			{
			$query ='SELECT SQL_CALC_FOUND_ROWS np.id_product AS id, np.price AS price FROM #__vmtools_nets_products as np, #__virtuemart_product_manufacturers as vp WHERE vp.virtuemart_manufacturer_id = '.JRequest::getInt('man', 0).' AND vp.virtuemart_product_id = np.id_product AND id_net='.$id." LIMIT ".JRequest::getVar('limitstart', '0', 'get').", ".JRequest::getVar('limit', '20');
			$db->setquery($query);
			}
			else
			{
			$query ='SELECT SQL_CALC_FOUND_ROWS np.id_product AS id, np.price AS price FROM #__vmtools_nets_products as np WHERE id_net='.$id." LIMIT ".JRequest::getVar('limitstart', '0', 'get').", ".JRequest::getVar('limit', '20');
			$db->setquery($query);
			}
			$this->items = $db->loadobjectlist();
			$this->pagination =jimport('joomla.html.pagination');
			$db->setQuery('SELECT FOUND_ROWS();');
			$this->total = $db->loadResult();
			$this->pagination = new JPagination( $this->total, JRequest::getVar('limitstart', '0', 'get'), JRequest::getVar('limit', '20'));
		}
		else
		{
			$document->setTitle('Контакты - '.str_replace("'","",$this->info[0]->label)." - Адреса");
			$pathway->addItem(str_replace("'","",$this->info[0]->label)." - адреса");
			$id = JRequest::getVar("id");
			$query ='SELECT SQL_CALC_FOUND_ROWS * FROM #__vmtools_shops_adresses WHERE id_net='.$id." LIMIT ".JRequest::getVar('start', '0', 'get').", ".JRequest::getVar('limit', '20');
			$db->setquery($query);
			$this->items = $db->loadobjectlist();
			$this->pagination =jimport('joomla.html.pagination');
			$db->setQuery('SELECT FOUND_ROWS();');
			$this->total = $db->loadResult();
			$this->pagination = new JPagination( $this->total, JRequest::getVar('limitstart', '0', 'get'), JRequest::getVar('limit', '20'));
		}
		
		
		// Display the view
		parent::display($tpl);
	}
}
