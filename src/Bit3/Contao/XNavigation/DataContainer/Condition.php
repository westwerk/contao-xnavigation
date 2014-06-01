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
use Bit3\Contao\XNavigation\Event\CreateDefaultConditionEvent;
use Bit3\Contao\XNavigation\Model\ConditionModel;
use Bit3\Contao\XNavigation\XNavigationEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Condition
 */
class Condition
{
	public function createDefault()
	{
		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$root = new ConditionModel();
		$root->type = 'or';
		$root->title = sprintf('Contao default condition (generated at %s)', date($GLOBALS['TL_CONFIG']['datimFormat']));
		$root->save();

		$event = new CreateDefaultConditionEvent($root);
		$eventDispatcher->dispatch(XNavigationEvents::CREATE_DEFAULT_CONDITION, $event);

		\Controller::redirect(\Backend::addToUrl('key='));
	}

	public function pasteButton(\DataContainer $dc, $row, $table, $cr, $arrClipboard=null)
	{
		$html = '';


		if ($row['id'] > 0) {
			if ($row['pid'] > 0) {
				$parentCondition = ConditionModel::findByPk($row['pid']);
				$disabled        = $parentCondition->type != 'or' &&
					$parentCondition->type != 'and' &&
					($parentCondition->type != 'parent' || (bool) ConditionModel::findBy('pid', $row['id']));
			}
			else {
				$disabled = false;
			}

			if ($disabled) {
				$html .= \Image::getHtml(
					'pasteafter_.gif',
					sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id'])
				);
			}
			else {
				$html .= sprintf(
					'<a href="%s" title="%s" onclick="Backend.getScrollOffset()">%s</a> ',
					\Backend::addToUrl(
						'act=' . $arrClipboard['mode'] . '&amp;mode=1&amp;pid=' . $row['id'] . (!is_array($arrClipboard['id'])
							? '&amp;id=' . $arrClipboard['id'] : '')
					),
					specialchars(sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id'])),
					\Image::getHtml('pasteafter.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id']))
				);
			}
		}

		if (
			$row['id'] == 0 ||
			$row['type'] == 'or' ||
			$row['type'] == 'and' ||
			($row['type'] == 'parent' && !ConditionModel::findBy('pid', $row['id']))
		) {
			$html .= sprintf(
				'<a href="%s" title="%s" onclick="Backend.getScrollOffset()">%s</a> ',
				\Backend::addToUrl(
					'act=' . $arrClipboard['mode'] . '&amp;mode=2&amp;pid=' . $row['id'] . (!is_array($arrClipboard['id'])
						? '&amp;id=' . $arrClipboard['id'] : '')
				),
				specialchars(sprintf($GLOBALS['TL_LANG'][$table]['pasteinto'][1], $row['id'])),
				\Image::getHtml('pasteinto.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteinto'][1], $row['id']))
			);
		}
		else {
			$html .= \Image::getHtml('pasteinto_.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteinto'][1], $row['id']));
		}

		return $html;
	}

	public function getLabel($row, $label)
	{
		try {
			$type  = $GLOBALS['TL_LANG']['xnavigation_condition'][$row['type']][0];
			$title = $row['title'];

			$factory        = new ConditionFactory();
			$conditionModel = ConditionModel::findByPk($row['id']);
			$condition      = $factory->create($conditionModel);
			$describe       = $condition->describe();

			$html = sprintf(
				'<span style="color:#b3b3b3;padding-left:3px">%s</span> <span class="condition_describe">%s</span>',
				$type,
				$describe
			);

			if ($title) {
				$html = sprintf('%s<div style="text-indent:-23px">%s</div>', $title, $html);
			}
		}
		catch (\Exception $e) {
			$html = $e->getMessage();
		}

		return $html;
	}
}
