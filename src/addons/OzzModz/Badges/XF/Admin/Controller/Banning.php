<?php

namespace OzzModz\Badges\XF\Admin\Controller;

use OzzModz\Badges\Addon;
use XF\Entity\UserBan;

class Banning extends XFCP_Banning
{
	protected function userBanSaveProcess(UserBan $userBan)
	{
		$form = parent::userBanSaveProcess($userBan);

		$user = $userBan->User;
		if (!$user)
		{
			$user = $this->finder('XF:User')->where('username', $this->filter('username', 'str'))->fetchOne();
		}

		if ($user && $this->filter('ozzmodz_badges_unaward', 'bool'))
		{
			$form->complete(function () use ($user) {
				$this->app()->jobManager()->enqueueAutoBlocking(
					Addon::shortName('DeleteUserBadges'),
					['user_id' => $user->user_id]
				);
			});
		}

		return $form;
	}

}