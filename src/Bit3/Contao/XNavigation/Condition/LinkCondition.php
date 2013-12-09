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

namespace Bit3\Contao\XNavigation\Condition;

use Bit3\Contao\XNavigation\ConditionFactory;
use Bit3\Contao\XNavigation\Model\ConditionModel;
use Bit3\FlexiTree\Condition\ConditionInterface;
use Bit3\FlexiTree\ItemInterface;

/**
 * Class LinkCondition
 */
class LinkCondition implements ConditionInterface
{
	/**
	 * @var bool
	 */
	protected $conditionId;

	public function __construct($conditionId = 0)
	{
		$this->conditionId = $conditionId;
	}

	/**
	 * @param boolean $acceptedSitemapStatus
	 */
	public function setConditionId($acceptedSitemapStatus)
	{
		$this->conditionId = (string) $acceptedSitemapStatus;
		return $this;
	}

	/**
	 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
	 * @return boolean
	 */
	public function getConditionId()
	{
		return $this->conditionId;
	}

	public function getCondition()
	{
		$conditionModel = ConditionModel::findByPk($this->conditionId);

		if ($conditionModel) {
			$conditionFactory = new ConditionFactory();
			$condition = $conditionFactory->create($conditionModel);
			return $condition;
		}

		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		$condition = $this->getCondition();

		if ($condition) {
			return $condition->matchItem($item);
		}

		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function describe()
	{
		$condition = $this->getCondition();

		if ($condition) {
			return $condition->describe();
		}

		return 'false';
	}
}
