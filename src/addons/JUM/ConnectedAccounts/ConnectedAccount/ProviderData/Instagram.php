<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Instagram extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'users/self';
	}

	/**
	 * @return mixed
	 */
	public function getProviderKey()
	{
		return $this->requestFromEndpoint('data')['id'];
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->requestFromEndpoint('data')['username'];
	}

	/**
	 * @return mixed
	 */
	public function getFullname()
	{
		return $this->requestFromEndpoint('data')['full_name'];
	}

	/**
	 * @return mixed
	 */
	public function getAvatarUrl()
	{
		return $this->requestFromEndpoint('data')['profile_picture'];
	}

	/**
	 * @return string
	 */
	public function getProfileLink()
	{
		return 'https://instagram.com/' . $this->getUsername();
	}
}