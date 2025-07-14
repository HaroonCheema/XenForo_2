<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Dropbox extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'users/get_current_account';
	}

	/**
	 * @return mixed|null
	 */
	public function getProviderKey()
	{
		return $this->requestFromEndpoint('account_id');
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->requestFromEndpoint('name')['display_name'];
	}

	/**
	 * @return mixed|null
	 */
	public function getEmail()
	{
		if ($this->requestFromEndpoint('email_verified'))
		{
			return $this->requestFromEndpoint('email');
		}
	}

	/**
	 * @return mixed|null
	 */
	public function getAvatarUrl()
	{
		return $this->requestFromEndpoint('profile_photo_url');
	}
}