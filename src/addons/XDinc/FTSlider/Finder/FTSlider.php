<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Finder;

use XF\Mvc\Entity\Finder;

class FTSlider extends Finder
{
	public function searchTitle($match, $prefixMatch = false)
	{
		if ($match)
		{
			$this->whereOr(
				[
					$this->expression('CONVERT (%s USING utf8)', 'ftslider_title'),
					'LIKE',
					$this->escapeLike($match, $prefixMatch ? '?%' : '%?%')
				],
				[
					$this->expression('CONVERT (%s USING utf8)', 'Thread.title'),
					'LIKE',
					$this->escapeLike($match, $prefixMatch ? '?%' : '%?%')
				]
			);
		}

		return $this;
	}
}