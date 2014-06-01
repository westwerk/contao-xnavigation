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
define('EVENT_XNAVIGATION_CREATE_CONDITION', 'xnavigation.create-condition');
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
	'tables'                   => array('tl_xnavigation_menu', 'tl_xnavigation_provider', 'tl_xnavigation_condition'),
	'icon'                     => 'system/modules/xnavigation/assets/images/menu.png',
	'stylesheet'               => 'system/modules/xnavigation/assets/css/backend.css',
	'create_default_condition' => array('Bit3\Contao\XNavigation\DataContainer\Condition', 'createDefault'),
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
$GLOBALS['TL_MODELS']['tl_xnavigation_condition'] = 'Bit3\Contao\XNavigation\Model\ConditionModel';
$GLOBALS['TL_MODELS']['tl_xnavigation_menu']      = 'Bit3\Contao\XNavigation\Model\MenuModel';
$GLOBALS['TL_MODELS']['tl_xnavigation_provider']  = 'Bit3\Contao\XNavigation\Model\ProviderModel';


/**
 * Conditions
 */
$GLOBALS['XNAVIGATION_CONDITION']['and']            = 'Bit3\FlexiTree\Condition\AndCondition';
$GLOBALS['XNAVIGATION_CONDITION']['or']             = 'Bit3\FlexiTree\Condition\OrCondition';
$GLOBALS['XNAVIGATION_CONDITION']['parent']         = 'Bit3\FlexiTree\Condition\ParentCondition';
$GLOBALS['XNAVIGATION_CONDITION']['item_type']      = 'Bit3\FlexiTree\Condition\TypeCondition';
$GLOBALS['XNAVIGATION_CONDITION']['current']        = 'Bit3\FlexiTree\Condition\CurrentCondition';
$GLOBALS['XNAVIGATION_CONDITION']['trail']          = 'Bit3\FlexiTree\Condition\TrailCondition';
$GLOBALS['XNAVIGATION_CONDITION']['level']          = 'Bit3\FlexiTree\Condition\LevelCondition';
$GLOBALS['XNAVIGATION_CONDITION']['member_login']   = 'Bit3\Contao\XNavigation\Condition\MemberLoginCondition';
$GLOBALS['XNAVIGATION_CONDITION']['link']           = 'Bit3\Contao\XNavigation\Condition\LinkCondition';
