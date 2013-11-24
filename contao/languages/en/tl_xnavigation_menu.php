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
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['title']        = array(
	'Title',
	'Please enter a name for the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['root']         = array(
	'Root item type',
	'Please choose which is the root item type.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_root']    = array(
	'Root page',
	'Please select the root page for the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_root_level'] = array(
	'Start level',
	'Please enter the start level of the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_root_id'] = array(
	'Custom root page',
	'Please select the custom root page for the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['include_root'] = array(
	'Include the root item in the menu',
	'Choose if you wan\'t the root item in the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['provider']     = array(
	'Active providers',
	'Please choose the providers for the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['item_filter']       = array(
	'Item filter',
	'Please choose the filters for the menu items. These filters will completely hide items and all of its children from the menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['link_filter']       = array(
	'Item link filter',
	'Please choose the filters for the menu items links. These filters will hide items links from the menu, but children will be shown.'
);

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['roots']['page']         = array('Page');
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_roots']['root']    = array(
	'Root page',
	'Use the root page of the website as start point.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_roots']['parent']  = array(
	'Parent page',
	'Use the parent page of the currently active page as start point.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_roots']['current'] = array(
	'Current page',
	'Use the current active page as start point.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_roots']['level'] = array(
	'Specific level',
	'Define a level in the trail as start point, beginning by 0.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_roots']['custom']  = array(
	'Custom page',
	'Use a custom selected page as start point.'
);

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['menu_legend']     = 'Menu';
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['root_legend']     = 'Root settings';
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['provider_legend'] = 'Provider settings';
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['filter_legend']   = 'Filter settings';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['new']       = array(
	'New menu',
	'Create a new menu.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['edit']      = array(
	'Edit menu',
	'Edit the menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['copy']      = array(
	'Duplicate menu',
	'Duplicate the menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['delete']    = array(
	'Delete menu',
	'Delete menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['show']      = array(
	'Menu details',
	'Show details of menu ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['providers'] = array(
	'Manage providers\'s',
	'Manage the provider configurations.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_menu']['filters']   = array(
	'Manage filter\'s',
	'Manage the menu item filter.'
);
