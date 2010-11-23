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


/**
 * Class ModuleXNavigationMenuWrapper
 *
 * 
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins 
 * @package    xNavigation
 */
class ModuleXNavigationMenuWrapper extends ModuleNewsMenu {
	
	public function generateItems(ModuleXNavigation &$xNavigation, &$objPage, &$objNewsArchives) {
		$this->Template = new FrontendTemplate();
		$this->news_format = $xNavigation->xNavigationNewsArchiveFormat;
		$this->news_archives = $objNewsArchives;
		$this->jumpTo = $objPage->id;
		$this->news_showQuantity = $xNavigation->xNavigationNewsArchiveShowQuantity;
		$this->compile();
		$items = array();
		switch ($this->news_format)
		{
			case 'news_year':
				foreach ($this->Template->items as $year => $item) {
					$item['type'] = 'news_archive';
					$items[] = $item;
				}
				break;

			default:
			case 'news_month':
				foreach ($this->Template->items as $year => $monthItems) {
					foreach ($monthItems as $month => $item) {
						$item['type'] = 'news_archive';
						$items[] = $item;
					}
				}
				break;
		}
		
		return $items;
	}
	
}
?>