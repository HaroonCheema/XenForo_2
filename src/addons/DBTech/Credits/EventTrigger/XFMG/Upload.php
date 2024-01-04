<?php

namespace DBTech\Credits\EventTrigger\XFMG;

use DBTech\Credits\EventTrigger\AbstractHandler;
use DBTech\Credits\Entity\Event;
use DBTech\Credits\Entity\Transaction;
use XF\Mvc\Entity\Entity;

/**
 * Class Upload
 *
 * @package DBTech\Credits\EventTrigger\XFMG
 */
class Upload extends AbstractHandler
{
	/**
	 *
	 */
	protected function setupOptions(): void
	{
		$this->options = array_replace($this->options, [
			'isGlobal' => true,
			'canRevert' => true,
			'canCancel' => true,
			'canRebuild' => true,
			
			'multiplier' => self::MULTIPLIER_LABEL
		]);
	}
	
	/**
	 * @param \XF\Entity\User $user
	 * @param mixed $refId
	 * @param bool $negate
	 * @param array $extraParams
	 *
	 * @return Transaction[]
	 * @throws \XF\PrintableException
	 */
	protected function trigger(
		\XF\Entity\User $user,
		$refId,
		bool $negate = false,
		array $extraParams = []
	): array {
		$extraParams = array_replace([
			'extension' => '',
		], $extraParams);
		
		return parent::trigger($user, $refId, $negate, $extraParams);
	}
	
	/**
	 * @param Event $event
	 * @param \XF\Entity\User $user
	 * @param \ArrayObject $extraParams
	 *
	 * @return bool
	 */
	protected function assertEvent(Event $event, \XF\Entity\User $user, \ArrayObject $extraParams): bool
	{
		if ($extraParams->extension)
		{
			if (
				$event->getSetting('extension_include')
				&& !in_array($extraParams->extension, explode(',', $event->getSetting('extension_include')))
			) {
				// This extension didn't count
				return false;
			}
			
			if (
				$event->getSetting('extension_exclude')
				&& in_array($extraParams->extension, explode(',', $event->getSetting('extension_exclude')))
			) {
				// This extension didn't count
				return false;
			}
		}
		
		return parent::assertEvent($event, $user, $extraParams);
	}
	
	/**
	 * @param Transaction $transaction
	 *
	 * @return mixed
	 */
	public function alertTemplate(Transaction $transaction): string
	{
		// For the benefit of the template
		$which = $transaction->amount < 0.00 ? 'spent' : 'earned';
		
		if ($transaction->negate)
		{
			if ($which == 'spent')
			{
				return $this->getAlertPhrase('dbtech_credits_lost_x_y_via_galleryupload_negate', $transaction);
			}
			else
			{
				return $this->getAlertPhrase('dbtech_credits_gained_x_y_via_galleryupload_negate', $transaction);
			}
		}
		else
		{
			if ($which == 'spent')
			{
				return $this->getAlertPhrase('dbtech_credits_lost_x_y_via_galleryupload', $transaction);
			}
			else
			{
				return $this->getAlertPhrase('dbtech_credits_gained_x_y_via_galleryupload', $transaction);
			}
		}
	}
	
	/**
	 * @return array
	 */
	public function getLabels(): array
	{
		$labels = parent::getLabels();
		
		$labels['minimum_amount'] = \XF::phrase('dbtech_credits_eventtrigger_byte_minimum_amount');
		$labels['maximum_amount'] = \XF::phrase('dbtech_credits_eventtrigger_byte_maximum_amount');
		$labels['minimum_action'] = \XF::phrase('dbtech_credits_eventtrigger_byte_minimum_action');
		$labels['minimum_action_explain'] = \XF::phrase('dbtech_credits_eventtrigger_byte_minimum_action_explain');
		$labels['multiplier_addition'] = \XF::phrase('dbtech_credits_eventtrigger_multiplier_byte_addition');
		$labels['multiplier_addition_explain'] = \XF::phrase('dbtech_credits_eventtrigger_multiplier_byte_addition_explain');
		$labels['multiplier_negation'] = \XF::phrase('dbtech_credits_eventtrigger_multiplier_byte_negation');
		$labels['multiplier_negation_explain'] = \XF::phrase('dbtech_credits_eventtrigger_multiplier_byte_negation_explain');
		
		return $labels;
	}
	
	/**
	 * @param array $input
	 *
	 * @return array
	 */
	public function filterOptions(array $input = []): array
	{
		return $this->app()->inputFilterer()->filterArray($input, [
			'extension_include' => 'str',
			'extension_exclude' => 'str',
		]);
	}
	
	/**
	 * @param \XF\Mvc\Entity\Entity entity
	 *
	 * @throws \XF\PrintableException
	 */
	public function rebuild(Entity $entity): void
	{
		/** @var \XFMG\Entity\MediaItem $entity */
		
		if ($entity->Attachment)
		{
			$this->apply($entity->media_id, [
				'multiplier'   => $entity->Attachment->getFileSize(),
				'extension'    => $entity->Attachment->getExtension(),
				
				'content_type' => 'xfmg_media',
				'content_id'   => $entity->media_id,
				
				'timestamp' => $entity->media_date,
				'enableAlert' => false,
				'runPostSave' => false
			], $entity->User);
		}
		else
		{
			$this->apply($entity->media_id, [
				'content_type' => 'xfmg_media',
				'content_id'   => $entity->media_id,
				
				'timestamp' => $entity->media_date,
				'enableAlert' => false,
				'runPostSave' => false
			], $entity->User);
		}
	}
	
	/**
	 * @param bool $forView
	 *
	 * @return array
	 */
	public function getEntityWith(bool $forView = false): array
	{
		return ['User', 'Attachment'];
	}
}