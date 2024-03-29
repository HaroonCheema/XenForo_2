<?php

namespace XenBulletins\BrandHub\Service\OwnerPagePost;

use XenBulletins\BrandHub\Entity\OwnerPagePost;
use XF\Service\AbstractService;

class Notifier extends AbstractService
{
	protected $ownerPagePost;

	protected $notifyInsert;
	protected $notifyMentioned = [];

	protected $usersAlerted = [];

	public function __construct(\XF\App $app, OwnerPagePost $ownerPagePost)
	{
		parent::__construct($app);

		$this->ownerPagePost = $ownerPagePost;
	}

	public function getNotifyInsert()
	{
		if ($this->notifyInsert === null)
		{
			$this->notifyInsert = [$this->ownerPagePost->OwnerPage->user_id];
//                        $this->notifyInsert = [$this->profilePost->profile_user_id];
		}
		return $this->notifyInsert;
	}

	public function setNotifyMentioned(array $mentioned)
	{
		$this->notifyMentioned = array_unique($mentioned);
	}

	public function getNotifyMentioned()
	{
		return $this->notifyMentioned;
	}

	public function notify()
	{
		$notifiableUsers = $this->getUsersForNotification();

		$insertUsers = $this->getNotifyInsert();
		foreach ($insertUsers AS $userId)
		{
			if (isset($notifiableUsers[$userId]))
			{
				$this->sendNotification($notifiableUsers[$userId], 'insert');
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
	}

	protected function getUsersForNotification()
	{
		$userIds = array_merge(
			$this->getNotifyInsert(),
			$this->getNotifyMentioned()
		);

		$ownerPagePost = $this->ownerPagePost;
		$users = $this->app->em()->findByIds('XF:User', $userIds, ['Profile', 'Option']);
		if (!$users->count())
		{
			return [];
		}

		$users = $users->toArray();
		foreach ($users AS $id => $user)
		{
			/** @var \XF\Entity\User $user */
			$canView = \XF::asVisitor($user, function() use ($ownerPagePost) { return $ownerPagePost->canView(); });
			if (!$canView)
			{
				unset($users[$id]);
			}
		}

		return $users;
	}

	protected function sendNotification(\XF\Entity\User $user, $action)
	{
		$ownerPagePost = $this->ownerPagePost;
		if ($user->user_id == $ownerPagePost->user_id)
		{
			return false;
		}

		if (empty($this->usersAlerted[$user->user_id]))
		{
			/** @var \XF\Repository\UserAlert $alertRepo */
			$alertRepo = $this->app->repository('XF:UserAlert');
			$alerted = $alertRepo->alert(
				$user,
				$ownerPagePost->user_id,
				$ownerPagePost->username,
				'bh_ownerPage_post',
				$ownerPagePost->post_id,
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