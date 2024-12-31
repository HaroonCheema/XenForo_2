<?php

namespace OzzModz\Badges\Finder;

class Badge extends \XF\Mvc\Entity\Finder
{
	public function onlyActive()
	{
		$this->where('active', '=', 1);
		return $this;
	}
}