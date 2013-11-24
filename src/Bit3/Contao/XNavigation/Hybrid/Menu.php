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

namespace Bit3\Contao\XNavigation\Hybrid;

use Bit3\Contao\XNavigation\Event\EvaluateRootEvent;
use Bit3\Contao\XNavigation\Model\FilterModel;
use Bit3\Contao\XNavigation\Model\MenuModel;
use Bit3\Contao\XNavigation\Model\ProviderModel;
use Bit3\Contao\XNavigation\ProviderFactory;
use Bit3\Contao\XNavigation\VoterFactory;
use Bit3\FlexiTree\EventDrivenItemFactory;
use Bit3\FlexiTree\ItemCollection;
use Bit3\FlexiTree\Iterator\ItemFilterIterator;
use Bit3\FlexiTree\Iterator\RecursiveItemIterator;
use Bit3\FlexiTree\Matcher\Matcher;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Menu
 */
class Menu extends \TwigSimpleHybrid
{
	protected $strTemplate = 'xnavigation/mod_menu';

	/**
	 * Compile the current element
	 */
	protected function compile()
	{
		$menuId = $this->xnavigation_menu;
		$menu   = MenuModel::findByPk($menuId);

		if (!$menu) {
			return;
		}

		$voterFactory = new VoterFactory();

		// evaluate the root item

		$event                 = new EvaluateRootEvent($menu);
		$globalEventDispatcher = $this->getGlobalEventDispatcher();
		$globalEventDispatcher->dispatch(EVENT_XNAVIGATION_EVALUATE_ROOT, $event);

		if ($event->getItemType() === null || $event->getItemName() === null) {
			return;
		}

		// evaluate item filters and create matcher
		$this->createItemMatcher($menu, $voterFactory);

		// evaluate item link filters and create matcher
		$this->createLinkMatcher($menu, $voterFactory);

		// create the item structure
		$this->createItems($menu, $event->getItemType(), $event->getItemName());

		$this->Template->menu = $menu;
	}

	/**
	 * Create the item matcher and assign to the template.
	 *
	 * @param MenuModel    $menu
	 * @param VoterFactory $voterFactory
	 */
	protected function createItemMatcher(MenuModel $menu, VoterFactory $voterFactory)
	{
		$itemMatcher = new Matcher();

		$filterIds = deserialize($menu->item_filter, true);
		$filters   = FilterModel::findMultipleByIds($filterIds);
		if ($filters) {
			foreach ($filters as $filter) {
				$voter = $voterFactory->create($filter);
				$itemMatcher->addVoter($voter);
			}
		}

		$this->Template->itemMatcher = $itemMatcher->hasVoter() ? $itemMatcher : null;
	}

	/**
	 * Create the item link matcher and assign to the template.
	 *
	 * @param MenuModel    $menu
	 * @param VoterFactory $voterFactory
	 */
	protected function createLinkMatcher(MenuModel $menu, VoterFactory $voterFactory)
	{
		$linkMatcher = new Matcher();

		$filterIds = deserialize($menu->link_filter, true);
		$filters   = FilterModel::findMultipleByIds($filterIds);
		if ($filters) {
			foreach ($filters as $filter) {
				$voter = $voterFactory->create($filter);
				$linkMatcher->addVoter($voter);
			}
		}

		$this->Template->linkMatcher = $linkMatcher->hasVoter() ? $linkMatcher : null;
	}

	/**
	 * Create a local event dispatcher and fill with all providers.
	 *
	 * @param MenuModel       $menu
	 * @param ProviderFactory $providerFactory
	 *
	 * @return EventDispatcher
	 */
	protected function createLocalEventDispatcher(MenuModel $menu, ProviderFactory $providerFactory)
	{
		$eventDispatcher = new EventDispatcher();

		$providerIds = deserialize($menu->provider, true);
		$providers   = ProviderModel::findMultipleByIds($providerIds);
		if ($providers) {
			foreach ($providers as $provider) {
				$subscriber = $providerFactory->create($provider);
				$eventDispatcher->addSubscriber($subscriber);
			}
		}

		return $eventDispatcher;
	}

	/**
	 * Create the root item and items collection and assign to the template.
	 *
	 * @param MenuModel $menu
	 * @param string    $rootType
	 * @param string    $rootName
	 */
	protected function createItems(MenuModel $menu, $rootType, $rootName)
	{
		$providerFactory = new ProviderFactory();

		// create local event dispatcher and provider
		$eventDispatcher = $this->createLocalEventDispatcher($menu, $providerFactory);

		// create the event driven menu
		$eventDrivenItemFactory = new EventDrivenItemFactory(
			$eventDispatcher,
			'create-item',
			'collect-items'
		);

		// create the root item
		$item = $eventDrivenItemFactory->createItem($rootType, $rootName);

		// create the items collection
		if ($menu->include_root) {
			$collection = new ItemCollection();
			$collection->add($item);
		}
		else {
			$collection = $item->getChildren();
		}

		$this->Template->item  = $item;
		$this->Template->items = $collection;
	}

	/**
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 * @return EventDispatcher
	 */
	protected function getGlobalEventDispatcher()
	{
		return $GLOBALS['container']['event-dispatcher'];
	}
}
