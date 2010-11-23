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
 * Class xNavigationProvider
 * 
 * A xNavigation provider generates menu items.
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xNavigation
 */
abstract class xNavigationProvider extends Controller
{
	
	/**
	 * Generate menu items for the specific page.
	 * @param ModuleXNavigation $xNavigation
	 * The module instance.
	 * 
	 * @param Database_Result $objCurrentPage
	 * The page data.
	 * 
	 * @param bool $blnActive
	 * Flag that define the current page active state.
	 * 
	 * @param bool $blnTrail
	 * Flag that define the current page trail state.
	 * 
	 * @param array $arrItems
	 * The reference to the items array.
	 * 
	 * @param int $intLevel
	 * The current hierarchy level.
	 * 
	 * @param int $intMaxLevel
	 * @param int $intHardLevel
	 * 
	 * @return
	 * Return the count of existing children, but maybe not added to $arrItems.
	 */
	public abstract function generateItems(ModuleXNavigation &$objXNavigation,
		Database_Result $objCurrentPage,
		$blnCurrentPageActive,
		$blnCurrentPageTrail,
		&$arrItems,
		$intLevel,
		$intMaxLevel,
		$intHardLevel);
	
}
?>