<?php

namespace FS\SwbFemaleVerify\Service;

use FS\SwbFemaleVerify\Addon;
use FS\SwbFemaleVerify\Entity\FemaleVerification;
use XF\Service\ValidateAndSavableTrait;

class Editor extends \XF\Service\AbstractService
{
	use ValidateAndSavableTrait;

	/**
	 * @var FemaleVerification
	 */
	protected $female;

	protected $performValidations = true;

	protected $newState;

	public function __construct(\XF\App $app, FemaleVerification $female)
	{
		parent::__construct($app);

		$this->female = $female;
	}

	public function setWithdrawState($state)
	{
		$this->female->female_state = $state;
	}

	public function setPerformValidations($perform = true)
	{
		$this->performValidations = $perform;
	}

	public function setRejectReason($reason)
	{
		$this->female->reject_reason = $reason;
	}

	protected function finalSetup() {}

	protected function afterUpdate() {}

	protected function onApprove()
	{
		/** @var Notifier $notifier */
		$notifier = $this->service(Addon::shortName('Notifier'), $this->female);
		$notifier->addNotification('complete', $this->female->user_id, true, false);
		$notifier->notify();
	}

	protected function onReject()
	{
		$female = $this->female;

		/** @var Notifier $notifier */
		$notifier = $this->service(Addon::shortName('Notifier'), $this->female);
		$notifier->addNotification('reject', $this->female->user_id, true, false);
		$notifier->notify();
	}

	protected function _validate()
	{
		$this->finalSetup();
		$errors = [];

		$female = $this->female;
		if (!$female->preSave()) {
			$errors = $female->getErrors();
		}

		return $errors;
	}

	protected function _save()
	{
		$female = $this->female;
		
		$db = $this->db();
		$db->beginTransaction();

		if ($female->isStateChanged('female_state', 'rejected') == 'enter') {
			$this->onReject();
			
			if($female->User){
			    $female->User->fastupdate('identity_status', 'rejected');
			}
			
		} elseif ($female->isStateChanged('female_state', 'sent') == 'enter') {
			
			$this->onApprove();
			if($female->User){
			    
			    $female->User->fastupdate('identity_status', 'sent');
			}
		}

		$female->save(true, false);
		$this->afterUpdate();

		$db->commit();

		return $female;
	}
}
