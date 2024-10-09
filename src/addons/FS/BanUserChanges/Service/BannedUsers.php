<?php

namespace FS\BanUserChanges\Service;

use XF\Mvc\Controller;

use XF\Mvc\FormAction;

class BannedUsers extends \XF\Service\AbstractService
{

	public function banLiftDeletePosts(\XF\Entity\User $user)
	{

		$bannedUserthread = $user->Ban->Thread;

		if ($bannedUserthread) {

			// $postAll = $this->finder('XF:Post')->where('thread_id', $bannedUserthread->thread_id)->where('post_id', '!=', $bannedUserthread->FirstPost->post_id)->fetch();

			// if (count($postAll)) {
			// 	foreach ($postAll as $value) {

			// 		$value->delete();
			// 	}
			// }
			$bannedUserthread->fastUpdate('discussion_open', false);
		}

		return true;
	}

	public function BannedUserSave($userId, Controller $controller)
	{

		$bannedUser = \xf::app()->em()->find('XF:User', $userId);

		if ($bannedUser) {

			$threadId = $bannedUser->Ban->thread_id;

			$options = \XF::options();
			$applicableForum = $options->fs_banned_users_applic_forum;

			if (intval($applicableForum) && !$threadId) {
				$forum = \xf::app()->em()->find('XF:Forum', $applicableForum);


				if ($forum) {

					$isPreRegThread = $forum->canCreateThreadPreReg();

					$creatableThreadTypes = [];
					foreach ($forum->getCreatableThreadTypes() as $threadType) {
						$handler = $this->app->threadType($threadType, false);
						if ($handler) {
							$creatableThreadTypes[$threadType] = $handler;
						}
					}

					$draftThreadType = $forum->draft_thread['discussion_type'];
					if ($draftThreadType && isset($creatableThreadTypes[$draftThreadType])) {
						$defaultThreadType = $draftThreadType;
					} else {
						$defaultThreadType = key($creatableThreadTypes);
					}

					$switches = [
						'inline-mode' => false,
						'more-options' => false
					];

					if ($switches['more-options']) {
						$switches['inline-mode'] = false;
					}

					$thread = null;
					$post = null;
					$tags = null;

					$creator = $this->setupThreadCreate($forum, $bannedUser, $controller);
					$creator->checkForSpam();

					if (!$creator->validate($errors)) {
						return $bannedUser->error($errors);
					}
					// $controller->assertNotFlooding('thread', $this->app->options()->floodCheckLengthDiscussion ?: null);

					/** @var \XF\Entity\Thread $thread */
					$thread = $creator->save();
					$this->finalizeThreadCreate($creator, $bannedUser);
				}
			} elseif ($threadId) {

				$bannedUserThread = $bannedUser->Ban->Thread;

				if ($bannedUserThread) {

					$issuedTo = $bannedUser->username;
					$issuedBy = $bannedUser->Ban->BanUser->username;
					$banDate = date('M d Y', $bannedUser->Ban->ban_date);
					$endDate = $bannedUser->Ban->end_date ? date('M d Y', $bannedUser->Ban->end_date) : 'Permanent';
					$reasonBan = $bannedUser->Ban->user_reason ?: "N/A";


					$message = "Issued to:  $issuedTo
Issued by: $issuedBy  
Ban date: $banDate
End date: $endDate
Reason: $reasonBan";


					$bannedUserThread->FirstPost->fastUpdate('message', $message);
				}
			}
		}

		return true;
	}

	/**
	 * @param \XF\Entity\Forum $forum
	 *
	 * @return \XF\Service\Thread\Creator
	 */
	protected function setupThreadCreate(\XF\Entity\Forum $forum, $user, Controller $controller)
	{
		$input = $controller->filter([
			'ban_length' => 'str',
			'end_date' => 'datetime',
			'user_reason' => 'str'
		]);

		if ($input['ban_length'] == 'permanent') {
			$input['end_date'] = 0;
		}


		$visitor = \XF::visitor();

		$banDate = date('M d Y', time());
		$endDate = $input['end_date'] ? date('M d Y', $input['end_date']) : 'Permanent';
		$reasonBan = $input["user_reason"] ?: "N/A";


		$title = "Ban issued to user " . $user->username;
		$message = "Issued to:  $user->username
Issued by: $visitor->username  
Ban date: $banDate
End date: $endDate
Reason: $reasonBan";

		/** @var \XF\Service\Thread\Creator $creator */

		$creator = $this->service('XF:Thread\Creator', $forum);

		$isPreRegAction = $forum->canCreateThreadPreReg();

		$creator->setDiscussionTypeAndData(
			"discussion",
			\XF::app()->request
		);

		$creator->setContent($title, $message);

		$canEditTags = \XF::asPreRegActionUserIfNeeded(
			$isPreRegAction,
			function () use ($forum) {
				return $forum->canEditTags();
			}
		);
		if ($canEditTags) {
			$creator->setTags("");
		}

		$setOptions = [
			'watch_thread' => true,
			'discussion_open' => false,
			'sticky' => false
		];

		if ($setOptions) {
			$thread = $creator->getThread();

			$creator->setDiscussionOpen(true);
		}

		$customFields = [];
		$creator->setCustomFields($customFields);

		return $creator;
	}

	protected function finalizeThreadCreate(\XF\Service\Thread\Creator $creator, $bannedUser)
	{
		$creator->sendNotifications();

		$forum = $creator->getForum();
		$thread = $creator->getThread();
		$visitor = \XF::visitor();

		$bannedUser->Ban->fastUpdate('thread_id', $thread->thread_id);

		if ($thread->canWatch()) {
			/** @var \XF\Repository\ThreadWatch $threadWatchRepo */
			$threadWatchRepo = $this->repository('XF:ThreadWatch');

			$state = 'watch_email';
			$threadWatchRepo->setWatchState($thread, $visitor, $state);
		}

		if ($visitor->user_id) {
			$this->getThreadRepo()->markThreadReadByVisitor($thread, $thread->post_date);

			$forum->draft_thread->delete();
		}
	}

	/**
	 * @return \XF\Repository\Thread
	 */
	protected function getThreadRepo()
	{
		return $this->repository('XF:Thread');
	}
}
