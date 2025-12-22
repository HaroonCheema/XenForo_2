<?php

namespace EWR\Porta\Repository;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Repository;

class Category extends Repository
{
	public function findCategory()
	{
		return $this->finder('EWR\Porta:Category')
			->order('category_name');
	}
}