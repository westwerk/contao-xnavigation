<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package XNavigation
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ModuleXSitemap'          => 'system/modules/xNavigation/ModuleXSitemap.php',
	'ModuleXNavigation'       => 'system/modules/xNavigation/ModuleXNavigation.php',
	'xNavigationPageProvider' => 'system/modules/xNavigation/xNavigationPageProvider.php',
	'xNavigationProvider'     => 'system/modules/xNavigation/xNavigationProvider.php',
));
