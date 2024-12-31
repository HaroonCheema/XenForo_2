<?php

namespace OzzModz\Badges\Pub\Controller;

use OzzModz\Badges\Addon;
use XF\Mvc\ParameterBag;

class UserBadge extends \XF\Pub\Controller\AbstractController
{
	/**
	 * @param ParameterBag $params
	 * @return \XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionEdit(ParameterBag $params)
	{
		$userBadge = $this->assertUserBadgeExists($params->user_badge_id);
		if (!$userBadge->canEdit($error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			$reason = $this->filter('reason', 'str');

			$maxLength = $this->app->options()->ozzmodz_badges_awardReasonMaxLength;
			if ($maxLength && utf8_strlen($reason) > $maxLength)
			{
				return $this->error(\XF::phrase('please_enter_message_with_no_more_than_x_characters', ['count' => $maxLength]));
			}

			$userBadge->reason = $reason;

			$userBadge->preSave();
			if ($userBadge->hasErrors())
			{
				return $this->error($userBadge->getErrors());
			}

			$userBadge->saveIfChanged();

			return $this->redirectPermanently($this->buildLink('members', $userBadge->User) . '#badges');
		}

		$viewParams = [
			'user' => $userBadge->User,
			'userBadge' => $userBadge
		];

		return $this->view(Addon::shortName('UserBadge\Edit'), Addon::prefix('user_badge_edit'), $viewParams);
	}

	/**
	 * @param ParameterBag $params
	 * @return \XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Redirect
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
	public function actionFeature(ParameterBag $params)
	{
		$userBadge = $this->assertUserBadgeExists($params->user_badge_id);
		if (!$userBadge->canManageFeatured($error))
		{
			return $this->noPermission($error);
		}

		$user = $userBadge->User;

		if ($userBadge->featured)
		{
			$userBadge->featured = false;
			$userBadge->save();
			return $this->redirectPermanently($this->buildLink('members', $user) . '#badges');
		}

		if (!$userBadge->canAddFeatured($error))
		{
			return $this->noPermission($error);
		}

		$userBadge->featured = true;
		$userBadge->save();

		return $this->redirectPermanently($this->buildLink('members', $user) . '#badges');
	}

	/**
	 * @param ParameterBag $params
	 * @return \XF\Mvc\Reply\AbstractReply|\XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
	public function actionDelete(ParameterBag $params)
	{
		$userBadge = $this->assertUserBadgeExists($params->user_badge_id);
		if (!$userBadge->canDelete($error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			if (!$userBadge->preDelete())
			{
				return $this->error($userBadge->getErrors());
			}

			$userBadge->delete();

			return $this->redirectPermanently($this->buildLink('members', $userBadge->User) . '#badges');
		}

		$viewParams = [
			'user' => $userBadge->User,
			'userBadge' => $userBadge
		];

		return $this->view(Addon::shortName('UserBadge\Delete'), Addon::prefix('user_badge_delete'), $viewParams);
	}

	/**
	 * @param $id
	 * @param null $with
	 * @return \XF\Mvc\Entity\Entity|\OzzModz\Badges\Entity\UserBadge
	 * @throws \XF\Mvc\Reply\Exception
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	public function assertUserBadgeExists($id, $with = null)
	{
		return $this->assertRecordExists(Addon::shortName('UserBadge'), $id, $with);
	}
}