<?php

namespace FS\ClaimEmails\XF\Admin\Controller;

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
		$isNew = !$user['user_id'] ? true : false;

		$parent = parent::userSaveProcess($user);

		$parent->complete(function () use ($user, $isNew) {

			if ($isNew) {
				$user->bulkSet([
					'is_new' => 1,
				]);

				$user->save();
			}
		});

		return $parent;
	}
}
