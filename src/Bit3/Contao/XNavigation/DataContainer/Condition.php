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
use Bit3\FlexiTree\Condition\AndCondition;

/**
 * Class Condition
 */
class Condition
{
	public function createDefault($dc)
	{
		// root node
		$root        = new ConditionModel();
		$root->type  = 'and';
		$root->title = 'Contao default condition (' . \Date::parse($GLOBALS['TL_CONFIG']['datimFormat']) . ')';
		$root->save();

		// root node child conditions
		{
			$condition       = new ConditionModel();
			$condition->pid  = $root->id;
			$condition->type = 'page_published';
			$condition->save();

			$condition                                 = new ConditionModel();
			$condition->pid                            = $root->id;
			$condition->type                           = 'page_hide';
			$condition->page_hide_accepted_hide_status = '';
			$condition->save();

			$loginStatus       = new ConditionModel();
			$loginStatus->pid  = $root->id;
			$loginStatus->type = 'or';
			$loginStatus->save();

			// login status child conditions
			{
				$condition                                     = new ConditionModel();
				$condition->pid                                = $loginStatus->id;
				$condition->type                               = 'member_login';
				$condition->member_login_accepted_login_status = 'logged_out';
				$condition->save();

				$condition                                     = new ConditionModel();
				$condition->pid                                = $loginStatus->id;
				$condition->type                               = 'page_guests';
				$condition->page_guests_accepted_guests_status = '';
				$condition->save();
			}
		}

		\Message::addConfirmation(
			sprintf($GLOBALS['TL_LANG']['tl_xnavigation_condition']['default_created'], $root->title)
		);
		\Controller::redirect(
			sprintf(
				'contao/main.php?do=xnavigation&table=tl_xnavigation_condition&rt=%s&ref=%s',
				REQUEST_TOKEN,
				TL_REFERER_ID
			)
		);
	}

	public function pasteButton(\DataContainer $dc, $row, $table, $cr, $arrClipboard = null)
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

		return $html;
	}
}
