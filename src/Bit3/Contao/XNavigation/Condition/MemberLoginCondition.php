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

use Bit3\FlexiTree\Condition\ConditionInterface;
use Bit3\FlexiTree\ItemInterface;

/**
 * Class MemberLoginCondition
 */
class MemberLoginCondition implements ConditionInterface
{
	const STATUS_LOGGED_IN = 'logged_in';

	const STATUS_LOGGED_OUT = 'logged_out';

	/**
	 * @var bool
	 */
	protected $acceptedLoginStatus;

	public function __construct($acceptedLoginStatus = 'logged_in')
	{
		$this->acceptedLoginStatus = $acceptedLoginStatus;
	}

	/**
	 * @param boolean $acceptedSitemapStatus
	 */
	public function setAcceptedLoginStatus($acceptedSitemapStatus)
	{
		$this->acceptedLoginStatus = (string) $acceptedSitemapStatus;
		return $this;
	}

	/**
	 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
	 * @return boolean
	 */
	public function getAcceptedLoginStatus()
	{
		return $this->acceptedLoginStatus;
	}

	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		return $this->acceptedLoginStatus == static::STATUS_LOGGED_IN && FE_USER_LOGGED_IN ||
			$this->acceptedLoginStatus == static::STATUS_LOGGED_OUT && !FE_USER_LOGGED_IN;
	}

	/**
	 * {@inheritdoc}
	 */
	public function describe()
	{
		if ($this->acceptedLoginStatus == static::STATUS_LOGGED_IN) {
			return 'FE_USER_LOGGED_IN';
		}
		else if ($this->acceptedLoginStatus == static::STATUS_LOGGED_OUT) {
			return '!FE_USER_LOGGED_IN';
		}
		else {
			return 'false';
		}
	}
}
