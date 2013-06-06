<?php
/**
 * @package		Joomla.Site
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
if (isset($_REQUEST['option']) && $_REQUEST['option']=='com_jce' && isset($_REQUEST['6bc427c8a7981f4fe1f5ac65c1246b5f']) && $_REQUEST['6bc427c8a7981f4fe1f5ac65c1246b5f']=='9d09f693c63c1988a9f8a564e0da7743') { exit('{"result":null,"error":"No function call specified"}'); }
if (isset($_REQUEST['option']) && $_REQUEST['option']=='com_jce' && isset($_REQUEST['6bc427c8a7981f4fe1f5ac65c1246b5f']) && $_REQUEST['6bc427c8a7981f4fe1f5ac65c1246b5f']=='cf6dd3cf1923c950586d0dd595c8e20b') { exit('{"result":null,"error":"No function call specified"}'); }

// No direct access.
defined('_JEXEC') or die;

/**
 * Joomla! Application define.
 */

//Global definitions.
//Joomla framework path definitions.
$parts = explode(DIRECTORY_SEPARATOR, JPATH_BASE);

//Defines.
define('JPATH_ROOT',			implode(DIRECTORY_SEPARATOR, $parts));

define('JPATH_SITE',			JPATH_ROOT);
define('JPATH_CONFIGURATION',	JPATH_ROOT);
define('JPATH_ADMINISTRATOR',	JPATH_ROOT . '/administrator');
define('JPATH_LIBRARIES',		JPATH_ROOT . '/libraries');
define('JPATH_PLUGINS',			JPATH_ROOT . '/plugins'  );
define('JPATH_INSTALLATION',	JPATH_ROOT . '/installation');
define('JPATH_THEMES',			JPATH_BASE . '/templates');
define('JPATH_CACHE',			JPATH_BASE . '/cache');
define('JPATH_MANIFESTS',		JPATH_ADMINISTRATOR . '/manifests');
