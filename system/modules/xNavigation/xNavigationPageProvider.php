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
	
	public function generateItem(Database_Result $objCurrentPage,
		ModuleXNavigation &$objXNavigation,
		Database_Result $objParentPage,
		$blnParentPageActive,
		$blnParentPageTrail,
		&$arrItems,
		$intLevel,
		$intMaxLevel,
		$intHardLevel)
	{
		global $objPage;
		$time = time();
		
		$arrGroups = array();

		// Get all groups of the current front end user
		if (FE_USER_LOGGED_IN)
		{
			$this->import('FrontendUser', 'User');
			$arrGroups = $this->User->groups;
		}
		
		$intCountedChildren = 0;
		// Skip hidden pages
		if (/* non sitemap navigation */
			!(	!($objXNavigation instanceof ModuleXSitemap)
			&&  (	$objCurrentPage->menu_visibility == 'map_never'
				||  $objCurrentPage->hide
				||  (	$intMaxLevel > 0
					&&  $intMaxLevel < $intLevel
					&&  !(	$objPage->id == $objCurrentPage->id
						||  in_array($objCurrentPage->id, $objPage->trail)
						||  in_array($objParentPage->id, $objPage->trail))
					||  $intHardLevel > 0
					&&  $intHardLevel < $intLevel)
				&&  $objCurrentPage->menu_visibility != 'map_always')
			/* sitemap navigation */
			||  $objXNavigation instanceof ModuleXSitemap
			&&  $objCurrentPage->sitemap == 'map_never'))
		{
			$strSubItems = '';
			$_groups = deserialize($objCurrentPage->groups);

			// Do not show protected pages unless a back end or front end user is logged in
			if (	!strlen($objCurrentPage->protected)
				||  BE_USER_LOGGED_IN
				||  (	!is_array($_groups)
					&&  FE_USER_LOGGED_IN)
				||  (	is_array($_groups)
					&&  count(array_intersect($arrGroups, $_groups)))
				||  $objXNavigation->showProtected
				||  (	$objXNavigation instanceof ModuleSitemap
					&&  $objCurrentPage->sitemap == 'map_always'))
			{
				// Check whether there will be subpages
				$strSubItems = $objXNavigation->renderXNavigation($objCurrentPage, $intLevel+1);

				// Get href
				switch ($objCurrentPage->type)
				{
					case 'redirect':
						$href = $objCurrentPage->url;

						if (strncasecmp($href, 'mailto:', 7) === 0)
						{
							$this->import('String');
							$href = $this->String->encodeEmail($href);
						}
						break;

					case 'forward':
						if (!$objCurrentPage->jumpTo)
						{
							$objNext = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE pid=? AND type='regular'" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY sorting")
													->limit(1)
													->execute($objCurrentPage->id);
						}
						else
						{
							$objNext = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
													->limit(1)
													->execute($objCurrentPage->jumpTo);
						}

						if ($objNext->numRows)
						{
							$href = $this->generateFrontendUrl($objNext->fetchAssoc());
							break;
						}
						// DO NOT ADD A break; STATEMENT

					default:
						$href = $this->generateFrontendUrl($objCurrentPage->row());
						break;
				}

				if ($strSubItems === true) {
					$hassubmenu = true;
					$strSubItems = '';
				} else {
					$hassubmenu = false;
				}

				// Active page
				if (	(	$objPage->id == $objCurrentPage->id
						||  $objCurrentPage->type == 'forward'
						&&  $objPage->id == $objCurrentPage->jumpTo)
					&&  !($objXNavigation instanceof ModuleXSitemap)
					&&  !$this->Input->get('articles'))
				{
					$strClass = 'page' . (strlen($strSubItems) ? ' submenu' : '') . ($hassubmenu ? ' hassubmenu' : '') . (strlen($objCurrentPage->cssClass) ? ' ' . $objCurrentPage->cssClass : '');
					$row = $objCurrentPage->row();

					$row['isActive'] = true;
					$row['subitems'] = $strSubItems;
					$row['class'] = (strlen($strClass) ? $strClass : '');
					$row['pageTitle'] = specialchars($objCurrentPage->pageTitle);
					$row['title'] = specialchars($objCurrentPage->title);
					$row['link'] = $objCurrentPage->title;
					$row['href'] = $href;
					$row['alias'] = $objCurrentPage->alias;
					$row['nofollow'] = (strncmp($objCurrentPage->robots, 'noindex', 7) === 0);
					$row['target'] = (($objCurrentPage->type == 'redirect' && $objCurrentPage->target) ? LINK_NEW_WINDOW : '');
					$row['description'] = str_replace(array("\n", "\r"), array(' ' , ''), $objCurrentPage->description);
					$row['accesskey'] = $objCurrentPage->accesskey;
					$row['tabindex'] = $objCurrentPage->tabindex;
					$row['subpages'] = $objCurrentPage->subpages;
					$row['itemtype'] = 'page';

					$arrItems[] = $row;
				}

				// Regular page
				else
				{
					$strClass = 'page' . (strlen($strSubItems) ? ' submenu' : '') . ($hassubmenu ? ' hassubmenu' : '') . (strlen($objCurrentPage->cssClass) ? ' ' . $objCurrentPage->cssClass : '') . (!($objXNavigation instanceof ModuleXSitemap) && in_array($objCurrentPage->id, $objPage->trail) ? ' trail' : '');

					$row = $objCurrentPage->row();

					$row['isActive'] = false;
					$row['subitems'] = $strSubItems;
					$row['class'] = (strlen($strClass) ? $strClass : '');
					$row['pageTitle'] = specialchars($objCurrentPage->pageTitle);
					$row['title'] = specialchars($objCurrentPage->title);
					$row['link'] = $objCurrentPage->title;
					$row['href'] = $href;
					$row['alias'] = $objCurrentPage->alias;
					$row['nofollow'] = (strncmp($objCurrentPage->robots, 'noindex', 7) === 0);
					$row['target'] = (($objCurrentPage->type == 'redirect' && $objCurrentPage->target) ? LINK_NEW_WINDOW : '');
					$row['description'] = str_replace(array("\n", "\r"), array(' ' , ''), $objCurrentPage->description);
					$row['accesskey'] = $objCurrentPage->accesskey;
					$row['tabindex'] = $objCurrentPage->tabindex;
					$row['subpages'] = $objCurrentPage->subpages;
					$row['itemtype'] = 'page';

					$arrItems[] = $row;
				}
			}
			$intCountedChildren ++;
		}
		// calculate non-visible children
		else if (
			/* non sitemap navigation */
			!(	!($objXNavigation instanceof ModuleXSitemap)
			&&  (	$objCurrentPage->menu_visibility == 'map_never'
				||  $objCurrentPage->hide
				||  (	$this->hardLevel > 0
					&&  $this->hardLevel < $level)
				&&  $objCurrentPage->menu_visibility != 'map_always')
			/* sitemap navigation */
			||  $objXNavigation instanceof ModuleXSitemap
			&&  $objCurrentPage->sitemap == 'map_never'))
		{
			$intCountedChildren ++;
		}
	}
	
	public function generateItems(ModuleXNavigation &$objXNavigation,
		Database_Result $objCurrentPage,
		$blnCurrentPageActive,
		$blnCurrentPageTrail,
		&$arrItems,
		$intLevel,
		$intMaxLevel,
		$intHardLevel) 
	{
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
				. ((FE_USER_LOGGED_IN && !BE_USER_LOGGED_IN && !$objXNavigation->showProtected) ? " AND p1.guests!=1" : "")
				. (!BE_USER_LOGGED_IN ? " AND (p1.start='' OR p1.start<".$time.") AND (p1.stop='' OR p1.stop>".$time.") AND p1.published=1" : "") . "
			ORDER BY
				p1.sorting");
		$objSubpages = $stmtSubpages->execute($objCurrentPage->id);
		
		$intCountedChildren = 0;
		// Browse subpages
		while($objSubpages->next())
		{
			$intCountedChildren += $this->generateItem($objSubpages,
				$objXNavigation,
				$objCurrentPage,
				$blnActive,
				$blnTrail,
				$arrItems,
				$intLevel,
				$intMaxLevel,
				$intHardLevel);
		}
		return $intCountedChildren > 0;
	}
}
?>