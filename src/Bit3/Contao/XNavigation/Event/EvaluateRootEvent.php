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

namespace Bit3\Contao\XNavigation\Event;

use Bit3\Contao\XNavigation\Model\MenuModel;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class EvaluateRootEvent
 */
class EvaluateRootEvent extends Event
{
	/**
	 * @var MenuModel
	 */
	protected $menuModel;

	/**
	 * @var string
	 */
	protected $itemType;

	/**
	 * @var string
	 */
	protected $itemName;

	public function __construct(MenuModel $menuModel)
	{
		$this->menuModel = $menuModel;
	}

	/**
	 * @return MenuModel
	 */
	public function getMenuModel()
	{
		return $this->menuModel;
	}

	/**
	 * @param string $type
	 */
	public function setItemType($type)
	{
		$this->type = (string) $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getItemType()
	{
		return $this->type;
	}

	/**
	 * @param string $name
	 */
	public function setItemName($name)
	{
		$this->itemName = (string) $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getItemName()
	{
		return $this->itemName;
	}
}
