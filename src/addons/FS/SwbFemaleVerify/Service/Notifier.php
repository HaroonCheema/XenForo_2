<?php


namespace FS\WalletResources\Service;


use FS\WalletResources\Addon;
use FS\WalletResources\Entity\Withdraw as WithdrawEntity;
use XF;
use XF\App;
use XF\Entity\User;
use XF\Service\AbstractNotifier;

class Notifier extends AbstractNotifier
{
	/**
	 * @var WithdrawEntity
	 */
	protected $withdraw;

	public function __construct(App $app, WithdrawEntity $withdraw)
	{
		parent::__construct($app);

		$this->withdraw = $withdraw;
	}

	public static function createForJob(array $extraData)
	{
		$withdraw = XF::app()->find(Addon::shortName('Withdraw'), $extraData['withdrawId']);
		if (!$withdraw) {
			return null;
		}

		return XF::service(Addon::shortName('Withdraw\Notifier'), $withdraw);
	}

	protected function getExtraJobData()
	{
		return [
			'withdrawId' => $this->withdraw->getEntityId(),
		];
	}

	protected function loadNotifiers()
	{
		return [
			'reject' => $this->app->notifier(Addon::shortName('Withdraw\Reject'), $this->withdraw),
			'complete' => $this->app->notifier(Addon::shortName('Withdraw\Complete'), $this->withdraw)
		];
	}

	protected function loadExtraUserData(array $users) {}

	protected function canUserViewContent(User $user)
	{
		return XF::asVisitor(
			$user,
			function () {
				return $this->withdraw->canView();
			}
		);
	}
}
