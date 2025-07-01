<?php


namespace FS\SwbFemaleVerify\Service;


use FS\SwbFemaleVerify\Addon;
use FS\SwbFemaleVerify\Entity\FemaleVerification as FemaleVerification;
use XF;
use XF\App;
use XF\Entity\User;
use XF\Service\AbstractNotifier;

class Notifier extends AbstractNotifier
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

	public static function createForJob(array $extraData)
	{
		$female = XF::app()->find(Addon::shortName('FemaleVerification'), $extraData['femaleId']);
		if (!$female) {
			return null;
		}

		return XF::service(Addon::shortName('Notifier'), $female);
	}

	protected function getExtraJobData()
	{
		return [
			'femaleId' => $this->female->getEntityId(),
		];
	}

	protected function loadNotifiers()
	{
		return [
			'reject' => $this->app->notifier(Addon::shortName('Reject'), $this->female),
			'complete' => $this->app->notifier(Addon::shortName('Complete'), $this->female)
		];
	}

	protected function loadExtraUserData(array $users) {}

	protected function canUserViewContent(User $user)
	{
		return XF::asVisitor(
			$user,
			function () {
				return $this->female->canView();
			}
		);
	}
}
