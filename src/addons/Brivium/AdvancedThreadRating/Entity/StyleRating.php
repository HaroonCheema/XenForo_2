<?php
namespace Brivium\AdvancedThreadRating\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class StyleRating extends Entity
{

	public function getIconHtml()
	{
		return sprintf('<img src="%s" />', $this->getIconUrl());
	}
	public function getIconFilePath()
	{
		return sprintf('data://brivium/AdvancedThreadRating/%d/%d.jpg', floor($this->style_rating_id / 1000), $this->style_rating_id);
	}

	public function getIconUrl()
	{
		$app = $this->app();
		return $app->applyExternalDataUrl(sprintf('brivium/AdvancedThreadRating/%d/%d.jpg?%d', floor($this->style_rating_id / 1000), $this->style_rating_id, $this->style_date));
	}

	protected function _postDelete()
	{
		$iconService = $this->app()->service('Brivium\AdvancedThreadRating:Rating\Icon', $this);
		$iconService->deleteIcon();
	}
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_brivium_style_rating';
		$structure->shortName = 'Brivium\AdvancedThreadRating:StyleRating';
		$structure->primaryKey = 'style_rating_id';
		$structure->columns = [
			'style_rating_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'image_width' => ['type' => self::UINT, 'default' => 0],
			'image_height' => ['type' => self::UINT, 'default' => 0],
			'icon_width' => ['type' => self::UINT, 'required' => 0],
			'icon_height' => ['type' => self::UINT, 'required' => 0],
			'icon_second_position' => ['type' => self::UINT, 'required' => 0],
			'style_date' => ['type' => self::UINT, 'default' => \XF::$time],
			'status' => ['type' => self::BOOL, 'default' => 0],
		];
		return $structure;
	}
}