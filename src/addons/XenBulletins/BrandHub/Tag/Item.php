<?php

namespace  XenBulletins\BrandHub\Tag;

use XF\Mvc\Entity\Entity;
use XF\Tag\AbstractHandler;

class Item extends AbstractHandler
{
	public function getPermissionsFromContext(Entity $entity)
	{
		if ($entity instanceof \XenBulletins\BrandHub\Entity\Item)
		{
			$item = $entity;
		}
		else
		{
			throw new \InvalidArgumentException("Entity must be a item (brand-hub item)");
		}

		$visitor = \XF::visitor();

		if ($item)
		{
			$edit = $item->canEditTags();
		}
		else
		{
			$edit = false;
		}

		return [
			'edit' => $edit,
			'removeOthers' => false,
			'minTotal' => 0 // add global option for this
		];
	}

	public function getContentDate(Entity $entity)
	{
		return $entity->create_date;
	}

	public function getContentVisibility(Entity $entity)
	{
		return $entity->item_state == 'visible';
	}

	public function getTemplateData(Entity $entity, array $options = [])
	{
		return [
			'item' => $entity,
			'options' => $options
		];
	}

	public function getEntityWith($forView = false)
	{
		$get = ['Brand'];
		if ($forView)
		{
			$get[] = 'User';
		}

		return $get;
	}

//	public function canUseInlineModeration(Entity $entity, &$error = null)
//	{
//		return $entity->canUseInlineModeration($error);
//	}
}