<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Yandex extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'info';
	}

	/**
	 * @return mixed|null
	 */
	public function getProviderKey()
	{
		return $this->requestFromEndpoint('id');
	}

	/**
	 * @return mixed|null
	 */
	public function getUsername()
	{
		return $this->requestFromEndpoint('real_name');
	}

	/**
	 * @return mixed|null
	 */
	public function getEmail()
	{
		return $this->requestFromEndpoint('default_email');
	}

	/**
	 * @return array|bool|null
	 */
	public function getDob()
	{
		$birthday = $this->requestFromEndpoint('birthday');

		if ($birthday)
		{
			return $this->prepareBirthday($birthday, 'y-m-d');
		}

		return null;
	}

	/**
	 * @return string|null
	 */
	public function getAvatarUrl()
	{
		if (!$this->requestFromEndpoint('is_avatar_empty'))
		{
			$avatarId = $this->requestFromEndpoint('default_avatar_id');
			return "https://avatars.yandex.net/get-yapic/{$avatarId}/islands-200";

		}

		return null;
	}
}