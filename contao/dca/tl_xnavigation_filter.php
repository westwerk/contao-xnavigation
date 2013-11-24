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


$this->loadLanguageFile('xnavigation_filter');


/**
 * Table tl_xnavigation_filter
 */
$GLOBALS['TL_DCA']['tl_xnavigation_filter'] = array
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
				'id' => 'primary',
			)
		),
	),
	// List
	'list'            => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'flag'        => 1,
			'fields'      => array('type', 'title'),
			'panelLayout' => 'filter;sort,limit',
		),
		'label'             => array
		(
			'fields' => array('title', 'type'),
			'format' => '%s <span style="color:#b3b3b3;padding-left:3px"> &ndash; %s</span>'
		),
		'global_operations' => array
		(
			'menus'     => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['menus'],
				'href'       => 'table=tl_xnavigation_menu',
				'class'      => 'header_xnavigation_menus',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="m"',
			),
			'providers' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['providers'],
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
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'copy'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['show'],
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
		'default'      => array
		(
			'filter' => array('type', 'title')
		),
		'level'        => array
		(
			'filter'   => array('type', 'title'),
			'settings' => array('level_min', 'level_max'),
		),
		'page_guests'  => array
		(
			'filter'   => array('type', 'title'),
			'settings' => array('page_guests_accepted_guests_status', 'page_guests_accepted_login_status'),
		),
		'page_members' => array
		(
			'filter'   => array('type', 'title'),
			'settings' => array('page_members_accepted_protected_status'),
		),
		'page_hide'    => array
		(
			'filter'   => array('type', 'title'),
			'settings' => array('page_hide_accepted_hide_status'),
		),
		'page_sitemap' => array
		(
			'filter'   => array('type', 'title'),
			'settings' => array('page_sitemap_accepted_sitemap_status'),
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
		'tstamp'                                 => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'type'                                   => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['type'],
			'inputType' => 'select',
			'filter'    => true,
			'sorting'   => true,
			'flag'      => 11,
			'options'   => array_keys($GLOBALS['XNAVIGATION_FILTER']),
			'reference' => &$GLOBALS['TL_LANG']['xnavigation_filter'],
			'eval'      => array(
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
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['title'],
			'inputType' => 'text',
			'search'    => true,
			'sorting'   => true,
			'flag'      => 1,
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
				'maxlength' => 255,
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'level_min'                              => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['level_min'],
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
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['level_max'],
			'inputType' => 'text',
			'eval'      => array(
				'tl_class'  => 'w50',
				'maxlength' => 10,
				'rgxp'      => 'digit',
			),
			'sql'       => "char(10) NOT NULL default ''"
		),
		'page_guests_accepted_guests_status'     => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_guests_status'],
			'inputType' => 'select',
			'options'   => array('', '1'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_guests_statuses'],
			'eval'      => array(
				'tl_class' => 'w50',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'page_guests_accepted_login_status'      => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_login_status'],
			'inputType' => 'select',
			'options'   => array('logged_in', 'logged_out'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_guests_accepted_login_statuses'],
			'eval'      => array(
				'includeBlankOption' => true,
				'tl_class'           => 'w50',
			),
			'sql'       => "varchar(10) NOT NULL default ''"
		),
		'page_members_accepted_protected_status' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_members_accepted_protected_status'],
			'inputType' => 'select',
			'options'   => array('', '1'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_members_accepted_protected_statuses'],
			'eval'      => array(
				'tl_class' => 'w50',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'page_hide_accepted_hide_status'         => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_hide_accepted_hide_status'],
			'inputType' => 'select',
			'options'   => array('', '1'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_hide_accepted_hide_statuses'],
			'eval'      => array(
				'tl_class' => 'w50',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'page_sitemap_accepted_sitemap_status'   => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_sitemap_accepted_sitemap_status'],
			'inputType' => 'checkbox',
			'options'   => array('map_default', 'map_always', 'map_never'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_filter']['page_sitemap_accepted_sitemap_statuses'],
			'eval'      => array(
				'multiple' => true,
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
	)
);
