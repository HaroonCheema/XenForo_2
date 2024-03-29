<?php

namespace XenBulletins\BrandHub\Repository;

use XF\Mvc\Entity\Repository;

class OwnerPagePost extends Repository
{
	public function findOwnerPagePostsOnOwnerPage(\XenBulletins\BrandHub\Entity\OwnerPage $ownerPage, array $limits = [])
	{
		/** @var \XenBulletins\BrandHub\Finder\OwnerPagePost $finder */
		$finder = $this->finder('XenBulletins\BrandHub:OwnerPagePost');
		$finder
			->onOwnerPage($ownerPage, $limits)
			->order('post_date', 'DESC');

		return $finder;
	}

	/**
	 * @param \XenBulletins\BrandHub\Entity\OwnerPage $ownerPage
	 * @param $newerThan
	 * @param array $limits
	 *
	 * @return \XenBulletins\BrandHub\Finder\OwnerPagePost
	 */
	public function findNewestOwnerPagePostsOnOwnerPage(\XenBulletins\BrandHub\Entity\OwnerPage $ownerPage, $newerThan, array $limits = [])
	{
		/** @var \XenBulletins\BrandHub\Finder\OwnerPagePost $finder */
		$finder = $this->findNewestOwnerPagePosts($newerThan)
			->onOwnerPage($ownerPage, $limits);

		return $finder;
	}

	/**
	 * @param $newerThan
	 *
	 * @return \XenBulletins\BrandHub\Finder\OwnerPagePost
	 */
	public function findNewestOwnerPagePosts($newerThan)
	{
		/** @var \XenBulletins\BrandHub\Finder\OwnerPagePost $finder */
		$finder = $this->finder('XenBulletins\BrandHub:OwnerPagePost');
		$finder
			->newerThan($newerThan)
			->order('post_date', 'DESC');

		return $finder;
	}

	/**
	 * @param \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost
	 * @param array $limits
	 *
	 * @return \XenBulletins\BrandHub\Finder\OwnerPagePostComment
	 */
	public function findOwnerPagePostComments(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost, array $limits = [])
	{
		/** @var \XenBulletins\BrandHub\Finder\OwnerPagePostComment $commentFinder */
		$commentFinder = $this->finder('XenBulletins\BrandHub:OwnerPagePostComment');
		$commentFinder->setDefaultOrder('comment_date');
		$commentFinder->forOwnerPagePost($ownerPagePost, $limits);

		return $commentFinder;
	}

	public function findNewestCommentsForOwnerPagePost(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost, $newerThan, array $limits = [])
	{
		/** @var \XenBulletins\BrandHub\Finder\OwnerPagePostComment $commentFinder */
		$commentFinder = $this->finder('XenBulletins\BrandHub:OwnerPagePostComment');
		$commentFinder
			->setDefaultOrder('comment_date', 'DESC')
			->forOwnerPagePost($ownerPagePost, $limits)
			->newerThan($newerThan);

		return $commentFinder;
	}

	/**
	 * @param \XF\Mvc\Entity\AbstractCollection|\XenBulletins\BrandHub\Entity\OwnerPagePost[] $ownerPagePosts
	 * @param bool $skipUnfurlRecrawl
	 *
	 * @return \XF\Mvc\Entity\AbstractCollection|\XenBulletins\BrandHub\Entity\OwnerPagePost[]
	 */
	public function addCommentsToOwnerPagePosts($ownerPagePosts, $skipUnfurlRecrawl = false)
	{
		/** @var \XF\Repository\Attachment $attachmentRepo */
		$attachmentRepo = $this->repository('XF:Attachment');

		$commentFinder = $this->finder('XenBulletins\BrandHub:OwnerPagePostComment');

		$visitor = \XF::visitor();

		$ids = [];
		foreach ($ownerPagePosts AS $ownerPagePostId => $ownerPagePost)
		{
			$commentIds = $ownerPagePost->latest_comment_ids;
			foreach ($commentIds AS $commentId => $state)
			{
				$commentId = intval($commentId);

				switch ($state[0])
				{
					case 'visible':
						$ids[] = $commentId;
						break;

					case 'moderated':
						if ($ownerPagePost->canViewModeratedComments())
						{
							// can view all moderated comments
							$ids[] = $commentId;
						}
						else if ($visitor->user_id && $visitor->user_id == $state[1])
						{
							// can view your own moderated comments
							$ids[] = $commentId;
						}
						break;

					case 'deleted':
						if ($ownerPagePost->canViewDeletedComments())
						{
							$ids[] = $commentId;

							$commentFinder->with('DeletionLog');
						}
						break;
				}
			}
		}

		if ($ids)
		{
			$commentFinder->with('full');

			$comments = $commentFinder
				->where('post_comment_id', $ids)
				->order('comment_date')
				->fetch();

			/** @var \XF\Repository\Unfurl $unfurlRepo */
			$unfurlRepo = $this->repository('XF:Unfurl');
			$unfurlRepo->addUnfurlsToContent($comments, $skipUnfurlRecrawl);

			$attachmentRepo->addAttachmentsToContent($comments, 'bh_ownerPage_post_comment');

			$comments = $comments->groupBy('post_id');

			foreach ($ownerPagePosts AS $ownerPagePostId => $ownerPagePost)
			{
				$ownerPagePostComments = $comments[$ownerPagePostId] ?? [];
				$ownerPagePostComments = $this->em->getBasicCollection($ownerPagePostComments)
					->filterViewable()
					->slice(-3, 3);

				$ownerPagePost->setLatestComments($ownerPagePostComments->toArray());
			}
		}

		return $ownerPagePosts;
	}

