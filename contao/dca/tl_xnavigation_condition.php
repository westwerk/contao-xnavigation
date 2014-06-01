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


\Controller::loadLanguageFile('xnavigation_condition');
\Controller::loadLanguageFile('xnavigation_provider');


/**
 * Table tl_xnavigation_condition
 */
$GLOBALS['TL_DCA']['tl_xnavigation_condition'] = array
(

	// Config
	'config'          => array
	(
		'dataContainer'    => 'Table',
		'enableVersioning' => true,
		'sql'              => array
		(
			'keys' => array
			(
				'id'   => 'primary',
				'pid'  => 'index',
				'type' => 'index',
			)
		),
	),
	// List
	'list'            => array
	(
		'sorting'           => array
		(
			'mode'                  => 5,
			'icon'                  => 'system/modules/xnavigation/assets/images/condition.png',
			'paste_button_callback' => array('Bit3\Contao\XNavigation\DataContainer\Condition', 'pasteButton'),
			'panelLayout'           => 'filter',
		),
		'label'             => array
		(
			'fields'         => array('type', 'title'),
			'label_callback' => array('Bit3\Contao\XNavigation\DataContainer\Condition', 'getLabel'),
		),
		'global_operations' => array
		(
			'create_default_condition' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['create_default_condition'],
				'href'       => 'key=create_default_condition',
				'class'      => 'header_new',
				'attributes' => 'onclick="Backend.getScrollOffset();"',
			),
			'menus'                    => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['menus'],
				'href'       => 'table=tl_xnavigation_menu',
				'class'      => 'header_xnavigation_menus',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="m"',
			),
			'providers'                => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['providers'],
				'href'       => 'table=tl_xnavigation_provider',
				'class'      => 'header_xnavigation_providers',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="p"',
			),
			'all'                      => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"',
			),
		),
		'operations'        => array
		(
			'edit'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'copy'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'copyChilds' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['copyChilds'],
				'href'       => 'act=paste&amp;mode=copy&amp;childs=1',
				'icon'       => 'copychilds.gif',
				'attributes' => 'onclick="Backend.getScrollOffset()"',
			),
			'cut'        => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['cut'],
				'href'       => 'act=paste&amp;mode=cut',
				'icon'       => 'cut.gif',
				'attributes' => 'onclick="Backend.getScrollOffset()"',
			),
			'delete'     => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			),
		),
	),
	// Palettes
	'palettes'        => array
	(
		'__selector__' => array('type')
	),
	// MetaPalettes
	'metapalettes'    => array
	(
		'default'        => array
		(
			'condition' => array('type')
		),
		'parent'         => array
		(
			'condition' => array('type', 'title'),
		),
		'and'            => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('invert'),
		),
		'or'             => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('invert'),
		),
		'item_type'           => array
		(
			'condition' => array('type', 'title'),
			'type'      => array('item_type_accepted_type'),
			'settings'  => array('invert'),
		),
		'level'          => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('level_min', 'level_max', 'invert'),
		),
		'member_login'   => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('member_login_accepted_login_status', 'invert'),
		),
		'link'           => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('link_condition_id', 'invert'),
		),
	),
	// Fields
	'fields'          => array
	(
		'id'                                     => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid'                                    => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting'                                => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp'                                 => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'type'                                   => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['type'],
			'inputType' => 'select',
			'filter'    => true,
			'sorting'   => true,
			'flag'      => 11,
			'options'   => array_keys($GLOBALS['XNAVIGATION_CONDITION']),
			'reference' => &$GLOBALS['TL_LANG']['xnavigation_condition'],
			'eval'      => array(
				'mandatory'          => true,
				'chosen'             => true,
				'helpwizard'         => true,
				'includeBlankOption' => true,
				'submitOnChange'     => true,
				'tl_class'           => 'w50'
			),
			'sql'       => "varchar(32) NOT NULL default ''"
		),
		'title'                                  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['title'],
			'inputType' => 'text',
			'search'    => true,
			'sorting'   => true,
			'flag'      => 1,
			'eval'      => array(
				'tl_class'  => 'w50',
				'maxlength' => 255,
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'item_type_accepted_type'                          => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['item_type_accepted_type'],
			'inputType' => 'select',
			'options'   => array_keys($GLOBALS['XNAVIGATION_PROVIDER']),
			'reference' => &$GLOBALS['TL_LANG']['xnavigation_provider'],
			'eval'      => array(
				'tl_class'           => 'w50',
				'includeBlankOption' => true,
				'mandatory'          => true,
			),
			'sql'       => "varchar(64) NOT NULL default ''"
		),
		'level_min'                              => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['level_min'],
			'inputType' => 'text',
			'eval'      => array(
				'tl_class'  => 'w50',
				'maxlength' => 10,
				'rgxp'      => 'digit',
			),
			'sql'       => "char(10) NOT NULL default ''"
		),
		'level_max'                              => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['level_max'],
			'inputType' => 'text',
			'eval'      => array(
				'tl_class'  => 'w50',
				'maxlength' => 10,
				'rgxp'      => 'digit',
			),
			'sql'       => "char(10) NOT NULL default ''"
		),
		'member_login_accepted_login_status'     => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['member_login_accepted_login_status'],
			'inputType' => 'select',
			'options'   => array('logged_in', 'logged_out'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['member_login_accepted_login_statuses'],
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
			),
			'sql'       => "varchar(10) NOT NULL default ''"
		),
		'link_condition_id'                      => array
		(
			'label'            => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['link_condition_id'],
			'inputType'        => 'select',
			'options_callback' => array('Bit3\Contao\XNavigation\DataContainer\OptionsBuilder', 'getConditionOptions'),
			'eval'             => array(
				'includeBlankOption' => true,
				'mandatory'          => true,
				'tl_class'           => 'w50',
			),
			'sql'              => "varchar(10) NOT NULL default ''"
		),
		'invert'                                 => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['invert'],
			'inputType' => 'checkbox',
			'eval'      => array(
				'tl_class' => 'w50 m12',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
	)
);
