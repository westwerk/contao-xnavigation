<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2009-2010 Leo Feyer
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
 * @copyright  InfinityLabs - Olck & Lins GbR 2009-2010
 * @author     Tristan Lins <tristan.lins@infinitylabs.de>
 * @package    xNavigation
 * @license    LGPL
 * @filesource
 */


/**
 * Class XNavigation
 *
 * 
 * @copyright  InfinityLabs - Olck & Lins GbR 2009
 * @author     Tristan Lins <tristan.lins@infinitylabs.de>
 * @package    xNavigation
 */
class XNavigation extends Controller
{
	protected static $arrDNSCache = array();

	public function __construct() {
		parent::__construct();
		$this->import('Database');
	}

	protected function findPageDNS($arrRow, $arrPath = null) {
		if ($arrRow != null && count($arrRow)) {
			if ($arrPath == null)
				$arrPath = array();
			#echo "--------------------------------------------------------------\n";
			#echo 'findPageDNS: '; print_r(array('id' => $arrRow['id'], 'title' => $arrRow['title'], 'type' => $arrRow['type'], 'dns' => $arrRow['dns']));
			if (isset(XNavigation::$arrDNSCache[$arrRow['id']])) {
				foreach ($arrPath as $row)
					XNavigation::$arrDNSCache[$row['id']] = XNavigation::$arrDNSCache[$arrRow['id']];
				#echo "--------------------------------------------------------------\n";
				#echo 'use cached result from: '; print_r(XNavigation::$arrDNSCache);
				return XNavigation::$arrDNSCache[$arrRow['id']];
			} else if ($arrRow['type'] == 'root') {
				XNavigation::$arrDNSCache[$arrRow['id']] = $arrRow['dns'];
				foreach ($arrPath as $row)
					XNavigation::$arrDNSCache[$row['id']] = XNavigation::$arrDNSCache[$arrRow['id']];
				#echo "--------------------------------------------------------------\n";
				#echo 'use new dns, current cache: '; print_r(XNavigation::$arrDNSCache);
				return $arrRow['dns'];
			} else {
				$objPage = $this->Database->prepare("SELECT id,pid,type,dns FROM tl_page WHERE id=" . (empty($arrRow['pid']) ? "(SELECT pid FROM tl_page WHERE id=?)" : "?"))
										->execute(empty($arrRow['pid']) ? $arrRow['id'] : $arrRow['pid']);
				if ($objPage->next()) {
					return $this->findPageDNS($objPage->row(), array_merge($arrPath, array($arrRow['id'])));
				} else {
					#print_r($objPage);
					#debug_print_backtrace();
				}
			}
		}
		return $GLOBALS['TL_CONFIG']['baseDNS'];
	}
	
	/**
	 * Replace insert tags with their values
	 * @param string
	 * @return string
	 */
	protected function replaceDomainLinkInsertTags($strBuffer, $blnCache=false)
	{
		global $objPage;

		switch ($strBuffer)
		{
		case 'dns::domain':
			return $this->findPageDNS($objPage != null ? $objPage->row() : null);
		}

		return false;
	}

	/**
	 * Generate an URL from a tl_page record depending on the current rewriteURL setting and return it
	 * @param array
	 * @param string
	 * @return string
	 */
	protected function generateDomainLink($arrRow, $strParams, $strUrl)
	{
		global $objPage;
		#echo "**********************************************************\n";
		
		if (!preg_match('#^(\w+://)#', $strUrl)) {
			#echo 'strUrl: '; var_dump($strUrl);
			#echo "------------------------------------------------------\n";
			$current = $objPage != null ? $this->findPageDNS($objPage->row()) : false;
			#echo 'current: '; var_dump($current);
			#echo "------------------------------------------------------\n";
			$target = $this->findPageDNS($arrRow);
			#echo 'target: '; var_dump($target);
			#echo "------------------------------------------------------\n";
			if (strlen($target) && $current != $target) {
				$strUrl = sprintf('http://%s/%s', $target, $strUrl);
			}
			#echo 'strUrl: '; var_dump($strUrl);
		}
		return $strUrl;
	}
	
}
?>