<?php

namespace XenBulletins\BrandHub\Spam\Cleaner;

use XF\Spam\Cleaner\AbstractHandler;

class OwnerPagePost extends AbstractHandler
{
	public function canCleanUp(array $options = [])
	{
		return !empty($options['delete_messages']);
	}

	public function cleanUp(array &$log, &$error = null)
	{
		$app = \XF::app();

		$ownerPagePostsFinder = $app->finder('XenBulletins\BrandHub:OwnerPagePost');
		$ownerPagePosts = $ownerPagePostsFinder
			->where('user_id', $this->user->user_id)
			->fetch();

		if ($ownerPagePosts->count())
		{
			$ownerPagePostIds = $ownerPagePosts->pluckNamed('post_id');
			$submitter = $app->container('spam.contentSubmitter');
			$submitter->submitSpam('bh_ownerPage_post', $ownerPagePostIds);

			$deleteType = $app->options()->spamMessageAction == 'delete' ? 'hard' : 'soft';

			$log['bh_ownerPage_post'] = [
				'deleteType' => $deleteType,
				'ownerPagePostIds' => []
			];

			foreach ($ownerPagePosts AS $ownerPagePostId => $ownerPagePost)
			{
				$log['bh_ownerPage_post']['ownerPagePostIds'][] = $ownerPagePostId;

				/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost */
				$ownerPagePosts->setOption('log_moderator', false);
				if ($deleteType == 'soft')
				{
					$ownerPagePosts->softDelete();
				}
				else
				{
					$ownerPagePosts->delete();
				}
			}
		}

		return true;
	}

	public function restore(array $log, &$error = null)
	{
                $ownerPagePostsFinder = \XF::app()->finder('XenBulletins\BrandHub:OwnerPagePost');
                
		if ($log['deleteType'] == 'soft')
		{
			$ownerPagePosts = $ownerPagePostsFinder->where('post_id', $log['ownerPagePostIds'])->fetch();
			foreach ($ownerPagePosts AS $ownerPagePost)
			{
				/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost */
				$ownerPagePost->setOption('log_moderator', false);
				$ownerPagePost->message_state = 'visible';
				$ownerPagePost->save();
			}
		}

		return true;
	}
}