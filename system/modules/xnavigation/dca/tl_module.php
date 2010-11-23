<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005-2009 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  InfinityLabs - Olck & Lins GbR - 2009-2010
 * @author     Tristan Lins <tristan.lins@infinitylabs.de>
 * @package    xNavigation
 * @license    LGPL 
 * @filesource
 */


/**
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['xNavigation'] = '{title_legend},name,headline,type;{nav_legend},levelOffset,showLevel,hardLevel,showProtected;{reference_legend:hide},defineRoot;{template_legend:hide},navigationTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['xSitemap'] = '{title_legend},name,headline,type;{nav_legend},includeRoot,showProtected,showHidden;{reference_legend:hide},rootPage;{template_legend:hide},navigationTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['hardLevel'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hardLevel'],
	'default'                 => '0',
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>5, 'rgxp'=>'digit', 'tl_class'=>'w50')
);

?>