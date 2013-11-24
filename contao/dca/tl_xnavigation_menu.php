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
 * Table tl_xnavigation_menu
 */
$GLOBALS['TL_DCA']['tl_xnavigation_menu'] = array
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
			'mode'        => 1,
			'flag'        => 1,
			'fields'      => array('title'),
			'panelLayout' => 'filter;limit',
		),
		'label'             => array
		(
			'fields' => array('title'),
			'format' => '%s'
		),
		'global_operations' => array
		(
			'providers' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['providers'],
				'href'       => 'table=tl_xnavigation_provider',
				'class'      => 'header_xnavigation_providers',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="p"',
			),
			'filters'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['filters'],
				'href'       => 'table=tl_xnavigation_filter',
				'class'      => 'header_xnavigation_filters',
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
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'copy'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			),
		),
	),
	// Palettes
	'palettes'        => array
	(
		'__selector__' => array('root', 'page_root')
	),
	// MetaPalettes
	'metapalettes'    => array
	(
		'default' => array
		(
			'menu'     => array('title'),
			'root'     => array('root', 'include_root'),
			'provider' => array('provider'),
			'filter'   => array('item_filter', 'link_filter'),
		),
	),
	// MetaSubpalettes
	'metasubpalettes' => array
	(
		'root_page'        => array('page_root'),
		'page_root_level'  => array('page_root_level'),
		'page_root_custom' => array('page_root_id'),
	),
	// Fields
	'fields'          => array
	(
		'id'           => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp'       => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'title'        => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['title'],
			'inputType' => 'text',
			'search'    => true,
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
				'maxlength' => 255,
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'root'         => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['root'],
			'inputType' => 'select',
			'filter'    => true,
			'options'   => array('page'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['roots'],
			'eval'      => array(
				'mandatory'          => true,
				'includeBlankOption' => true,
				'submitOnChange'     => true,
				'helpwizard'         => true,
				'tl_class'           => 'w50',
			),
			'sql'       => "char(10) NOT NULL default ''"
		),
		'page_root'    => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_root'],
			'default'   => 'root',
			'inputType' => 'select',
			'filter'    => true,
			'options'   => array('root', 'parent', 'current', 'level', 'custom'),
			'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_roots'],
			'eval'      => array(
				'mandatory'      => true,
				'submitOnChange' => true,
				'helpwizard'     => true,
				'tl_class'       => 'w50',
			),
			'sql'       => "char(10) NOT NULL default ''"
		),
		'page_root_level' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_root_level'],
			'default'   => '1',
			'inputType' => 'text',
			'eval'      => array(
				'mandatory' => true,
				'rgxp'      => 'digit',
				'tl_class'  => 'clr',
			),
			'sql'       => "int(10) NOT NULL default '0'"
		),
		'page_root_id' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['page_root_id'],
			'inputType' => 'pageTree',
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'clr',
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'include_root' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['include_root'],
			'inputType' => 'checkbox',
			'eval'      => array(
				'tl_class'  => 'm12 clr',
			),
			'sql'       => "char(1) NOT NULL default ''"
		),
		'provider'     => array
		(
			'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['provider'],
			'inputType'  => 'checkbox',
			'foreignKey' => 'tl_xnavigation_provider.title',
			'eval'       => array(
				'multiple' => true,
			),
			'sql'        => "text NULL"
		),
		'item_filter'       => array
		(
			'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['item_filter'],
			'inputType'  => 'checkboxWizard',
			'foreignKey' => 'tl_xnavigation_filter.title',
			'eval'       => array(
				'multiple' => true,
			),
			'sql'        => "text NULL"
		),
		'link_filter'       => array
		(
			'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_menu']['link_filter'],
			'inputType'  => 'checkboxWizard',
			'foreignKey' => 'tl_xnavigation_filter.title',
			'eval'       => array(
				'multiple' => true,
			),
			'sql'        => "text NULL"
		),
	)
);
