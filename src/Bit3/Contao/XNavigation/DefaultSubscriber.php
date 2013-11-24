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

use Bit3\Contao\XNavigation\Event\EvaluateRootEvent;
use Bit3\FlexiTree\Event\CollectItemsEvent;
use Bit3\FlexiTree\Event\CreateItemEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DefaultSubscriber
 */
class DefaultSubscriber implements EventSubscriberInterface
{
	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			EVENT_XNAVIGATION_EVALUATE_ROOT => 'evaluateRoot',
		);
	}

	public function evaluateRoot(EvaluateRootEvent $event)
	{
		$menu = $event->getMenuModel();

		if ($menu->root == 'page') {
			switch ($menu->page_root) {
				case 'root':
					$event->setItemName($this->getCurrentPage()->rootId);
					break;

				case 'parent':
					$event->setItemName($this->getCurrentPage()->pid);
					break;

				case 'current':
					$event->setItemName($this->getCurrentPage()->id);
					break;

				case 'level':
					$level = $menu->page_root_level;
					$trail = $this->getCurrentPage()->trail;
					$pageId = isset($trail[$level])
						? $trail[$level]
						: - 1;
					$event->setItemName($pageId);
					break;

				case 'custom':
					$event->setItemName($menu->page_root_id);
					break;

				default:
					return;
			}

			$event->setItemType('page');
			$event->stopPropagation();
		}
	}

	/**
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 * @return \PageModel
	 */
	protected function getCurrentPage()
	{
		return $GLOBALS['objPage'];
	}
}
