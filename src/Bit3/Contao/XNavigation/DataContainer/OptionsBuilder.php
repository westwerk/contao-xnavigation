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

namespace Bit3\Contao\XNavigation\DataContainer;

use Bit3\Contao\XNavigation\ConditionFactory;
use Bit3\Contao\XNavigation\Model\ConditionModel;

/**
 * Class OptionsBuilder
 */
class OptionsBuilder
{
	public function getConditionOptions()
	{
		$options = array();

		$conditionFactory = new ConditionFactory();

		$conditionCollection = ConditionModel::findBy('pid', '0', array('order' => 'sorting'));
		if ($conditionCollection) {
			while ($conditionCollection->next()) {
				if ($conditionCollection->title) {
					$title = $conditionCollection->title;
				}
				else {
					$condition = $conditionFactory->create($conditionCollection->current());
					$title     = $condition->describe();
				}

				$options[$conditionCollection->id] = $title;
			}
		}

		return $options;
	}
}
