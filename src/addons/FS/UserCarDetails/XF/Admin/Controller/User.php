<?php

namespace FS\UserCarDetails\XF\Admin\Controller;

class User extends XFCP_User
{
	/**
	 * @param \XF\Entity\User $user
	 *
	 * @return \XF\Mvc\FormAction
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function userSaveProcess(\XF\Entity\User $user)
	{
		$parent = parent::userSaveProcess($user);

		$parent->complete(function () use ($user) {
			$carDetailsServ = $this->service('FS\UserCarDetails:AddEditCarDetails');
			$carDetailsServ->filterInputs($user);
		});

		return $parent;
	}
}
