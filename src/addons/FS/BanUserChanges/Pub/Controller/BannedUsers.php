<?php


namespace FS\BanUserChanges\Pub\Controller;


use FS\SwbFemaleVerify\Entity\FemaleVerification;
use FS\SwbFemaleVerify\Addon;
use XF;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Repository;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Exception;
use XF\Pub\Controller\AbstractController;

class BannedUsers extends AbstractController
{
	public function actionIndex()
	{

		if (!(\XF::visitor()->is_admin || \XF::visitor()->is_moderator)) {
			return $this->noPermission();
		}

		$page = $this->filterPage();
		$perPage = 20;

		$banningRepo = $this->getBanningRepo();
		if (\xf::visitor()->hasPermission('fs_ban_watch_profile', 'all_check')) {
			$banFinder = $banningRepo->findUserBansForList()->limitByPage($page, $perPage);
		} else {
			$banFinder = $banningRepo->findUserBansForList()->where("ban_user_id", \XF::visitor()->user_id)->limitByPage($page, $perPage);
		}
		$total = $banFinder->total();

		$viewParams = [
			'userBans' => $banFinder->fetch(),

			'page' => $page,
			'perPage' => $perPage,
			'total' => $total
		];

		return $this->view('FS\BanUserChanges:Index', 'fs_ban_user_list', $viewParams);
	}

	/**
	 * @return \XF\Repository\Banning
	 */
	protected function getBanningRepo()
	{
		return $this->repository('XF:Banning');
	}
}
