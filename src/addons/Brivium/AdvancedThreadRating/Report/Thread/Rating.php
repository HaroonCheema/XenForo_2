<?php
namespace Brivium\AdvancedThreadRating\Report\Thread;

use XF\Entity\Report;

class Rating extends \XF\Report\AbstractHandler
{
	protected function canViewContent(Report $report)
	{
		return \XF::visitor()->hasNodePermission($report->content_info['node_id'], 'view');
	}

	protected function canActionContent(Report $report)
	{
		$visitor = \XF::visitor();
		$nodeId = $report->content_info['node_id'];
		return ($visitor->hasNodePermission($nodeId, 'BRATR_editRated')
			|| $visitor->hasNodePermission($nodeId, 'BRATR_softDeleteAnyRated')
			|| $visitor->hasNodePermission($nodeId, 'BRATR_hardDeleteAnyRated')
		);
	}

	public function setupReportEntityContent(Report $report, \XF\Mvc\Entity\Entity $content)
	{
		if (!empty($content->Thread->prefix_id))
		{
			$threadTitle = $content->Thread->Prefix->title . ' - ' . $content->Thread->title;
		}
		else
		{
			$threadTitle = $content->Thread->title;
		}

		/** @var \XF\Entity\Post $content */
		$report->content_user_id = $content->user_id;
		$report->content_info = [
			'message' => $content->message,
			'node_id' => $content->Thread->Forum->Node->node_id,
			'node_name' => $content->Thread->Forum->Node->node_name,
			'node_title' => $content->Thread->Forum->Node->title,
			'thread_rating_id' => $content->thread_rating_id,
			'thread_id' => $content->thread_id,
			'thread_title' => $threadTitle,
			'user_id' => $content->user_id,
			'username' => $content->username
		];
	}

	public function getContentTitle(Report $report)
	{
		return \XF::phrase('BRATR_rating_in_thread_x', [
			'title' => \XF::app()->stringFormatter()->censorText($report->content_info['thread_title'])
		]);
	}

	public function getContentMessage(Report $report)
	{
		return $report->content_info['message'];
	}

	public function getContentLink(Report $report)
	{
		return \XF::app()->router('public')->buildLink('canonical:bratr-ratings', $report->content_info);
	}

	public function getEntityWith()
	{
		return ['Thread', 'Thread.Forum', 'User'];
	}
}