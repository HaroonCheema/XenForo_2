<?php

namespace XenAddons\Showcase\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
	public function canViewShowcaseItems(&$error = null)
	{
		return $this->hasPermission('xa_showcase', 'view');
	}
	
	public function canViewShowcaseItemQueue(&$error = null)
	{
		if (!\XF::visitor()->is_moderator)
		{
			return false;
		}
	
		return $this->hasPermission('xa_showcase', 'viewDraft');
	}
	
	public function canViewShowcaseComments(&$error = null)
	{
		return $this->hasPermission('xa_showcase', 'viewComments');
	}

	public function canAddShowcaseItem(&$error = null)
	{
		if (!\XF::visitor()->user_id || !$this->hasPermission('xa_showcase','add'))
		{
			return false;
		}
		
		$maxItemCount = $this->hasPermission('xa_showcase','maxItemCount');
		$userItemCount = \XF::visitor()->xa_sc_item_count;
		
		if ($maxItemCount == -1 || $maxItemCount == 0) // unlimited NOTE: in this particular case, we want 0 to count as unlimited.
		{
			return true;
		}
		
		if ($userItemCount < $maxItemCount)
		{
			return true;
		}
		
		return false;
	}
	
	public function hasShowcaseItemPermission($permission)
	{
		return $this->hasPermission('xa_showcase', $permission);
	}

	public function hasShowcaseItemCategoryPermission($contentId, $permission)
	{
		return $this->PermissionSet->hasContentPermission('sc_category', $contentId, $permission); 
	}

	public function cacheShowcaseItemCategoryPermissions(array $categoryIds = null)
	{
		if (is_array($categoryIds))
		{
			\XF::permissionCache()->cacheContentPermsByIds($this->permission_combination_id, 'sc_category', $categoryIds);
		}
		else
		{
			\XF::permissionCache()->cacheAllContentPerms($this->permission_combination_id, 'sc_category');
		}
	}

	public static function getStructure(Structure $structure)
	{
		$structure = parent::getStructure($structure);

		$structure->columns['xa_sc_item_count'] = ['type' => self::UINT, 'default' => 0, 'forced' => true, 'changeLog' => false];
		$structure->columns['xa_sc_comment_count'] = ['type' => self::UINT, 'default' => 0, 'forced' => true, 'changeLog' => false];
		
		return $structure;
	}
}