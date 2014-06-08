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

namespace Bit3\Contao\XNavigation\Twig;

use Bit3\Contao\XNavigation\Event\GenerateItemClassesEvent;
use Bit3\Contao\XNavigation\XNavigationEvents;
use Bit3\FlexiTree\Condition\ConditionInterface;
use Bit3\FlexiTree\ItemCollectionInterface;
use Bit3\FlexiTree\ItemInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TwigExtension
 */
class TwigExtension extends \Twig_Extension
{
	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'xnavigation';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction(
				'xnav_list',
				array($this, 'listFunction'),
				array(
					'needs_environment' => true,
					'needs_context'     => true,
					'is_safe'           => array('html'),
				)
			),
			new \Twig_SimpleFunction(
				'xnav_item',
				array($this, 'itemFunction'),
				array(
					'needs_environment' => true,
					'needs_context'     => true,
					'is_safe'           => array('html'),
				)
			),
			new \Twig_SimpleFunction(
				'xnav_link',
				array($this, 'linkFunction'),
				array(
					'needs_environment' => true,
					'needs_context'     => true,
					'is_safe'           => array('html'),
				)
			),
			new \Twig_SimpleFunction(
				'xnav_label',
				array($this, 'labelFunction'),
				array(
					'needs_environment' => true,
					'needs_context'     => true,
					'is_safe'           => array('html'),
				)
			),
			new \Twig_SimpleFunction(
				'xnav_extend_attributes',
				array($this, 'extendAttributesFunction'),
				array(
					'is_safe' => array('html'),
				)
			),
			new \Twig_SimpleFunction(
				'xnav_render_attributes',
				array($this, 'renderAttributesFunction'),
				array(
					'needs_environment' => true,
					'is_safe'           => array('html'),
				)
			),
			new \Twig_SimpleFunction(
				'xnav_classes',
				array($this, 'classesFunction'),
				array(
					'needs_context' => true,
					'is_safe'       => array('html'),
				)
			),
			new \Twig_SimpleFunction(
				'xnav_link_is_visible',
				array($this, 'linkIsVisibleFunction'),
				array(
					'needs_context' => true,
				)
			),
		);
	}

	public function listFunction(
		\Twig_Environment $env,
		$context,
		$collection
	) {
		if ($collection instanceof ItemInterface) {
			$collection = $collection->getChildren();
		}

		if (!$collection instanceof ItemCollectionInterface) {
			$type = gettype($collection);
			if (is_object($collection)) {
				$type .= sprintf('[%s]', get_class($collection));
			}
			trigger_error(
				sprintf('First parameter of xnav_list must be an item or collection, %s given', $type),
				E_USER_WARNING
			);
			return '';
		}

		if (empty($context['xnav_template'])) {
			trigger_error(
				'There is no xnav_template defined in the context',
				E_USER_WARNING
			);
			return '';
		}

		/** @var \Twig_Template $template */
		$template = $env->loadTemplate($context['xnav_template']);

		$itemCondition = $context['item_condition'];

		$iterator = $collection->getIterator($itemCondition);
		$children = '';

		/** @var ItemInterface[] $items */
		$items = array();
		foreach ($iterator as $item) {
			$items[] = $item;
		}

		$count    = count($items);
		$index    = 0;

		foreach ($items as $item) {
			$context['loop'] = array(
				'index'     => $index + 1,
				'index0'    => $index,
				'revindex'  => $count - $index,
				'revindex0' => $count - $index - 1,
				'first'     => $index == 0,
				'last'      => $index == $count - 1,
				'length'    => $count,
			);
			$children .= trim($this->itemFunction($env, $context, $item));
			$index++;
		}

		if ($children) {
			$context['collection'] = $collection;
			$context['level']      = $collection->getParentItem()
				? $collection->getParentItem()
					->getLevel() + 1
				: 0;
			$context['items']      = $children;

			return $template->renderBlock('list', $context);
		}

		return '';
	}

	public function itemFunction(
		\Twig_Environment $env,
		$context,
		ItemInterface $item
	) {
		if (empty($context['xnav_template'])) {
			trigger_error(
				'There is no xnav_template defined in the context',
				E_USER_WARNING
			);
			return '';
		}

		/** @var \Twig_Template $template */
		$template = $env->loadTemplate($context['xnav_template']);

		$itemCondition = $context['item_condition'];

		if ($itemCondition && !$itemCondition->matchItem($item)) {
			return '';
		}

		$linkCondition = $context['link_condition'];

		$link = '';
		if (!$linkCondition || $linkCondition->matchItem($item)) {
			$link = $this->linkFunction(
				$env,
				$context,
				$item,
				$itemCondition,
				$linkCondition
			);
		}

		$children = $this->listFunction(
			$env,
			$context,
			$item->getChildren()
		);

		if (!$link && !$children) {
			return '';
		}

		$classes = $this->classesFunction($context, $item, (bool) $children);

		$context['item']            = $item;
		$context['link']           = $link;
		$context['children']        = $children;
		$context['item_classes']    = $classes;
		$context['item_attributes'] = $this->extendAttributesFunction(
			$item->getAttributes(),
			array('class' => implode(' ', $classes))
		);
		$context['level']           = $item->getLevel();

		return $template->renderBlock('item', $context);
	}

	public function linkIsVisibleFunction(
		$context,
		ItemInterface $item
	) {
		/** @var ConditionInterface $linkCondition */
		$linkCondition = $context['link_condition'];

		return !$linkCondition || $linkCondition->matchItem($item);
	}

	public function linkFunction(
		\Twig_Environment $env,
		$context,
		ItemInterface $item
	) {
		if (empty($context['xnav_template'])) {
			trigger_error(
				'There is no xnav_template defined in the context',
				E_USER_WARNING
			);
			return '';
		}

		/** @var \Twig_Template $template */
		$template = $env->loadTemplate($context['xnav_template']);

		/** @var ConditionInterface $linkCondition */
		$linkCondition = $context['link_condition'];

		if ($linkCondition && !$linkCondition->matchItem($item)) {
			return '';
		}

		$classes = $this->classesFunction($context, $item, !empty($context['children']));

		$context['item']             = $item;
		$context['item_classes']     = $classes;
		$context['link_attributes']  = $this->extendAttributesFunction(
			$item->getLinkAttributes(),
			array('class' => implode(' ', $classes))
		);
		$context['label_attributes'] = $this->extendAttributesFunction(
			$item->getLabelAttributes(),
			array('class' => implode(' ', $classes))
		);
		$context['level']            = $item->getLevel();
		$context['label']            = $this->labelFunction($env, $context, $item);

		if ($item->isCurrent()) {
			return $template->renderBlock('link_current', $context);
		}

		return $template->renderBlock('link', $context);
	}

	public function labelFunction(
		\Twig_Environment $env,
		$context,
		ItemInterface $item
	) {
		if (empty($context['xnav_template'])) {
			trigger_error(
				'There is no xnav_template defined in the context',
				E_USER_WARNING
			);
			return '';
		}

		/** @var \Twig_Template $template */
		$template = $env->loadTemplate($context['xnav_template']);

		$classes = $this->classesFunction($context, $item, !empty($context['children']));

		$context['item']             = $item;
		$context['level']            = $item->getLevel();
		$context['label_attributes'] = $this->extendAttributesFunction(
			$item->getLabelAttributes(),
			array('class' => implode(' ', $classes))
		);

		return $template->renderBlock('label', $context);
	}

	public function extendAttributesFunction(
		array $attributes,
		array $extendedAttributes = array(),
		array $fixedAttributes = array()
	) {
		foreach ($extendedAttributes as $key => $value) {
			if (isset($attributes[$key])) {
				$attributes[$key] .= ' ' . $value;
			}
			else {
				$attributes[$key] = $value;
			}
		}

		foreach ($fixedAttributes as $key => $value) {
			$attributes[$key] = $value;
		}

		return $attributes;
	}

	public function renderAttributesFunction(
		\Twig_Environment $env,
		array $attributes
	) {
		$builder = new \StringBuilder();

		foreach ($attributes as $key => $value) {
			$value = twig_escape_filter($env, $value, 'html_attr');

			$builder->append(' ');
			$builder->append($key);
			$builder->append('="');
			$builder->append($value);
			$builder->append('"');
		}

		return $builder->__toString();
	}

	public function classesFunction(
		$context,
		ItemInterface $item,
		$hasChildren
	) {
		$classes = array('level_' . $item->getLevel(), 'type_' . $item->getType());

		if ($item->isCurrent()) {
			$classes[] = 'active';
		}
		if ($item->isTrail()) {
			$classes[] = 'trail';
		}
		if ($hasChildren) {
			$classes[] = 'children';
		}
		if ($this->linkIsVisibleFunction($context, $item)) {
			$classes[] = 'show-link';
		}
		else {
			$classes[] = 'hide-link';
		}

		if (isset($context['loop'])) {
			if ($context['loop']['first']) {
				$classes[] = 'first';
			}
			if ($context['loop']['last']) {
				$classes[] = 'last';
			}
			$classes[] = 'item_' . $context['loop']['index'];
		}

		/** @var EventDispatcherInterface $eventDispatcher */
		$eventDispatcher = $GLOBALS['container']['event-dispatcher'];

		$event = new GenerateItemClassesEvent($item);
		$event->setClasses($classes);
		$eventDispatcher->dispatch(XNavigationEvents::GENERATE_ITEM_CLASSES, $event);

		return $event->getClasses();
	}
}
