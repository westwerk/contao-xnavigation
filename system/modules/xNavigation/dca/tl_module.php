<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xNavigation
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'includeFullHierarchy';
$GLOBALS['TL_DCA']['tl_module']['palettes']['xNavigation']          = '{title_legend},name,headline,type;{nav_legend},levelOffset,showLevel,hardLevel,showProtected;{reference_legend:hide},defineRoot;{template_legend:hide},navigationTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['xSitemap']             = '{title_legend},name,headline,type;{nav_legend},includeRoot,includeFullHierarchy,showProtected;{reference_legend:hide},rootPage;{template_legend:hide},navigationTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['includeFullHierarchy'] = '{title_legend},name,headline,type;{nav_legend},includeFullHierarchy,showProtected;{reference_legend:hide},rootPage;{template_legend:hide},navigationTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['hardLevel'] = array
(
	'label'       => &$GLOBALS['TL_LANG']['tl_module']['hardLevel'],
	'default'     => '0',
	'exclude'     => true,
	'inputType'   => 'text',
	'eval'        => array('maxlength'=>5, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['includeFullHierarchy'] = array
(
	'label'       => &$GLOBALS['TL_LANG']['tl_module']['includeFullHierarchy'],
	'exclude'     => true,
	'inputType'   => 'checkbox',
	'eval'        => array('submitOnChange'=>true, 'tl_class'=>'w50')
);

?>