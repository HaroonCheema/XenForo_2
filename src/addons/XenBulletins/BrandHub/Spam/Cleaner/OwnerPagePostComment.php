<?php

namespace XenBulletins\BrandHub\Spam\Cleaner;

use XF\Spam\Cleaner\AbstractHandler;

class OwnerPagePostComment extends AbstractHandler
{
	public function canCleanUp(array $options = [])
	{
		return !empty($options['delete_messages']);
	}

	public function cleanUp(array &$log, &$error = null)
	{
		$app = \XF::app();

		$ownerPagePostCommentsFinder = $app->finder('XenBulletins\BrandHub:OwnerPagePostComment');
		$ownerPagePostComments = $ownerPagePostCommentsFinder
			->where('user_id', $this->user->user_id)
			->fetch();

		if ($ownerPagePostComments->count())
		{
			$ownerPagePostCommentIds = $ownerPagePostComments->pluckNamed('post_comment_id');
			$submitter = $app->container('spam.contentSubmitter');
			$submitter->submitSpam('bh_ownerPage_post_comment', $ownerPagePostCommentIds);

			$deleteType = $app->options()->spamMessageAction == 'delete' ? 'hard' : 'soft';

			$log['bh_ownerPage_post_comment'] = [
				'deleteType' => $deleteType,
				'ownerPagePostCommentIds' => []
			];

			foreach ($ownerPagePostComments AS $ownerPagePostCommentId => $ownerPagePostComment)
			{
				$log['bh_ownerPage_post_comment']['ownerPagePostCommentIds'][] = $ownerPagePostCommentId;

                                /** @var \XenBulletins\BrandHub\Entity\OwnerPagePostComment $ownerPagePostComment */
				$ownerPagePostComment->setOption('log_moderator', false);
				if ($deleteType == 'soft')
				{
					$ownerPagePostComment->softDelete();
				}
				else
				{
					$ownerPagePostComment->delete();
				}
			}
		}

		return true;
	}

	public function restore(array $log, &$error = null)
	{
                $ownerPagePostCommentsFinder = \XF::app()->finder('XenBulletins\BrandHub:OwnerPagePostComment');

		if ($log['deleteType'] == 'soft')
		{
			$ownerPagePostComments = $ownerPagePostCommentsFinder->where('post_comment_id', $log['ownerPagePostCommentIds'])->fetch();
			foreach ($ownerPagePostComments AS $ownerPagePostComment)
			{
				/** @var \XenBulletins\BrandHub\Entity\OwnerPagePostComment $ownerPagePostComment */
				$ownerPagePostComment->setOption('log_moderator', false);
				$ownerPagePostComment->message_state = 'visible';
				$ownerPagePostComment->save();
			}
		}

		return true;
	}
}