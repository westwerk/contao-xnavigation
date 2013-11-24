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

namespace Bit3\Contao\XNavigation\Provider;

use Bit3\FlexiTree\Event\CollectItemsEvent;
use Bit3\FlexiTree\Event\CreateItemEvent;
use Contao\PageModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Page
 */
class PageProvider extends \Frontend implements EventSubscriberInterface
{
	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'create-item'   => 'createItem',
			'collect-items' => array('collectItems', 100),
		);
	}

	public function collectItems(CollectItemsEvent $event)
	{
		$item = $event->getParentItem();

		if ($item->getType() == 'page') {
			$pages = \PageModel::findPublishedSubpagesWithoutGuestsByPid($item->getName());

			if ($pages) {
				$factory = $event->getFactory();

				foreach ($pages as $page) {
					$factory->createItem('page', $page->id, $item);
				}
			}
		}
	}

	public function createItem(CreateItemEvent $event)
	{
		$item = $event->getItem();

		if ($item->getType() == 'page') {
			$page = \PageModel::findByPk($item->getName());

			if ($page) {
				$item->setUri($this->generateFrontendUrl($page->row()));
				$item->setLabel($page->title);

				if ($page->cssClass) {
					$class = $item->getAttribute('class', '');
					$item->setAttribute('class', trim($class . ' ' . $page->cssClass));
				}

				$item->setExtras($page->row());
				$item->setCurrent($this->getCurrentPage()->id == $page->id);
			}
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
