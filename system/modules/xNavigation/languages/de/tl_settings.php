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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['baseDNS']   = array('Basis Domainname', 'Hier können Sie den Basis Domainnamen angeben, der genutzt wird, falls es nicht möglich ist den Domainnamen dynamisch zu bestimmen. Dies ist z.B. beim generieren des Newsletters nicht möglich.');
$GLOBALS['TL_LANG']['tl_settings']['secureDNS'] = array('Gesicherte Domain', 'Hier können Sie angeben, ob geschütze URLs generiert werden sollen.');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_settings']['dns_legend'] = 'DNS Einstellungen';


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_settings']['auto']     = 'Automatisch';
$GLOBALS['TL_LANG']['tl_settings']['auto']     = 'Automatisch';
$GLOBALS['TL_LANG']['tl_settings']['insecure'] = 'Reguläre HTTP Links erzeugen';
$GLOBALS['TL_LANG']['tl_settings']['secure']   = 'Gesicherte HTTPs Links erzeugen';

?>