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


$this->loadLanguageFile('xnavigation_provider');


/**
 * Table tl_xnavigation_provider
 */
$GLOBALS['TL_DCA']['tl_xnavigation_provider'] = array
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
			'menus'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['menus'],
				'href'       => 'table=tl_xnavigation_menu',
				'class'      => 'header_xnavigation_menus',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="m"',
			),
			'conditions' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['conditions'],
				'href'       => 'table=tl_xnavigation_condition',
				'class'      => 'header_xnavigation_conditions',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="p"',
			),
			'all'     => array
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
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'copy'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['copy'],
				'href'  => 'act=copy',
				'icon'  => 'copy.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['show'],
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
		'default' => array
		(
			'provider' => array('type', 'title')
		),
	),
	// Fields
	'fields'          => array
	(
		'id'                       => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp'                   => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		'type'                     => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['type'],
			'inputType' => 'select',
			'filter'    => true,
			'options'   => array_keys($GLOBALS['XNAVIGATION_PROVIDER']),
			'reference' => &$GLOBALS['TL_LANG']['xnavigation_provider'],
			'eval'      => array(
				'chosen'             => true,
				'includeBlankOption' => true,
				'submitOnChange'     => true,
				'tl_class'           => 'w50'
			),
			'sql'       => "varchar(32) NOT NULL default ''"
		),
		'title'                    => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['title'],
			'inputType' => 'text',
			'search'    => true,
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
				'maxlength' => 255,
			),
			'sql'       => "varchar(255) NOT NULL default ''"
		),
	)
);
