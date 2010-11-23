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
 * Class ModuleXSitemap
 *
 * Front end module "xSitemap".
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xNavigation
 */
class ModuleXSitemap extends ModuleXNavigation {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_sitemap';
	

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### SITEMAP ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$this->rootPage = 0;
		$this->rootPageObj = null;
		
		if (!$this->includeFullHierarchy)
		{
			// calculate the root page
			$arrTrail = $GLOBALS['objPage']->trail;
			$objPage = $this->Database->execute("
					SELECT
						*
					FROM
						`tl_page`
					WHERE
							`id` IN (" . implode(',', $arrTrail) . ")
						AND `type`='root'
					ORDER BY
						`id`=" . implode(',`id`=', $arrTrail) . "
					LIMIT
						1");
			if ($objPage->next())
			{
				$this->rootPage = $objPage->id;
				$this->rootPageObj = $objPage;
			}
		}
		
		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->showLevel = 0;
		$this->hardLimit = false;
		$this->levelOffset = 0;

		// create a level_0 root item with its sitemap
		if (!$this->includeFullHierarchy && $this->includeRoot && $this->rootPageObj)
		{
			$this->import('xNavigationPageProvider');
			
			if ($this->rootPageObj->pid > 0)
			{
				$objParentPage = $this->Database->prepare("
						SELECT
							*
						FROM
							`tl_page`
						WHERE
							`id`=?")
					->execute($this->rootPageObj->pid);
			}
			else
			{
				$objParentPage = $this->Database->execute("
						SELECT
							0 as `id`");
			}
			
			$objTemplate = new FrontendTemplate($this->navigationTpl);
	
			$objTemplate->type = get_class($this);
			$objTemplate->level = 'level_0';
			
			$arrItems = array();
			$this->Template->items = $this->xNavigationPageProvider->generateItem($this->rootPageObj,
				$this,
				$objParentPage,
				false,
				true,
				$arrItems,
				0,
				$this->showLevel,
				$this->hardLevel);
			
			// Add classes first and last
			if (count($arrItems))
			{
				$last = count($arrItems) - 1;
				
				$arrItems[0]['class'] = trim($arrItems[0]['class'] . ' first');
				$arrItems[$last]['class'] = trim($arrItems[$last]['class'] . ' last');
			}
	
			$objTemplate->items = $arrItems;
			$this->Template->items = $objTemplate->parse();
		}
		// create the regular sitemap
		else
		{
			$this->Template->items = $this->renderXNavigation($this->rootPage);
		}
	}
}

?>