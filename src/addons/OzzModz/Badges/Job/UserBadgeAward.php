<?php

namespace OzzModz\Badges\Job;

use OzzModz\Badges\Addon;
use XF\Entity\User;

class UserBadgeAward extends \XF\Job\AbstractUserCriteriaJob
{
	protected $defaultData = [
		'input' => [
			'reason' => '',
			'avoid_duplicates' => true
		]
	];

	protected function executeAction(User $user)
	{
		$badge = $this->prepareBadge();
		$input = $this->data['input'];

		/** @var \OzzModz\Badges\Service\Award $awardService */
		$awardService = $this->app->service(Addon::shortName('Award'), $user, $badge);
		$awardService->setReason($input['reason']);
		$awardService->setPerformValidations(false);

		if ($input['avoid_duplicates'])
		{
			$existingUserBadge = $this->app->em()->findOne(Addon::shortName('UserBadge'), [
				'user_id' => $user->user_id,
				'badge_id' => $badge->badge_id
			]);

			if ($existingUserBadge)
			{
				return;
			}
		}

		if (!$awardService->validate($errors))
		{
			return;
		}

		$awardService->save();
	}

	protected function prepareBadge()
	{
		$input = $this->data['input'];

		/** @var \OzzModz\Badges\Entity\Badge $badge */
		$badge = $this->app->em()->find(Addon::shortName('Badge'), $input['badge_id']);
		if (!$badge)
		{
			throw new \LogicException(Addon::phrase('requested_badge_not_found'));
		}

		return $badge;
	}

	protected function getActionDescription()
	{
		$actionPhrase = Addon::phrase('awarding');
		$typePhrase = \XF::phrase('users');

		return sprintf('%s... %s', $actionPhrase, $typePhrase);
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return false;
	}
}