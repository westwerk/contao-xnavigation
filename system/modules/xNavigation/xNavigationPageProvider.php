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
 * Class xNavigationPageProvider
 * 
 * xNavigation provider to generate regular page items.
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xNavigation
 */
class xNavigationPageProvider extends xNavigationProvider
{
	public function __construct() {
		parent::__construct();
		$this->import('Database');
	}
	
	public function generateItems(ModuleXNavigation &$objXNavigation, Database_Result $objCurrentPage, $blnActive, &$arrItems, $arrGroups, $intLevel, $intMaxLevel, $intHardLevel) 
	{
		global $objPage;
		
		$time = time();
		
		// Get all active subpages
		$stmtSubpages = $this->Database->prepare("
			SELECT
				p1.*, 
				(
					SELECT COUNT(*)
					FROM tl_page p2
					WHERE
							p2.pid=p1.id
						AND p2.type!='root'
						AND p2.type!='error_403'
						AND p2.type!='error_404'"
						. ((FE_USER_LOGGED_IN && !BE_USER_LOGGED_IN) ? " AND p2.guests!=1" : "")
						. (!BE_USER_LOGGED_IN ? " AND (p2.start='' OR p2.start<".$time.") AND (p2.stop='' OR p2.stop>".$time.") AND p2.published=1" : "") . "
				) AS subpages,
				(
					SELECT COUNT(*)
					FROM tl_page p2
					WHERE
							p2.pid=p1.id
						AND p2.type!='root'
						AND p2.type!='error_403'
						AND p2.type!='error_404'"
						. ((FE_USER_LOGGED_IN && !BE_USER_LOGGED_IN) ? " AND p2.guests!=1" : "")
						. (!BE_USER_LOGGED_IN ? " AND (p2.start='' OR p2.start<".$time.") AND (p2.stop='' OR p2.stop>".$time.") AND p2.published=1" : "") . "
						AND hide != 1 AND menu_visibility != 'map_never'
				) AS vsubpages
			FROM
				tl_page p1
			WHERE
					p1.pid=?"
				. ($objXNavigation instanceof ModuleXSitemap ? "" : " AND p1.type!='root' ") . "
				AND p1.type!='error_403'
				AND p1.type!='error_404'"
				. ((FE_USER_LOGGED_IN && !BE_USER_LOGGED_IN && !$this->showProtected) ? " AND p1.guests!=1" : "")
				. (!BE_USER_LOGGED_IN ? " AND (p1.start='' OR p1.start<".$time.") AND (p1.stop='' OR p1.stop>".$time.") AND p1.published=1" : "") . "
			ORDER BY
				p1.sorting");
		$objSubpages = $stmtSubpages->execute($objCurrentPage->id);
		
		$n = 0;
		// Browse subpages
		while($objSubpages->next())
		{
			// Skip hidden pages
			if (/* non sitemap navigation */
				!(	!($objXNavigation instanceof ModuleXSitemap)
				&&  (	$objSubpages->menu_visibility == 'map_never'
					||  $objSubpages->hide
					||  (	$intMaxLevel > 0
						&&  $intMaxLevel < $intLevel
						&&  !(	$objPage->id == $objSubpages->id
							||  in_array($objSubpages->id, $objPage->trail)
							||  in_array($objCurrentPage->id, $objPage->trail))
						||  $intHardLevel > 0
						&&  $intHardLevel < $intLevel)
					&&  $objSubpages->menu_visibility != 'map_always')
				/* sitemap navigation */
				||  $objXNavigation instanceof ModuleXSitemap
				&&  $objSubpages->sitemap == 'map_never'))
			{
				$strSubItems = '';
				$_groups = deserialize($objSubpages->groups);

				// Do not show protected pages unless a back end or front end user is logged in
				if (	!strlen($objSubpages->protected)
					||  BE_USER_LOGGED_IN
					||  (	!is_array($_groups)
						&&  FE_USER_LOGGED_IN)
					||  (	is_array($_groups)
						&&  count(array_intersect($arrGroups, $_groups)))
					||  $this->showProtected
					||  (	$objXNavigation instanceof ModuleSitemap
						&&  $objSubpages->sitemap == 'map_always'))
				{
					// Check whether there will be subpages
					$strSubItems = $objXNavigation->renderXNavigation($objSubpages, $intLevel+1);

					// Get href
					switch ($objSubpages->type)
					{
						case 'redirect':
							$href = $objSubpages->url;

							if (strncasecmp($href, 'mailto:', 7) === 0)
							{
								$this->import('String');
								$href = $this->String->encodeEmail($href);
							}
							break;

						case 'forward':
							if (!$objSubpages->jumpTo)
							{
								$objNext = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE pid=? AND type='regular'" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY sorting")
														->limit(1)
														->execute($objSubpages->id);
							}
							else
							{
								$objNext = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
														->limit(1)
														->execute($objSubpages->jumpTo);
							}

							if ($objNext->numRows)
							{
								$href = $this->generateFrontendUrl($objNext->fetchAssoc());
								break;
							}
							// DO NOT ADD A break; STATEMENT

						default:
							$href = $this->generateFrontendUrl($objSubpages->row());
							break;
					}

					if ($strSubItems === true) {
						$hassubmenu = true;
						$strSubItems = '';
					} else {
						$hassubmenu = false;
					}

					// Active page
					if (	(	$objPage->id == $objSubpages->id
							||  $objSubpages->type == 'forward'
							&&  $objPage->id == $objSubpages->jumpTo)
						&&  !($objXNavigation instanceof ModuleXSitemap)
						&&  !$this->Input->get('articles'))
					{
						$strClass = 'page' . (strlen($strSubItems) ? ' submenu' : '') . ($hassubmenu ? ' hassubmenu' : '') . (strlen($objSubpages->cssClass) ? ' ' . $objSubpages->cssClass : '');
						$row = $objSubpages->row();

						$row['isActive'] = true;
						$row['subitems'] = $strSubItems;
						$row['class'] = (strlen($strClass) ? $strClass : '');
						$row['pageTitle'] = specialchars($objSubpages->pageTitle);
						$row['title'] = specialchars($objSubpages->title);
						$row['link'] = $objSubpages->title;
						$row['href'] = $href;
						$row['alias'] = $objSubpages->alias;
						$row['nofollow'] = (strncmp($objSubpages->robots, 'noindex', 7) === 0);
						$row['target'] = (($objSubpages->type == 'redirect' && $objSubpages->target) ? LINK_NEW_WINDOW : '');
						$row['description'] = str_replace(array("\n", "\r"), array(' ' , ''), $objSubpages->description);
						$row['accesskey'] = $objSubpages->accesskey;
						$row['tabindex'] = $objSubpages->tabindex;
						$row['subpages'] = $objSubpages->subpages;
						$row['itemtype'] = 'page';

						$arrItems[] = $row;
					}

					// Regular page
					else
					{
						$strClass = 'page' . (strlen($strSubItems) ? ' submenu' : '') . ($hassubmenu ? ' hassubmenu' : '') . (strlen($objSubpages->cssClass) ? ' ' . $objSubpages->cssClass : '') . (in_array($objSubpages->id, $objPage->trail) ? ' trail' : '');

						$row = $objSubpages->row();

						$row['isActive'] = false;
						$row['subitems'] = $strSubItems;
						$row['class'] = (strlen($strClass) ? $strClass : '');
						$row['pageTitle'] = specialchars($objSubpages->pageTitle);
						$row['title'] = specialchars($objSubpages->title);
						$row['link'] = $objSubpages->title;
						$row['href'] = $href;
						$row['alias'] = $objSubpages->alias;
						$row['nofollow'] = (strncmp($objSubpages->robots, 'noindex', 7) === 0);
						$row['target'] = (($objSubpages->type == 'redirect' && $objSubpages->target) ? LINK_NEW_WINDOW : '');
						$row['description'] = str_replace(array("\n", "\r"), array(' ' , ''), $objSubpages->description);
						$row['accesskey'] = $objSubpages->accesskey;
						$row['tabindex'] = $objSubpages->tabindex;
						$row['subpages'] = $objSubpages->subpages;
						$row['itemtype'] = 'page';

						$arrItems[] = $row;
					}
				}
			} else if (
				/* non sitemap navigation */
				!(	!($objXNavigation instanceof ModuleXSitemap)
				&&  (	$objSubpages->menu_visibility == 'map_never'
					||  $objSubpages->hide
					||  (	$this->hardLevel > 0
						&&  $this->hardLevel < $level)
					&&  $objSubpages->menu_visibility != 'map_always')
				/* sitemap navigation */
				||  $objXNavigation instanceof ModuleXSitemap
				&&  $objSubpages->sitemap == 'map_never'))
			{
				$n ++;
			}
		}
		return $n > 0;
	}
}
?>