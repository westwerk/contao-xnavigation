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
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['type']                                 = array(
	'Type',
	'Please choose the filter type.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['title']                                = array(
	'Title',
	'Please enter a name for the filter.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['level_min']                            = array(
	'Min level (inclusive)',
	'Please enter the min level that is visible. The levels start at 0 (the root entry).'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['level_max']                            = array(
	'Max level (inclusive)',
	'Please enter the max level that is visible.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_guests_status']   = array(
	'Accepted status',
	'Please choose the accepted status of the "guests only" flag.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_login_status']    = array(
	'Accepted login status',
	'Please choose the accepted login status.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_hide_accepted_hide_status']       = array(
	'Accepted status',
	'Please choose the accepted status of the "hide in menu" flag.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_sitemap_accepted_sitemap_status'] = array(
	'Accepted status',
	'Please choose the accepted status of the "show in sitemap" flag.'
);

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_guests_statuses']['']              = 'not selected';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_guests_statuses']['1']             = 'selected';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_login_statuses']['logged_in']      = 'logged in';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_login_statuses']['logged_out']     = 'logged out';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_members_accepted_protected_status']['']            = 'not selected';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_members_accepted_protected_status']['1']           = 'selected';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_hide_accepted_hide_statuses']['']                  = 'not selected';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_hide_accepted_hide_statuses']['1']                 = 'selected';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_sitemap_accepted_sitemap_statuses']['map_default'] = 'default';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_sitemap_accepted_sitemap_statuses']['map_always']  = 'always in sitemap';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_sitemap_accepted_sitemap_statuses']['map_never']   = 'never in sitemap';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['filter_legend']   = 'Filter';
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['settings_legend'] = 'Settings';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['new']       = array(
	'New filter',
	'Create a new filter.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['edit']      = array(
	'Edit filter',
	'Edit the filter ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['copy']      = array(
	'Duplicate filter',
	'Duplicate the filter ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['delete']    = array(
	'Delete filter',
	'Delete filter ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['show']      = array(
	'Filter details',
	'Show details of filter ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['menus']     = array(
	'Manage menu\'s',
	'Manage the menu configurations.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_filter']['providers'] = array(
	'Manage providers\'s',
	'Manage the provider configurations.'
);
