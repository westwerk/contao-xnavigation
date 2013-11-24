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
 * Class PageProtectedVoter
 */
class PageProtectedVoter implements VoterInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function matchItem(ItemInterface $item)
	{
		if ($item->getType() == 'page') {
			$protected = $item->getExtra('protected');
			if ($protected && !BE_USER_LOGGED_IN) {
				if (FE_USER_LOGGED_IN) {
					return true;
				}
				$groups = deserialize($item->getExtra('groups', array()));
				$member = \FrontendUser::getInstance();
				foreach ($groups as $group) {
					if ($member->isMemberOf($group)) {
						return true;
					}
				}
				return 'never';
			}

			return true;
		}

		return null;
	}
}
