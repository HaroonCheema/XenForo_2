<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePostComment;

use XenBulletins\BrandHub\Entity\OwnerPagePostComment;
use XF\Service\AbstractService;

class Notifier extends AbstractService
{
	protected $comment;

	protected $notifyPageOwner;
	protected $notifyOwnerPagePostAuthor;
	protected $notifyMentioned = [];
	protected $notifyOtherCommenters;

	protected $usersAlerted = [];

	public function __construct(\XF\App $app, OwnerPagePostComment $comment)
	{
		parent::__construct($app);

		$this->comment = $comment;
	}

	public function getNotifyPageOwner()
	{
		if ($this->notifyPageOwner === null)
		{
			$this->notifyPageOwner = [$this->comment->OwnerPagePost->OwnerPage->user_id];
		}
		return $this->notifyPageOwner;
	}

	public function getNotifyOwnerPagePostAuthor()
	{
		if ($this->notifyOwnerPagePostAuthor === null)
		{
			$this->notifyOwnerPagePostAuthor = [$this->comment->OwnerPagePost->user_id];
		}
		return $this->notifyOwnerPagePostAuthor;
	}

	public function setNotifyMentioned(array $mentioned)
	{
		$this->notifyMentioned = array_unique($mentioned);
	}

	public function getNotifyMentioned()
	{
		return $this->notifyMentioned;
	}

	public function getNotifyOtherCommenters()
	{
		if ($this->notifyOtherCommenters === null && $this->comment->OwnerPagePost)
		{
			/** @var \XenBulletins\BrandHub\Repository\OwnerPagePost $repo */
			$repo = $this->repository('XenBulletins\BrandHub:OwnerPagePost');
			$comments = $repo->findOwnerPagePostComments($this->comment->OwnerPagePost, ['visibility' => false])
				->where('message_state', 'visible')
				->fetch();

			$this->notifyOtherCommenters = $comments->pluckNamed('user_id');
		}
		return $this->notifyOtherCommenters;
	}

	public function notify()
	{
		$notifiableUsers = $this->getUsersForNotification();

		$pageUserIds = $this->getNotifyPageOwner();
		foreach ($pageUserIds AS $userId)
		{
			if (isset($notifiableUsers[$userId]))
			{
				$this->sendNotification($notifiableUsers[$userId], 'your_owner_page');
			}
		}

		$ownerPagePostAuthors = $this->getNotifyOwnerPagePostAuthor();
		foreach ($ownerPagePostAuthors AS $userId)
		{
			if (isset($notifiableUsers[$userId]))
			{
				$this->sendNotification($notifiableUsers[$userId], 'your_post');
			}
		}

		$mentionUsers = $this->getNotifyMentioned();
		foreach ($mentionUsers AS $userId)
		{
			if (isset($notifiableUsers[$userId]))
			{
				$this->sendNotification($notifiableUsers[$userId], 'mention');
			}
		}

		$otherCommenters = $this->getNotifyOtherCommenters();
		foreach ($otherCommenters AS $userId)
		{
			if (isset($notifiableUsers[$userId]))
			{
				$this->sendNotification($notifiableUsers[$userId], 'other_commenter');
			}
		}
	}

	protected function getUsersForNotification()
	{
		$userIds = array_merge(
			$this->getNotifyPageOwner(),
			$this->getNotifyOwnerPagePostAuthor(),
			$this->getNotifyMentioned(),
			$this->getNotifyOtherCommenters()
		);

		$comment = $this->comment;

		$users = $this->app->em()->findByIds('XF:User', $userIds, ['Profile', 'Option']);
		if (!$users->count())
		{
			return [];
		}

		$users = $users->toArray();
		foreach ($users AS $id => $user)
		{
			/** @var \XF\Entity\User $user */
			$canView = \XF::asVisitor($user, function() use ($comment) { return $comment->canView(); });
			if (!$canView)
			{
				unset($users[$id]);
			}
		}

		return $users;
	}

	protected function sendNotification(\XF\Entity\User $user, $action)
	{
		$comment = $this->comment;
		if ($user->user_id == $comment->user_id)
		{
			return false;
		}

		if (empty($this->usersAlerted[$user->user_id]))
		{
			/** @var \XF\Repository\UserAlert $alertRepo */
			$alertRepo = $this->app->repository('XF:UserAlert');
			$alerted = $alertRepo->alert(
				$user,
				$comment->user_id,
				$comment->username,
				'bh_ownerPage_post_comment',
				$comment->post_comment_id,
				$action,
				[],
				['autoRead' => false]
			);
			if ($alerted)
			{
				$this->usersAlerted[$user->user_id] = true;
				return true;
			}
		}

		return false;
	}

}