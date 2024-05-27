<?php

namespace FS\IPSearchResult\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Member extends XFCP_Member
{
	public function actionUserIp(ParameterBag $params)
	{
		$user = $this->assertViewableUser($params->user_id, [], true);

		if (!\XF::visitor()->canViewIps()) {
			return $this->noPermission();
		}

		if (!\XF::visitor()->hasPermission('fs_IPSearchResult', 'canUseSearch')) {
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
}
