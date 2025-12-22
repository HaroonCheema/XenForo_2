<?php

namespace EWR\Porta\Widget;

class Categories extends \XF\Widget\AbstractWidget
{
	public function render()
	{
		$categories = $this->db()->fetchAllKeyed("
			SELECT ewr_porta_categories.*, COUNT(ewr_porta_catlinks.thread_id) AS count
			FROM ewr_porta_categories
				LEFT JOIN ewr_porta_catlinks ON (ewr_porta_catlinks.category_id = ewr_porta_categories.category_id)
			GROUP BY ewr_porta_categories.category_id
			HAVING count > 0
			ORDER BY ewr_porta_categories.category_name ASC
		", 'category_id');
		
		return $this->renderer('widget_EWRporta_categories', ['categories' => $categories]);
	}

	public function getOptionsTemplate()
	{
		return null;
	}
}