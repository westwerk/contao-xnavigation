<?php

/**
 * xNavigation - Highly extendable and flexible navigation module for the Contao Open Source CMS
 *
 * Copyright (C) 2013 bit3 UG <http://bit3.de>
 *
 * @package    xNavigation
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @link       http://www.themeplus.de
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Provider
 */
$GLOBALS['TL_LANG']['xnavigation_condition']['and']      = array(
	'AND',
	'AND conjunction over several conditions.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['or']      = array(
	'OR',
	'OR conjunction over several conditions.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['current']      = array(
	'Active item',
	'Show only the active pages.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['trail']        = array(
	'Trail item',
	'Show only the pages in the path to any active page.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['level']        = array(
	'Depth',
	'Show only pages with a specific depth.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['page_guests']  = array(
	'Page guests only',
	'Filter pages by their "guests only" status.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['page_protected'] = array(
	'Page protected',
	'Filter pages by their "protected" status.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['page_hide']    = array(
	'Page hide in menu',
	'Filter pages by their "hide in menu" status.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['page_sitemap'] = array(
	'Page shown in sitemap',
	'Filter pages by their "shown in sitemap" status.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['page_published'] = array(
	'Page published',
	'Filter pages by their "published" status.'
);
$GLOBALS['TL_LANG']['xnavigation_condition']['member_login'] = array(
	'Member login status',
	'Filter items depending if the user is logged in or not.'
);
