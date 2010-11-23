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
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins 
 * @package    xNavigation
 * @license    LGPL 
 * @filesource
 */

if (!isset($GLOBALS['TL_LANG']['tl_page']['sitemap']))
$GLOBALS['TL_LANG']['tl_page']['sitemap']                = array('In der Sitemap zeigen', 'Hier können Sie festlegen, ob die Seite in der Sitemap angezeigt wird.');
$GLOBALS['TL_LANG']['tl_page']['xNavigation']            = array('Im Menü anzeigen', 'Hier können Sie festlegen, ob die Seite im Menü angezeigt wird.');
$GLOBALS['TL_LANG']['tl_page']['xNavigationIncludeArticles']      = array('Artikel im Menü anzeigen', 'Hier können Sie festlegen, ob die Artikel dieser Seite im Menü angezeigt werden.');
$GLOBALS['TL_LANG']['tl_page']['xNavigationIncludeNewsArchives']  = array('News Archiv anzeigen', '..');
$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchives']   = array('News Archiv', '..');
$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchiveFormat'] = array('Archivformat', 'Hier können Sie das Archivformat auswählen.');
$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchiveShowQuantity'] = array('Anzahl der Beiträge anzeigen', 'Die Anzahl der Beiträge jedes Monats anzeigen.');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_page']['xNavigation_legend'] = 'Erweiterte Navigation';
$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchives_legend'] = 'Erweiterte Navigation - News Archive';
$GLOBALS['TL_LANG']['tl_page']['news_day']   = 'Tag';
$GLOBALS['TL_LANG']['tl_page']['news_month'] = 'Monat';
$GLOBALS['TL_LANG']['tl_page']['news_year']  = 'Jahr';
$GLOBALS['TL_LANG']['tl_page']['map_active'] = 'Wenn Menüpunkt aktiv';
?>