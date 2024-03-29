<?php

namespace XenBulletins\BrandHub\Repository;

use XF\Mvc\Entity\Repository;

class Brand extends Repository 
{
     
        public function logBrandView(\XenBulletins\BrandHub\Entity\Brand $brand)
	{
		$this->db()->query("
			INSERT INTO bh_brand_view
				(brand_id, total)
			VALUES
				(? , 1)
			ON DUPLICATE KEY UPDATE
				total = total + 1
		", $brand->brand_id);
	}

	public function batchUpdateBrandViews()
	{
		$db = $this->db();
		$db->query("
			UPDATE bh_brand AS b
			INNER JOIN bh_brand_view AS bv ON (b.brand_id = bv.brand_id)
			SET b.view_count = b.view_count + bv.total
		");
		$db->emptyTable('bh_brand_view');
	}
  
}