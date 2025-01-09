<?php

namespace FS\UserCarDetails\Repository;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

/**
 * Class Currency
 * @package DBTech\Credits\Repository
 */
class Models extends Repository
{

	public function getModels()
	{
		$models = \XF::app()->finder('FS\UserCarDetails:Model')->fetch();


		return count($models) ? $models : [];
	}
}
