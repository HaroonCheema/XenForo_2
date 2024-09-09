<?php


namespace FS\SwbFemaleVerify\Notifier;


use FS\SwbFemaleVerify\Entity\FemaleVerification;
use XF\App;
use XF\Entity\User;
use XF\Notifier\AbstractNotifier;

class Reject extends AbstractNotifier
{
	/**
	 * @var FemaleVerification
	 */
	protected $female;

	public function __construct(App $app, FemaleVerification $female)
	{
		parent::__construct($app);

		$this->female = $female;
	}

	public function canNotify(User $user)
	{
		return $user->user_id != \XF::visitor()->user_id;
	}

	public function sendAlert(User $user)
	{
		$visitor = \XF::visitor();
		$female = $this->female;

		return $this->basicAlert(
			$user,
			$visitor->user_id,
			$visitor->username,
			$female->getEntityContentType(),
			$female->getEntityId(),
			'reject'
		);
	}
}
