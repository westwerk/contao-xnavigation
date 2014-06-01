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
 * Conditions
 */
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['type']                                 = array(
	'Type',
	'Please choose the condition type.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['title']                                = array(
	'Title',
	'Please enter a name for the condition.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['item_type_accepted_type']                        = array(
	'Accepted type',
	'Please choose the accepted type.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['level_min']                            = array(
	'Min level (inclusive)',
	'Please enter the min level that is visible. The levels start at 0 (the root entry).'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['level_max']                            = array(
	'Max level (inclusive)',
	'Please enter the max level that is visible.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_guests_accepted_guests_status']   = array(
	'Accepted status',
	'Please choose the accepted status of the "guests only" flag.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_hide_accepted_hide_status']       = array(
	'Accepted status',
	'Please choose the accepted status of the "hide in menu" flag.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_members_accepted_protected_status']       = array(
	'Accepted status',
	'Please choose the accepted status of the "protected" flag.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_sitemap_accepted_sitemap_status'] = array(
	'Accepted status',
	'Please choose the accepted status of the "show in sitemap" flag.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['member_login_accepted_login_status']   = array(
	'Accepted login status',
	'Please choose the accepted login status.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['invert']                               = array(
	'Invert',
	'Invert the condition.'
);

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['member_login_accepted_login_statuses']['logged_in']     = 'logged in';
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['member_login_accepted_login_statuses']['logged_out']    = 'logged out';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['condition_legend'] = 'Condition';
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['settings_legend']  = 'Settings';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['new']                      = array(
	'New condition',
	'Create a new condition.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['create_default_condition'] = array(
	'Create default',
	'Create a default condition set.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['edit']                     = array(
	'Edit condition',
	'Edit the condition ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['copy']                     = array(
	'Duplicate condition',
	'Duplicate the condition ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['delete']                   = array(
	'Delete condition',
	'Delete condition ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['show']                     = array(
	'Condition details',
	'Show details of condition ID %s'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['menus']                    = array(
	'Manage menu\'s',
	'Manage the menu configurations.'
);
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['providers']                = array(
	'Manage providers\'s',
	'Manage the provider configurations.'
);

/**
 * Messages
 */
$GLOBALS['TL_LANG']['tl_xnavigation_condition']['default_created'] = 'New default condition <em>%s</em> created.';
