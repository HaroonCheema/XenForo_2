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

		$isClaimed = 0;

		$input = $this->filter([
			'user' => [
				'username' => 'str',
				'email' => 'str',
			]
		]);

		if ($input['user']['email'] && $isNew) {

			$pervUser = $this->finder('XF:User')->where('email', $input['user']['email'])->where('is_claimed', 0)->where('is_new', 0)->fetchOne();

			if ($pervUser) {

				$options = \XF::options();

				$randomEmail = $this->generateRandomEmail($options->fs_ranfom_email_domain, $options->fs_email_limit);

				$pervUser->bulkSet([
					'email' => $randomEmail,
				]);

				$pervUser->save();

				$isClaimed = $pervUser['user_id'];
			}
		}

		$parent = parent::userSaveProcess($user);

		$parent->complete(function () use ($user, $isNew, $isClaimed) {

			if ($isNew) {
				$user->bulkSet([
					'is_new' => 1,
					'is_claimed' => $isClaimed,
				]);

				$user->save();
			}
		});

		return $parent;
	}

	protected function generateRandomEmail($domain, $length)
	{
		$letters = 'abcdefghijklmnopqrstuvwxyz';
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';

		$randomString = $letters[rand(0, strlen($letters) - 1)];

		for ($i = 1; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString . '@' . $domain;
	}
}