	public function addCommentsToOwnerPagePost(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost)
	{
		$id = $ownerPagePost->post_id;
		$result = $this->addCommentsToOwnerPagePosts([$id => $ownerPagePost]);
		return $result[$id];
	}

	public function getLatestCommentCache(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost)
	{
		$comments = $this->finder('XenBulletins\BrandHub:OwnerPagePostComment')
			->where('post_id', $ownerPagePost->post_id)
			->order('comment_date', 'DESC')
			->limit(20)
			->fetch();

		$visCount = 0;
		$latestComments = [];

		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePostComment  $comment */
		foreach ($comments AS $commentId => $comment)
		{
			if ($comment->message_state == 'visible')
			{
				$visCount++;
			}

			$latestComments[$commentId] = [$comment->message_state, $comment->user_id];

			if ($visCount === 3)
			{
				break;
			}
		}

		return array_reverse($latestComments, true);
	}

	public function sendModeratorActionAlert(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost, $action, $reason = '', array $extra = [])
	{
		if (!$ownerPagePost->user_id || !$ownerPagePost->User)
		{
			return false;
		}

		$router = $this->app()->router('public');

		$extra = array_merge([
			'profileUserId' => $ownerPagePost->OwnerPage->user_id,
			'profileUser' => $ownerPagePost->OwnerPage ? $ownerPagePost->OwnerPage->User->username : '',
			'profileLink' => $router->buildLink('nopath:owners', $ownerPagePost->OwnerPage),
			'link' => $router->buildLink('nopath:owner-page-posts', $ownerPagePost),
			'reason' => $reason
		], $extra);

		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = $this->repository('XF:UserAlert');
		$alertRepo->alert(
			$ownerPagePost->User,
			0, '',
			'user', $ownerPagePost->user_id,
			"owner_page_post_{$action}", $extra
		);

		return true;
	}

	public function sendCommentModeratorActionAlert(\XenBulletins\BrandHub\Entity\OwnerPagePostComment $comment, $action, $reason = '', array $extra = [])
	{
		if (!$comment->user_id || !$comment->User)
		{
			return false;
		}

		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost */
		$ownerPagePost = $comment->OwnerPagePost;
		if (!$ownerPagePost)
		{
			return false;
		}

		$router = $this->app()->router('public');

		$extra = array_merge([
			'profileUserId' => $ownerPagePost->OwnerPage->user_id,
			'profileUser' => $ownerPagePost->OwnerPage ? $ownerPagePost->OwnerPage->User->username : '',
			'postUserId' => $ownerPagePost->user_id,
			'postUser' => $ownerPagePost->User ? $ownerPagePost->User->username : '',
			'link' => $router->buildLink('nopath:owner-page-posts/comments', $comment),
			'profileLink' => $router->buildLink('nopath:owners', $ownerPagePost->OwnerPage),
			'profilePostLink' => $router->buildLink('nopath:owner-page-posts', $ownerPagePost),
			'reason' => $reason
		], $extra);

		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = $this->repository('XF:UserAlert');
		$alertRepo->alert(
			$comment->User,
			0, '',
			'user', $comment->user_id,
			"owner_page_post_comment_{$action}", $extra
		);

		return true;
	}
}