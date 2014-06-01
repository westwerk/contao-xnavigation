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
 * Class ModuleXNavigation
 *
 * Front end module "xNavigation".
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xNavigation
 */
class ModuleXNavigation extends Module {
	
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_navigation';

	/**
	 * Do not display the module if there are no menu items
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### NAVIGATION MENU ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$strBuffer = parent::generate();
		return strlen($this->Template->items) ? $strBuffer : '';
	}

	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		global $objPage;
		
		$trail = $objPage->trail;
		$intLevel = ($this->levelOffset > 0) ? $this->levelOffset : 0;

		// Overwrite with custom reference page
		if ($this->defineRoot && $this->rootPage > 0)
		{
			$trail = array($this->rootPage);
			$intLevel = 0;
		}

		$request = ampersand($this->Environment->request, true);

		if ($request == 'index.php')
		{
			$request = '';
		}

		$this->Template->request = $request;
		$this->Template->skipId = 'skipNavigation' . $this->id;
		$this->Template->skipNavigation = specialchars($GLOBALS['TL_LANG']['MSC']['skipNavigation']);
		$this->Template->items = $this->renderXNavigation($trail[$intLevel], $intLevel+1);
	}
	
	
	/**
	 * Recursively compile the navigation menu and return it as HTML string
	 * @param object
	 * @param integer
	 * @return string
	 */
	public function renderXNavigation(&$objCurrentPage, $intLevel=1) {
		$time = time();
		
		// Get global page object
		global $objPage;
		
		// Convert current page id into database record 
		if (!($objCurrentPage instanceof Database_Result))
		{
			if ($objCurrentPage > 0)
			{
				$objCurrentPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id = ?")
									   ->execute($objCurrentPage);
			}
			else
			{
				$objCurrentPage = $this->Database->execute("SELECT 0 as id");
			}
			if (!$objCurrentPage->next())
			{
				return '';
			}
		}
		
		// Define if the current element is active
		$blnActive = $objCurrentPage->id == $objPage->id;
		$blnTrail = in_array($objCurrentPage->id, $objPage->trail);
		
		$arrItems = array();
		
		// Layout template fallback
		if (!strlen($this->navigationTpl))
		{
			$this->navigationTpl = 'nav_default';
		}

		$objTemplate = new FrontendTemplate($this->navigationTpl);

		$objTemplate->type = get_class($this);
		$objTemplate->level = 'level_' . $intLevel;
		
		// the children count, can be greater than 0, even $arrItems is empty
		// this is the count of existing, but maybe not visible children
		$intCountedChildren = 0;
		
		// generate the items
		if (isset($GLOBALS['TL_HOOKS']['xNavigationProvider']) && is_array($GLOBALS['TL_HOOKS']['xNavigationProvider']))
		{
			foreach ($GLOBALS['TL_HOOKS']['xNavigationProvider'] as $callback)
			{
				$this->import($callback[0]);
				$intCountedChildren += $this->$callback[0]->$callback[1]($this,
					$objCurrentPage,
					$blnActive,
					$blnTrail,
					$arrItems,
					$intLevel,
					$this->showLevel,
					$this->hardLevel);
			}
		}
		
		// Add classes first and last
		if (count($arrItems))
		{
			$last = count($arrItems) - 1;
			
			$arrItems[0]['class'] = trim($arrItems[0]['class'] . ' first');
			$arrItems[$last]['class'] = trim($arrItems[$last]['class'] . ' last');
		}

		$objTemplate->items = $arrItems;
		return count($arrItems) ? $objTemplate->parse() : ($intCountedChildren > 0 ? true : '');
	}
	
}

?>