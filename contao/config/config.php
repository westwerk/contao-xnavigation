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
 * Event names
 */
define('EVENT_XNAVIGATION_CREATE_VOTER', 'xnavigation.create-voter');
define('EVENT_XNAVIGATION_CREATE_PROVIDER', 'xnavigation.create-provider');
define('EVENT_XNAVIGATION_EVALUATE_ROOT', 'xnavigation.evaluate-root');


/**
 * Event listener
 */
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Bit3\Contao\XNavigation\DefaultSubscriber';


/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['design']['xnavigation'] = array(
	'tables'     => array('tl_xnavigation_menu', 'tl_xnavigation_provider', 'tl_xnavigation_filter'),
	'icon'       => 'system/modules/xnavigation/assets/images/menu.png',
	'stylesheet' => 'system/modules/xnavigation/assets/css/backend.css',
);


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['navigationMenu']['xnavigation_menu'] = 'Bit3\Contao\XNavigation\Hybrid\Menu';


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['navigation']['xnavigation_menu'] = 'Bit3\Contao\XNavigation\Hybrid\Menu';


/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_xnavigation_filter']   = 'Bit3\Contao\XNavigation\Model\FilterModel';
$GLOBALS['TL_MODELS']['tl_xnavigation_menu']     = 'Bit3\Contao\XNavigation\Model\MenuModel';
$GLOBALS['TL_MODELS']['tl_xnavigation_provider'] = 'Bit3\Contao\XNavigation\Model\ProviderModel';


/**
 * Provider
 */
$GLOBALS['XNAVIGATION_PROVIDER']['page'] = 'Bit3\Contao\XNavigation\Provider\PageProvider';


/**
 * Filter
 */
$GLOBALS['XNAVIGATION_FILTER']['current']        = 'Bit3\FlexiTree\Matcher\Voter\CurrentVoter';
$GLOBALS['XNAVIGATION_FILTER']['trail']          = 'Bit3\FlexiTree\Matcher\Voter\TrailVoter';
$GLOBALS['XNAVIGATION_FILTER']['level']          = 'Bit3\FlexiTree\Matcher\Voter\LevelVoter';
$GLOBALS['XNAVIGATION_FILTER']['page_guests']    = 'Bit3\Contao\XNavigation\Voter\PageGuestsVoter';
$GLOBALS['XNAVIGATION_FILTER']['page_protected'] = 'Bit3\Contao\XNavigation\Voter\PageProtectedVoter';
$GLOBALS['XNAVIGATION_FILTER']['page_hide']      = 'Bit3\Contao\XNavigation\Voter\PageHideVoter';
$GLOBALS['XNAVIGATION_FILTER']['page_sitemap']   = 'Bit3\Contao\XNavigation\Voter\PageSitemapVoter';
