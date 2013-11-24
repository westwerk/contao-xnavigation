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

namespace Bit3\Contao\XNavigation\Voter;

use Bit3\FlexiTree\ItemInterface;
use Bit3\FlexiTree\Matcher\Voter\VoterInterface;

/**
 * Class PageGuestsVoter
 */
class PageGuestsVoter implements VoterInterface
{
	const LOGGED_IN = 'logged_in';

	const LOGGED_OUT = 'logged_out';

	/**
	 * @var bool
	 */
	protected $acceptedGuestsStatus;

	/**
	 * @var string
	 */
	protected $acceptedLoginStatus;

	public function __construct($acceptedGuestsStatus = false, $acceptedLoginStatus = 'logged_in')
	{
		$this->setAcceptedGuestsStatus($acceptedGuestsStatus);
		$this->setAcceptedLoginStatus($acceptedLoginStatus);
	}

	/**
	 * @param boolean $acceptedGuestsStatus
	 */
	public function setAcceptedGuestsStatus($acceptedGuestsStatus)
	{
		$this->acceptedGuestsStatus = (bool) $acceptedGuestsStatus;
		return $this;
	}

	/**
	 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
	 * @return boolean
	 */
	public function getAcceptedGuestsStatus()
	{
		return $this->acceptedGuestsStatus;
	}

	/**
	 * @param string $acceptedLoginStatus
	 */
	public function setAcceptedLoginStatus($acceptedLoginStatus)
	{
		if (
			$acceptedLoginStatus &&
			$acceptedLoginStatus != 'logged_in' &&
			$acceptedLoginStatus != 'logged_out'
		) {
			throw new \InvalidArgumentException($acceptedLoginStatus . ' is not a valid login status');
		}

		$this->acceptedLoginStatus = (string) $acceptedLoginStatus;
		return $this;
	}

	/**
	 * @return string
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
		if ($item->getType() == 'page') {
			$guests = $item->getExtra('guests');
			if (
				$guests != $this->acceptedGuestsStatus &&
				(
					!$this->acceptedLoginStatus ||
					($this->acceptedLoginStatus == 'logged_in' && !FE_USER_LOGGED_IN) ||
					($this->acceptedLoginStatus == 'logged_out' && FE_USER_LOGGED_IN)
				)
			) {
				return 'never';
			}
			else {
				return true;
			}
		}

		return null;
	}
}
