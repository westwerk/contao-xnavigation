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

use Bit3\Contao\XNavigation\Event\CreateProviderEvent;
use Bit3\Contao\XNavigation\Event\CreateVoterEvent;
use Bit3\Contao\XNavigation\Model\FilterModel;
use Bit3\Contao\XNavigation\Model\ProviderModel;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ProviderFactory
 */
class ProviderFactory
{
	public function create(ProviderModel $provider)
	{
		$eventDispatcher = $this->getEventDispatcher();

		$event = new CreateProviderEvent($provider);
		$eventDispatcher->dispatch(EVENT_XNAVIGATION_CREATE_PROVIDER, $event);

		if ($event->getProvider()) {
			return $event->getProvider();
		}

		$row        = $provider->row();
		$type       = $provider->type;
		$className  = $this->getProviderClassName($type);
		$class      = new \ReflectionClass($className);
		$subscriber = $class->newInstance();

		$rgxp = '~^' . preg_quote($type, '~') . '_(.*)$~';
		foreach ($row as $key => $value) {
			if ($value && preg_match($rgxp, $key, $matches)) {
				$property = $matches[1];
				$property = explode('_', $property);
				$property = array_map('ucfirst', $property);
				$property = implode('', $property);

				$setterName = 'set' . $property;

				if ($class->hasMethod($setterName)) {
					$setter = $class->getMethod($setterName);
					$setter->invoke($subscriber, $value);
				}
			}
		}

		return $subscriber;
	}

	/**
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 * @return string
	 */
	public function getProviderClassName($type)
	{
		return $GLOBALS['XNAVIGATION_PROVIDER'][$type];
	}

	/**
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 * @return EventDispatcher
	 */
	protected function getEventDispatcher()
	{
		return $GLOBALS['container']['event-dispatcher'];
	}
}
