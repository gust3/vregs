<?php
/**
 * @version             $Id$
 * @copyright           Copyright (C) 2005 - 2009 Joomla! Vargas. All rights reserved.
 * @license             GNU General Public License version 2 or later; see LICENSE.txt
 * @author              Guillermo Vargas (guille@vargas.co.cr)
 */

// no direct access
defined('_JEXEC') or die;

// Create shortcut to parameters.
$params = $this->state->get('params');

// Use the class defined in default_class.php to print the sitemap
$this->displayer->printSitemap();
?>
<script>
jQuery(function($){
	$('.znak_1').click(function(){
		p = $(this).parent();
		$('.level_1', p).toggle();
		$(this).toggleClass('checked');
		$('.link-source:first', p).toggleClass('checked');
	});
	$('.znak_2').click(function(){
		p = $(this).parent();
		$('.level_2', p).toggle();
		$(this).toggleClass('checked');
		$('.link-source:first', p).toggleClass('checked');
	});
});
</script>