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
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['metapalettes']['xnavigation_menu'] = array(
	'title'       => array('name', 'headline', 'type'),
	'xnavigation' => array('xnavigation_menu', 'xnavigation_template'),
	'protected'   => array(':hide', 'protected'),
	'expert'      => array(':hide', 'guests', 'cssID', 'space'),
);

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['xnavigation_menu'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_module']['xnavigation_menu'],
	'exclude'    => true,
	'filter'     => true,
	'inputType'  => 'select',
	'foreignKey' => 'tl_xnavigation_menu.title',
	'eval'       => array(
		'mandatory'          => true,
		'includeBlankOption' => true,
		'chosen'             => true,
		'tl_class'           => 'w50'
	),
	'sql'        => "int(10) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['xnavigation_template'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['xnavigation_template'],
	'default'   => 'xnavigation/xnav_default.html5.twig',
	'exclude'   => true,
	'inputType' => 'select',
	'options'   => ContaoTwigOptionsBuilder::getTemplateOptions('xnav_'),
	'eval'      => array(
		'mandatory'          => true,
		'includeBlankOption' => true,
		'chosen'             => true,
		'tl_class'           => 'w50'
	),
	'sql'       => "varchar(255) NOT NULL default ''"
);
