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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['title']          = array(
	'Title',
	'Please enter a name for the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['root']           = array(
	'Root item type',
	'Please choose which is the root item type.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['include_root']   = array(
	'Include the root item in the menu',
	'Choose if you wan\'t the root item in the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['provider']       = array(
	'Active providers',
	'Please choose the providers for the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['item_condition'] = array(
	'Item condition',
	'Please choose the condition for the menu items. These condition will completely hide items and all of its children from the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['link_condition'] = array(
	'Item link condition',
	'Please choose the condition for the menu items links. These condition will hide items links from the menu, but children will be shown.'
);

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['menu_legend']      = 'Menu';
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['root_legend']      = 'Root settings';
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['provider_legend']  = 'Provider settings';
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['condition_legend'] = 'Condition settings';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['new']        = array(
	'New menu',
	'Create a new menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['edit']       = array(
	'Edit menu',
	'Edit the menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['copy']       = array(
	'Duplicate menu',
	'Duplicate the menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['delete']     = array(
	'Delete menu',
	'Delete menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['show']       = array(
	'Menu details',
	'Show details of menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['providers']  = array(
	'Manage providers\'s',
	'Manage the provider configurations.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['conditions'] = array(
	'Manage condition\'s',
	'Manage the menu item condition.'
);
