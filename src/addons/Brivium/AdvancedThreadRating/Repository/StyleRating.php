<?php

namespace Brivium\AdvancedThreadRating\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class StyleRating extends Repository
{
	public function findStyleRatings()
	{
		return $this->finder('Brivium\AdvancedThreadRating:StyleRating')->fetch();
	}

	public function getStyleRatingCss()
	{
		$styleRating = $this->finder('Brivium\AdvancedThreadRating:StyleRating')->where('status', 1)->fetchOne();
		if($styleRating)
		{
			return [
				'url' => $styleRating->getIconUrl(),
				'width' =>  $styleRating->icon_width,
				'height' =>  $styleRating->icon_height,
				'background_posission_x' =>  $styleRating->icon_width - $styleRating->image_width,
				'background_position' =>  -$styleRating->icon_second_position,
			];
		}
	}

	public function updateDefaultStyleRating($styleRatingId)
	{
		$db = $this->db();

		$db->update('xf_brivium_style_rating', ['status' => 0], '1=1');
		if(!empty($styleRatingId))
		{
			$db->update('xf_brivium_style_rating', ['status' => 1], 'style_rating_id = ?', $styleRatingId);
			$this->repository('XF:Style')->updateAllStylesLastModifiedDate();
		}
	}
}