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


$this->loadLanguageFile('xnavigation_condition');


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
			'menus'     => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['menus'],
				'href'       => 'table=tl_xnavigation_menu',
				'class'      => 'header_xnavigation_menus',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="m"',
			),
			'providers' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['providers'],
				'href'       => 'table=tl_xnavigation_provider',
				'class'      => 'header_xnavigation_providers',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="p"',
			),
			'all'       => array
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
		'level'          => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('level_min', 'level_max', 'invert'),
		),
		'page_id'        => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('page_id_page_id', 'invert'),
		),
		'page_guests'    => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('page_guests_accepted_guests_status', 'invert'),
		),
		'page_members'   => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('page_members_accepted_protected_status', 'invert'),
		),
		'page_hide'      => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('page_hide_accepted_hide_status', 'invert'),
		),
		'page_sitemap'   => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('page_sitemap_accepted_sitemap_status', 'invert'),
		),
		'page_published' => array
		(
			'condition' => array('type', 'title'),
			'settings'  => array('invert'),
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
	// MetaSubpalettes
	'metasubpalettes' => array
	(),
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
		'page_id_page_id'                        => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_id_page_id'],
			'inputType' => 'pageTree',
			'sql'       => "int(10) NOT NULL default '0'"
		),
		'page_guests_accepted_guests_status'     => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_guests_accepted_guests_status'],
			'inputType' => 'select',
			'options'   => array('', '1'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_guests_accepted_guests_statuses'],
			'eval'      => array(
				'tl_class' => 'w50',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'page_members_accepted_protected_status' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_members_accepted_protected_status'],
			'inputType' => 'select',
			'options'   => array('', '1'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_members_accepted_protected_statuses'],
			'eval'      => array(
				'tl_class' => 'w50',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'page_hide_accepted_hide_status'         => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_hide_accepted_hide_status'],
			'inputType' => 'select',
			'options'   => array('', '1'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_hide_accepted_hide_statuses'],
			'eval'      => array(
				'tl_class' => 'w50',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'page_sitemap_accepted_sitemap_status'   => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_sitemap_accepted_sitemap_status'],
			'inputType' => 'checkbox',
			'options'   => array('map_default', 'map_always', 'map_never'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['page_sitemap_accepted_sitemap_statuses'],
			'eval'      => array(
				'mandatory' => true,
				'multiple'  => true,
			),
			'sql'       => "varchar(255) NOT NULL default ''"
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
