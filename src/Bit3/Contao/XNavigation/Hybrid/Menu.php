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
use Bit3\Contao\XNavigation\Model\ConditionModel;
use Bit3\Contao\XNavigation\Model\MenuModel;
use Bit3\Contao\XNavigation\Model\ProviderModel;
use Bit3\Contao\XNavigation\ProviderFactory;
use Bit3\Contao\XNavigation\ConditionFactory;
use Bit3\Contao\XNavigation\XNavigationEvents;
use Bit3\FlexiTree\EventDrivenItemFactory;
use Bit3\FlexiTree\ItemCollection;
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

		$conditionFactory = new ConditionFactory();

		// evaluate the root item

		$event                 = new EvaluateRootEvent($menu);
		$globalEventDispatcher = $this->getGlobalEventDispatcher();
		$globalEventDispatcher->dispatch(EVENT_XNAVIGATION_EVALUATE_ROOT, $event);

		if ($event->getItemType() === null || $event->getItemName() === null) {
			return;
		}

		if ($this->xnavigation_template) {
			$this->Template->xnav_template = $this->xnavigation_template;
		}

		// create item condition
		$this->createItemCondition($menu, $conditionFactory);

		// create item link condition
		$this->createItemLinkCondition($menu, $conditionFactory);

		// create the item structure
		$this->createItems($menu, $event->getItemType(), $event->getItemName());

		$this->Template->menu = $menu;
	}

	/**
	 * Create the item condition and assign to the template.
	 *
	 * @param MenuModel    $menu
	 * @param ConditionFactory $conditionFactory
	 */
	protected function createItemCondition(MenuModel $menu, ConditionFactory $conditionFactory)
	{
		$this->Template->item_condition = $this->createCondition($menu->item_condition, $menu, $conditionFactory);
	}

	/**
	 * Create the item link condition and assign to the template.
	 *
	 * @param MenuModel    $menu
	 * @param ConditionFactory $conditionFactory
	 */
	protected function createItemLinkCondition(MenuModel $menu, ConditionFactory $conditionFactory)
	{
		$this->Template->link_condition = $this->createCondition($menu->link_condition, $menu, $conditionFactory);
	}

	protected function createCondition($conditionId, MenuModel $menu, ConditionFactory $conditionFactory)
	{
		$conditionModel = ConditionModel::findByPk($conditionId);

		if ($conditionModel) {
			return $conditionFactory->create($conditionModel);
		}

		return null;
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
			XNavigationEvents::CREATE_ITEM,
			XNavigationEvents::COLLECT_ITEMS
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
