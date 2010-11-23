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
 * Table tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'][] = array('tl_page_xNavigation', 'submit');

foreach (array('regular', 'forward', 'redirect') as $type)
{
	$GLOBALS['TL_DCA']['tl_page']['palettes'][$type] = preg_replace(
		'/,(sitemap,)?hide([^;]*;)/',
		',sitemap,menu_visibility$2;',
		$GLOBALS['TL_DCA']['tl_page']['palettes'][$type]);
}

$GLOBALS['TL_DCA']['tl_page']['fields']['menu_visibility'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['menu_visibility'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_default', 'map_always', 'map_never'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page'],
	'load_callback'           => array(
		array('tl_page_xNavigation', 'loadMenuVisibility')
	)
);

/**
 * Class tl_page_xNavigation
 *
 * Helper class for tl_page table.
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xNavigation
 */
class tl_page_xNavigation extends Backend
{
	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Load callback for menu_visibility.
	 * @param string
	 * @param object
	 * @return string
	 */
	public function loadMenuVisibility($varValue, DataContainer $dc)
	{
		if (!trim($varValue))
		{
			if (!$dc->activeRecord)
			{
				$dc->activeRecord = $this->Database->prepare("SELECT * FROM tl_page WHERE id = ?")
												   ->execute($dc->id);
			}
			
			$varValue = $dc->activeRecord->hide != '1' ? 'map_default' : 'map_never';
		}
		
		return $varValue;
	}
	
	
	/**
	 * Submit callback.
	 * @param object
	 */
	public function submit(DataContainer $dc)
	{
		$strFormFields = implode(',', $this->Input->post('FORM_FIELDS'));
		$arrFormFields = preg_split('~[,;]~', $strFormFields);
		
		if (in_array('menu_visibility', $arrFormFields))
		{
			$hide = $this->Input->post('menu_visibility') == 'map_never' ? '1' : '';
			if ($dc->activeRecord->hide != $hide)
			{
				$this->Database->prepare("UPDATE tl_page SET hide = ? WHERE id = ?")
							   ->execute($hide, $dc->id);
			}
		}
		elseif (in_array('hide', $arrFormFields))
		{
			$menu_visibility = $this->Input->post('hide') ? 'map_never' : 'map_default';
			if ($dc->activeRecord->menu_visibility != $menu_visibility)
			{
				$this->Database->prepare("UPDATE tl_page SET menu_visibility = ? WHERE id = ?")
							   ->execute($hide_in_menu, $dc->id);
			}
		}
	}
}

?>