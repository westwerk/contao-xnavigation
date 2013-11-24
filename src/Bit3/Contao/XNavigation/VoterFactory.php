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

use Bit3\Contao\XNavigation\Event\CreateVoterEvent;
use Bit3\Contao\XNavigation\Model\FilterModel;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class VoterFactory
 */
class VoterFactory
{
	public function create(FilterModel $filterModel)
	{
		$eventDispatcher = $this->getEventDispatcher();

		$event = new CreateVoterEvent($filterModel);
		$eventDispatcher->dispatch(EVENT_XNAVIGATION_CREATE_VOTER, $event);

		if ($event->getVoter()) {
			return $event->getVoter();
		}

		$row       = $filterModel->row();
		$type      = $filterModel->type;
		$className = $this->getFilterClassName($type);
		$class     = new \ReflectionClass($className);
		$voter     = $class->newInstance();

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
					$parameters = $setter->getParameters();
					if (count($parameters)) {
						$firstParameter = $parameters[0];

						// unserialize magic
						if ($firstParameter->isArray()) {
							$value = deserialize($value, true);
						}

						$setter->invoke($voter, $value);
					}
				}
			}
		}

		return $voter;
	}

	/**
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 * @return string
	 */
	public function getFilterClassName($type)
	{
		return $GLOBALS['XNAVIGATION_FILTER'][$type];
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
