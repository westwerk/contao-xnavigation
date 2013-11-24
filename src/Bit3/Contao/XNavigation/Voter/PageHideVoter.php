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
 * Class PageHideVoter
 */
class PageHideVoter implements VoterInterface
{
	/**
	 * @var bool
	 */
	protected $acceptedHideStatus;

	public function __construct($acceptedHideStatus = false)
	{
		$this->acceptedHideStatus = $acceptedHideStatus;
	}

	/**
	 * @param boolean $acceptedHideStatus
	 */
	public function setAcceptedHideStatus($acceptedHideStatus)
	{
		$this->acceptedHideStatus = (bool) $acceptedHideStatus;
		return $this;
	}

	/**
	 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
	 * @return boolean
	 */
	public function getAcceptedHideStatus()
	{
		return $this->acceptedHideStatus;
	}

	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		if ($item->getType() == 'page') {
			$hide = $item->getExtra('hide');
			if ($hide != $this->acceptedHideStatus) {
				return 'never';
			}
			else {
				return true;
			}
		}

		return null;
	}
}
