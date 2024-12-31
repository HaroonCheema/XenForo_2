<?php


namespace OzzModz\Badges\EventTrigger;


use DBTech\Credits\Entity\Event;
use DBTech\Credits\Entity\Transaction;
use OzzModz\Badges\Addon;

class Awarded extends \DBTech\Credits\EventTrigger\AbstractHandler
{
	protected function setupOptions(): void
	{
		$this->options = array_replace($this->options, [
			'isGlobal' => true,
			'canRevert' => true,
			'canCancel' => true,
			'canRebuild' => true,
		]);
	}

	protected function trigger(\XF\Entity\User $user, $refId, bool $negate = false, array $extraParams = []): array
	{
		$extraParams = array_replace([
			'badge_id' => 0,
		], $extraParams);

		return parent::trigger($user, $refId, $negate, $extraParams);
	}

	public function alertTemplate(Transaction $transaction): string
	{
		$which = $transaction->amount < 0.00 ? 'spent' : 'earned';

		if ($transaction->negate)
		{
			if ($which == 'spent')
			{
				return $this->getAlertPhrase(Addon::prefix('dbtech_credits_lost_x_y_via_awarded_negate'), $transaction);
			}
			else
			{
				return $this->getAlertPhrase(Addon::prefix('dbtech_credits_gained_x_y_via_awarded_negate'), $transaction);
			}
		}
		else
		{
			if ($which == 'spent')
			{
				return $this->getAlertPhrase(Addon::prefix('dbtech_credits_lost_x_y_via_awarded'), $transaction);
			}
			else
			{
				return $this->getAlertPhrase(Addon::prefix('dbtech_credits_gained_x_y_via_awarded'), $transaction);
			}
		}
	}

	protected function assertEvent(Event $event, \XF\Entity\User $user, \ArrayObject $extraParams): bool
	{
		$allowedBadges = $event->getSetting('badge');
		if ($allowedBadges && !in_array($extraParams->badge_id, $allowedBadges) && !in_array(0, $allowedBadges))
		{
			return false;
		}

		return parent::assertEvent($event, $user, $extraParams);
	}

	public function filterOptions(array $input = []): array
	{
		return $this->app()->inputFilterer()->filterArray($input, [
			'badge' => 'array-uint',
		]);
	}
}