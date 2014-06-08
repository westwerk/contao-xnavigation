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

use Bit3\Contao\XNavigation\Model\ConditionModel;
use Bit3\FlexiTree\Condition\ConditionInterface;
use Bit3\FlexiTree\ItemInterface;
use string;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class GenerateItemClassesEvent
 */
class GenerateItemClassesEvent extends Event
{

	/**
	 * @var ItemInterface
	 */
	protected $item;

	/**
	 * @var array|string[]
	 */
	protected $classes;

	public function __construct(ItemInterface $item)
	{
		$this->item = $item;
	}

	/**
	 * @return ItemInterface
	 */
	public function getItem()
	{
		return $this->item;
	}

	/**
	 * @return array|\string[]
	 */
	public function getClasses()
	{
		return $this->classes;
	}

	/**
	 * @param array|\string[] $classes
	 *
	 * @return GenerateItemClassesEvent
	 */
	public function setClasses(array $classes)
	{
		$this->classes = $classes;
		return $this;
	}
}
