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

namespace Bit3\Contao\XNavigation\Voter;

use Bit3\FlexiTree\ItemInterface;
use Bit3\FlexiTree\Matcher\Voter\VoterInterface;

/**
 * Class PageSitemapVoter
 */
class PageSitemapVoter implements VoterInterface
{
	/**
	 * @var bool
	 */
	protected $acceptedSitemapStatus;

	public function __construct(array $acceptedSitemapStatus = array())
	{
		$this->acceptedSitemapStatus = $acceptedSitemapStatus;
	}

	/**
	 * @param boolean $acceptedSitemapStatus
	 */
	public function setAcceptedSitemapStatus(array $acceptedSitemapStatus)
	{
		$this->acceptedSitemapStatus = $acceptedSitemapStatus;
		return $this;
	}

	/**
	 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
	 * @return boolean
	 */
	public function getAcceptedSitemapStatus()
	{
		return $this->acceptedSitemapStatus;
	}

	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		if ($item->getType() == 'page') {
			$sitemap = $item->getExtra('sitemap');
			if (!in_array($sitemap, $this->acceptedSitemapStatus)) {
				return 'never';
			}
			else {
				return true;
			}
		}

		return null;
	}
}
