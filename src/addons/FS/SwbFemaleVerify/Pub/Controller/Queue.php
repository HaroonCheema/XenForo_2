<?php


namespace FS\SwbFemaleVerify\Pub\Controller;


use FS\SwbFemaleVerify\Entity\FemaleVerification;
use FS\SwbFemaleVerify\Addon;
use XF;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Repository;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Exception;
use XF\Pub\Controller\AbstractController;

class Queue extends AbstractController
{
	public function actionIndex()
	{
		$withdrawRepo = $this->getFemaleRepo();
		$finder = $withdrawRepo->findFemales()->where('female_state', '=', 'pending');

		$page = $this->filterPage();
		$perPage = 10;
		$finder->limitByPage($page, $perPage);
		$total = $finder->total();

		$this->assertValidPage($page, $perPage, $total, 'female-verify/queue');

		$redirect = $this->getDynamicRedirect($this->buildLink('female-verify/queue', null, ['page' => $page]), false);

		$viewParams = [
			'items' => $finder->fetch(),
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage,
			'redirect' => $redirect
		];

		return $this->view('FS\WalletResources:Index', 'fs_female_queue_list', $viewParams);
	}

	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		/** @var FemaleVerification $withdraw */
		$withdraw = $this->assertFemaleExists($params->id);

		$editor = $this->setupWithdrawEdit($withdraw);
		if (!$editor->validate($errors)) {
			return $this->error($errors);
		}

		$editor->save();
		$this->finalizeWithdrawEdit($editor);

		$redirect = $this->getDynamicRedirect('female-verify/queue');
		return $this->redirect($redirect);
	}

	protected function setupWithdrawEdit(FemaleVerification $withdraw)
	{
		/** @var \FS\SwbFemaleVerify\Service\Editor $editor */
		$editor = $this->service(Addon::shortName('Editor'), $withdraw);

		$input = $this->filter([
			'female_state' => 'str',
			'reason' => 'str'
		]);

		$editor->setWithdrawState($input['female_state']);

		if ($input['female_state'] == 'rejected') {
			$editor->setRejectReason($input['reason']);
		}

		return $editor;
	}

	protected function finalizeWithdrawEdit(\FS\SwbFemaleVerify\Service\Editor $editor) {}

	protected function preDispatchController($action, ParameterBag $params)
	{
		$visitor = XF::visitor();
		if (!($visitor->is_admin || $visitor->is_moderator)) {
			return $this->noPermission();
		}

		parent::preDispatchController($action, $params);
	}

	public static function getActivityDetails(array $activities)
	{
		return Addon::phrase('viewing_withdraws');
	}

	/**
	 * @param $id
	 * @param null $with
	 * @param null $phraseKey
	 * @return Entity|\FS\WalletResources\Entity\Withdraw
	 * @throws Exception
	 */
	protected function assertFemaleExists($id, $with = null, $phraseKey = 'fs_requested_withdraw_not_found')
	{
		return $this->assertRecordExists(Addon::shortName('FemaleVerification'), $id, $with, $phraseKey);
	}

	/**
	 * @return Repository|\FS\SwbFemaleVerify\Repository\FemaleVerify
	 */
	protected function getFemaleRepo()
	{
		return $this->repository(Addon::shortName('FemaleVerify'));
	}
}
