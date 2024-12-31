<?php

namespace OzzModz\Badges\Service;

use OzzModz\Badges\Addon;
use XF\Repository\UserAlert;
use XF\Service\ValidateAndSavableTrait;

class Award extends \XF\Service\AbstractService
{
	use ValidateAndSavableTrait;

	/**
	 * @var \XF\Entity\User
	 */
	protected $user;

	/**
	 * @var \OzzModz\Badges\Entity\Badge
	 */
	protected $badge;

	/**
	 * @var \OzzModz\Badges\Entity\UserBadge
	 */
	protected $userBadge;

	protected $notify = true;

	protected $performValidations = true;

	public function __construct(\XF\App $app, \XF\Entity\User $user, \OzzModz\Badges\Entity\Badge $badge)
	{
		parent::__construct($app);
		$this->setUser($user);
		$this->setBadge($badge);

		$this->userBadge = $this->setupUserBadge();
		$this->setAwardingUser(\XF::visitor());
	}

	protected function setUser(\XF\Entity\User $user)
	{
		$this->user = $user;
	}

	protected function setBadge(\OzzModz\Badges\Entity\Badge $badge)
	{
		$this->badge = $badge;
	}

	protected function setupUserBadge()
	{
		/** @var \OzzModz\Badges\Entity\UserBadge $userBadge */
		$userBadge = $this->em()->create(Addon::shortName('UserBadge'));
		$userBadge->user_id = $this->user->user_id;
		$userBadge->badge_id = $this->badge->badge_id;
		$userBadge->award_date = \XF::$time;

		return $userBadge;
	}

	public function setReason($reason)
	{
		$this->userBadge->reason = $reason;
	}

	public function setAwardingUser(\XF\Entity\User $user)
	{
		$this->userBadge->awarding_user_id = $user->user_id;
		$this->userBadge->is_manually_awarded = true;
	}

	public function setNotify(bool $notify)
	{
		$this->notify = $notify;
	}

	public function setIsAutomated()
	{
		$this->setPerformValidations(false);
		$this->userBadge->awarding_user_id = 0;
		$this->userBadge->is_manually_awarded = false;
	}

	public function setPerformValidations(bool $perform)
	{
		$this->performValidations = $perform;
	}

	protected function finalSetup()
	{
	}

	protected function _validate()
	{
		$this->userBadge->preSave();
		$errors = $this->userBadge->getErrors();

		if ($this->performValidations)
		{
			/** @var \OzzModz\Badges\Entity\UserBadge $existingUserBadge */
			$existingUserBadge = $this->em()->findOne(Addon::shortName('UserBadge'), [
				'user_id' => $this->user->user_id,
				'badge_id' => $this->badge->badge_id
			]);

			if ($existingUserBadge)
			{
				if (!$this->badge->is_repetitive)
				{
					$errors[] = Addon::phrase('user_is_already_awarded_with_this_badge');
				}
				elseif ($this->badge->repeat_delay)
				{
					$nextAwardTime = $existingUserBadge->award_date + $this->badge->repeat_delay * 3600;
					if ($nextAwardTime > \XF::$time)
					{
						$errors[] = Addon::phrase('award_repeat_next_x_time', [
							'time' => $this->app->templater()->func('date_time', [$nextAwardTime])
						]);
					}
				}
			}

			$maxLength = $this->app->options()->ozzmodz_badges_awardReasonMaxLength;
			if ($maxLength && utf8_strlen($this->userBadge->reason) > $maxLength)
			{
				$errors[] = \XF::phrase('please_enter_message_with_no_more_than_x_characters', ['count' => $maxLength]);
			}
		}

		$this->finalSetup();
		return $errors;
	}

	protected function afterInsert()
	{
		if (\XF::isAddOnActive('DBTech/Credits'))
		{
			$user = $this->user;
			$userBadge = $this->userBadge;

			/** @var \DBTech\Credits\Repository\EventTrigger $eventTriggerRepo */
			$eventTriggerRepo = $this->repository('DBTech\Credits:EventTrigger');

			$eventTriggerRepo->getHandler('ozzmodz_badges_awarded')
				->apply($userBadge->getEntityId(), [
					'timestamp' => \XF::$time,
					'content_type' => $userBadge->getEntityContentType(),
					'content_id' => $userBadge->getEntityId(),
					'badge_id' => $userBadge->badge_id
				], $user);
		}
	}

	protected function _save()
	{
		$db = $this->db();
		$db->beginTransaction();

		$userBadge = $this->userBadge;

		$userBadge->save(true, false);
		$this->afterInsert();

		if ($this->notify)
		{
			$this->sendNotification();
			$this->sendEmail();
		}

		$db->commit();

		return $userBadge;
	}

	protected function sendNotification()
	{
		/** @var UserAlert $alertRepo */
		$alertRepo = $this->repository('XF:UserAlert');
		$alertRepo->alertFromUser($this->user, $this->user, 'ozzmodz_badges_badge', $this->badge->badge_id, 'award');
	}

	protected function sendEmail()
	{
		if ($this->app->options()->ozzmodz_badges_emailToggle == 0)
		{
			/** @var \OzzModz\Badges\XF\Entity\UserOption $userOption */
			$user = $this->user;
			if (!$user->email || $user->user_state != 'valid')
			{
				return false;
			}
			
			$userOption = $user->Option;
			if ($userOption && $userOption->ozzmodz_badges_email_on_award)
			{
				$params = [
					'user' => $user,
					'reason' => $this->userBadge->reason,
					'badge' => $this->badge
				];

				$this->app->mailer()->newMail()
					->setToUser($user)
					->setTemplate(Addon::prefix('badge_award'), $params)
					->queue();
			}
		}
	}
}