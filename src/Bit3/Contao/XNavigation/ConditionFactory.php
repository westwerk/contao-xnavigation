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

use Bit3\Contao\XNavigation\Event\CreateConditionEvent;
use Bit3\Contao\XNavigation\Model\ConditionModel;
use Bit3\FlexiTree\Condition\ChainConditionInterface;
use Bit3\FlexiTree\Condition\NotCondition;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ConditionFactory
 */
class ConditionFactory
{
	public function create(ConditionModel $conditionModel)
	{
		$eventDispatcher = $this->getEventDispatcher();

		$event = new CreateConditionEvent($conditionModel);
		$eventDispatcher->dispatch(EVENT_XNAVIGATION_CREATE_CONDITION, $event);

		if ($event->getCondition()) {
			return $event->getCondition();
		}

		$row       = $conditionModel->row();
		$type      = $conditionModel->type;
		$className = $this->getConditionClassName($type);
		$class     = new \ReflectionClass($className);
		$condition = $class->newInstance();

		$rgxp = '~^' . preg_quote($type, '~') . '_(.*)$~';
		foreach ($row as $key => $value) {
			if ($value && preg_match($rgxp, $key, $matches)) {
				$property = $matches[1];
				$property = explode('_', $property);
				$property = array_map('ucfirst', $property);
				$property = implode('', $property);

				$setterName = 'set' . $property;

				if ($class->hasMethod($setterName)) {
					$setter     = $class->getMethod($setterName);
					$parameters = $setter->getParameters();
					if (count($parameters)) {
						$firstParameter = $parameters[0];

						// unserialize magic
						if ($firstParameter->isArray()) {
							$value = deserialize($value, true);
						}

						$setter->invoke($condition, $value);
					}
				}
			}
		}

		if ($condition instanceof ChainConditionInterface) {
			$childConditionCollection = ConditionModel::findBy('pid', $conditionModel->id, array('order' => 'sorting'));

			if ($childConditionCollection) {
				while ($childConditionCollection->next()) {
					$childCondition = $this->create($childConditionCollection->current());
					$condition->addCondition($childCondition);
				}
			}
		}

		if ($conditionModel->invert) {
			$condition = new NotCondition($condition);
		}

		return $condition;
	}

	/**
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 * @return string
	 */
	public function getConditionClassName($type)
	{
		return $GLOBALS['XNAVIGATION_CONDITION'][$type];
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
