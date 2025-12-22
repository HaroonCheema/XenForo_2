<?php

namespace EWR\Porta\Repository;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Repository;

class CatLink extends Repository
{
	public function findCatLink()
	{
		return $this->finder('EWR\Porta:CatLink')
			->with('Category', true)
			->order('Category.category_name');
	}
	
	public function updateCatlinksByThreadId($id, $rows)
	{
		foreach ($rows AS $key => &$row)
		{
			$row = [
				'category_id' => $row,
				'thread_id' => $id,
			];
		}
		
		$this->db()->delete('ewr_porta_catlinks', 'thread_id = ?', $id);
		
		if (!empty($rows))
		{
			$this->db()->insertBulk('ewr_porta_catlinks', $rows);
		}
		
		return;
	}
}