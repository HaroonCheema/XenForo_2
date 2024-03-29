<?php

namespace XenBulletins\BrandHub\Report;

use XF\Entity\Report;
use XF\Mvc\Entity\Entity;
use XF\Report\AbstractHandler;

class OwnerPagePost extends AbstractHandler
{
	protected function canViewContent(Report $report)
	{
		return \XF::visitor()->canViewOwnerPagePosts();
	}

	protected function canActionContent(Report $report)
	{
		$visitor = \XF::visitor();
		return ($visitor->hasPermission('ownerPagePost', 'editAny') || $visitor->hasPermission('ownerPagePost', 'deleteAny'));
	}

	public function setupReportEntityContent(Report $report, Entity $content)
	{
		/** @var \XF\Entity\Post $content */
		$report->content_user_id = $content->user_id;
		$report->content_info = [
			'message' => $content->message,
			'ownerPage' => [
                                'page_id' => $content->OwnerPage->page_id,
                                'title' => $content->OwnerPage->title,
                                'user_id' => $content->OwnerPage->user_id,
                                'item_id' => $content->OwnerPage->item_id,
//				'username' => $content->OwnerPage->title
			],
			'user' => [
				'user_id' => $content->user_id,
				'username' => $content->username
			],
			'post_id' => $content->post_id
		];
	}

	public function getContentTitle(Report $report)
	{
		if (isset($report->content_info['user']))
		{
			if ($report->content_info['user']['user_id'] == $report->content_info['ownerPage']['user_id'])
			{
				return \XF::phrase('owner_page_update_by_x', [
					'username' => $report->content_info['user']['username']
				]);
			}
			else
			{
				return \XF::phrase('owner_page_post_by_x', [
					'name' => $report->content_info['user']['username']
				]);
			}
		}
		else
		{
			return \XF::phrase('owner_page_post_for_x', [
//				'username' => $report->content_info['profile_username']
				'username' => $report->content_info['ownerPage']['title']
                                
			]);
		}
	}

	public function getContentMessage(Report $report)
	{
		return $report->content_info['message'];
	}

	public function getContentLink(Report $report)
	{
		if (isset($report->content_info['user']))
		{
			$linkData = $report->content_info;
		}
		else
		{
			$linkData = ['post_id' => $report->content_id];
		}

		return \XF::app()->router('public')->buildLink('canonical:owner-page-posts', $linkData);
	}

	public function getEntityWith()
	{
		return ['OwnerPage'];
	}
}