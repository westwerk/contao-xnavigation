<?php

/**
 * xNavigation - Highly extendable and flexible navigation module for the Contao Open Source CMS
 *
 * Copyright (C) 2013 bit3 UG <http://bit3.de>
 *
 * @package    xNavigation
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @link       http://www.themeplus.de
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\Contao\XNavigation;

/**
 * Class XNavigationEvents
 */
class XNavigationEvents
{
	/**
	 * The CREATE_DEFAULT_CONDITION event occurs when a default condition set gets created.
	 *
	 * The event listener method receives a Bit3\Contao\XNavigation\Event\CreateDefaultConditionEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const CREATE_DEFAULT_CONDITION = 'xnavigation.create-default-condition';

	/**
	 * The CREATE_ITEM event occurs when a default condition set gets created.
	 *
	 * The event listener method receives a Bit3\Contao\XNavigation\Event\CreateDefaultConditionEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const CREATE_ITEM = 'xnavigation.create-item';

	/**
	 * The COLLECT_ITEMS event occurs when a default condition set gets created.
	 *
	 * The event listener method receives a Bit3\Contao\XNavigation\Event\CreateDefaultConditionEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const COLLECT_ITEMS = 'xnavigation.collect-items';
}
