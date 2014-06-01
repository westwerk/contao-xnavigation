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
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CreateDefaultConditionEvent
 */
class CreateDefaultConditionEvent extends Event
{
	/**
	 * @var ConditionModel
	 */
	protected $condition;

	public function __construct(ConditionModel $condition)
	{
		$this->condition = $condition;
	}

	/**
	 * @return ConditionModel
	 */
	public function getCondition()
	{
		return $this->condition;
	}
}
