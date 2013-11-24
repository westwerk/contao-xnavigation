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
use Bit3\Contao\XNavigation\Model\ProviderModel;
use Bit3\FlexiTree\Matcher\Voter\VoterInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateProviderEvent
 */
class CreateProviderEvent extends Event
{
	/**
	 * @var ProviderModel
	 */
	protected $providerModel;

	/**
	 * @var EventSubscriberInterface
	 */
	protected $provider;

	public function __construct(ProviderModel $providerModel)
	{
		$this->providerModel = $providerModel;
	}

	/**
	 * @return ProviderModel
	 */
	public function getProviderModel()
	{
		return $this->providerModel;
	}

	/**
	 * @param EventSubscriberInterface $voter
	 */
	public function setProvider(EventSubscriberInterface $voter)
	{
		$this->provider = $voter;
		return $this;
	}

	/**
	 * @return EventSubscriberInterface
	 */
	public function getProvider()
	{
		return $this->provider;
	}
}
