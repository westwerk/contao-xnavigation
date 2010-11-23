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
 * Table tl_page
 */
if (!isset($GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback']))
	$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'] = array();
$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'][] = array('tl_page_xNavigation', 'submit');

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'xNavigationIncludeNewsArchives';
foreach (array('regular', 'forward', 'redirect') as $type) {
	$GLOBALS['TL_DCA']['tl_page']['palettes'][$type] = preg_replace('/,(sitemap,)?hide([^;]*;)/', ',sitemap,xNavigation$2{xNavigation_legend},xNavigationIncludeArticles,xNavigationIncludeNewsArchives;{xNavigationNewsArchives_legend},xNavigationNewsArchives,xNavigationNewsArchiveFormat,xNavigationNewsArchiveShowQuantity;',
		$GLOBALS['TL_DCA']['tl_page']['palettes'][$type]);
}

if (!isset($GLOBALS['TL_DCA']['tl_page']['fields']['sitemap'])) {
	$GLOBALS['TL_DCA']['tl_page']['fields']['sitemap'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_page']['sitemap'],
		'exclude'                 => true,
		'inputType'               => 'select',
		'options'                 => array('map_default', 'map_always', 'map_never'),
		'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
		'reference'               => &$GLOBALS['TL_LANG']['tl_page']
	);
}


$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigation'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigation'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_default', 'map_always', 'map_never'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page'],
	'load_callback'           => array(
		array('tl_page_xNavigation', 'loadXNavigation')
	)
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationIncludeArticles'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationIncludeArticles'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_active', 'map_always', 'map_never'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50', 'alwaysSave'=>true),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationIncludeNewsArchives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationIncludeNewsArchives'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_active', 'map_always', 'map_never'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchives'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_page_xNavigation', 'getNewsArchives'),
	'eval'                    => array('multiple'=>true)
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchiveFormat'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchiveFormat'],
	'default'                 => 'news_month',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('news_month', 'news_year'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page'],
	'eval'                    => array('tl_class'=>'w50'),
	'wizard' => array
	(
		array('tl_page_xNavigation', 'hideStartDay')
	)
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchiveShowQuantity'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchiveShowQuantity'],
	'exclude'                 => true,
	'inputType'               => 'checkbox'
);


/**
 * Class tl_page_xNavigation
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  InfinityLabs - Olck & Lins GbR 2009 
 * @author     Tristan Lins 
 * @package    xNavigation
 */
class tl_page_xNavigation extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	
	

	/**
	 * Get all news archives and return them as array
	 * @return array
	 */
	public function getNewsArchives()
	{
		if (!$this->User->isAdmin && !is_array($this->User->news))
		{
			return array();
		}

		$arrForms = array();
		$objForms = $this->Database->execute("SELECT id, title FROM tl_news_archive ORDER BY title");

		while ($objForms->next())
		{
			if ($this->User->isAdmin || in_array($objForms->id, $this->User->news))
			{
				$arrForms[$objForms->id] = $objForms->title;
			}
		}

		return $arrForms;
	}

	
	/**
	 * 
	 * @return 
	 */
	public function loadXNavigation($varValue, DataContainer $dc)
	{
		if (!$dc->activeRecord) {
			$dc->activeRecord = $this->Database->prepare("SELECT * FROM tl_page WHERE id = ?")
											   ->execute($dc->id);
		}
		
		if (!trim($varValue))
		{
			$varValue = $dc->activeRecord->hide != '1' ? 'map_default' : 'map_never';;
		}
		
		return $varValue;
	}
	
	
	/**
	 * 
	 * @return 
	 */
	public function submit(DataContainer $dc)
	{
		if (!$dc->activeRecord) {
			$objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id = ?")
											   ->execute($dc->id);
		} else {
			$hide = $dc->activeRecord->xNavigation == 'map_never' ? '1' : '';
			if ($dc->activeRecord->hide != $hide);
				$this->Database->prepare("UPDATE tl_page SET hide = ? WHERE id = ?")
							   ->execute($hide, $dc->activeRecord->id);
		}
	}
	

	/**
	 * Hide the start day drop-down if not applicable
	 * @return string
	 */
	public function hideStartDay()
	{
		return '
  <script type="text/javascript">
  <!--//--><![CDATA[//><!--
  var enableStartDay = function() {
    var el = $("ctrl_news_startDay").getParent("div");
    if ($("ctrl_news_format").value == "news_day") {
      el.setStyle("visibility", "visible");
    } else {
      el.setStyle("visibility", "hidden");
    }
  };
  window.addEvent("domready", enableStartDay);
  $("ctrl_news_format").addEvent("change", enableStartDay);
  //--><!]]>
  </script>';
	}
}

?>