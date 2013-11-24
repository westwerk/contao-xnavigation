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

use Bit3\Contao\XNavigation\Model\FilterModel;
use Bit3\FlexiTree\Matcher\Voter\VoterInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CreateVoterEvent
 */
class CreateVoterEvent extends Event
{
	/**
	 * @var FilterModel
	 */
	protected $filterModel;

	/**
	 * @var VoterInterface
	 */
	protected $voter;

	public function __construct(FilterModel $filterModel)
	{
		$this->filterModel = $filterModel;
	}

	/**
	 * @return FilterModel
	 */
	public function getFilterModel()
	{
		return $this->filterModel;
	}

	/**
	 * @param VoterInterface $voter
	 */
	public function setVoter(VoterInterface $voter)
	{
		$this->voter = $voter;
		return $this;
	}

	/**
	 * @return VoterInterface
	 */
	public function getVoter()
	{
		return $this->voter;
	}
}
