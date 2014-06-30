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
 * Table tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['metapalettes']['xnavigation_menu'] = array(
	'title'       => array('type', 'headline'),
	'xnavigation' => array('xnavigation_menu', 'xnavigation_template'),
	'protected'   => array(':hide', 'protected'),
	'expert'      => array(':hide', 'guests', 'cssID', 'space'),
	'invisible'   => array(':hide', 'invisible', 'start', 'stop'),
);

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['xnavigation_menu'] = array
(
	'label'      => &$GLOBALS['TL_LANG']['tl_content']['xnavigation_menu'],
	'exclude'    => true,
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

$GLOBALS['TL_DCA']['tl_content']['fields']['xnavigation_template'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_content']['xnavigation_template'],
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
