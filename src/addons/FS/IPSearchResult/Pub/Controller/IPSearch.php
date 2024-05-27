<?php

namespace FS\IPSearchResult\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class IPSearch extends AbstractController
{

	protected function preDispatchController($action, ParameterBag $params)
	{
		$visitor = \XF::visitor();

		if ($visitor->is_moderator || $visitor->is_admin) {
			return true;
		}

		throw $this->exception($this->noPermission());
	}


	public function actionIndex()
	{

		if (!\XF::visitor()->hasPermission('fs_IPSearchResult', 'canUseSearch')) {
			return $this->noPermission();
		}


		return $this->view('FS\IPSearchResult:IPSearch', 'ip_search', $viewParams = []);
	}


	public function actionUserIps()
	{
		if (!\XF::visitor()->hasPermission('fs_IPSearchResult', 'canUseSearch')) {
			return $this->noPermission();
		}


		$username = ltrim($this->filter('username', 'str', ['no-trim']));

		$user = $this->findUserByName($username, []);

		if (!\XF::visitor()->canViewIps()) {
			return $this->noPermission();
		}

		/** @var \XF\Repository\Ip $ipRepo */
		$ipRepo = $this->repository('XF:Ip');

		$ips = $ipRepo->getIpsByUser($user);
		if (!$ips) {
			return $this->message(\XF::phrase('no_ip_logs_for_requested_user'));
		}


		foreach ($ips as $key => $ip) {
			$ips[$key]['users'] = $this->em()->getRepository('XF:Ip')->getJustUsersByIp($ip['ip']);  // get ip users
		}


		$viewParams = [
			'user' => $user,
			'ips' => $ips
		];
		return $this->view('XF:Member\UserIps', 'fs_member_ip_list', $viewParams);
	}



	protected function findUserByName($username, array $extraWith = [])
	{
		/** @var \XF\Entity\User $user */
		$user = $this->em()->findOne('XF:User', ['username' => $username], $extraWith);
		if (!$user) {
			throw $this->exception($this->notFound(\XF::phrase('requested_user_not_found')));
		}

		return $user;
	}
}
