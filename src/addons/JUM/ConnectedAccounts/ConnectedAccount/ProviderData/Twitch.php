<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Twitch extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'users';
	}

	/**
	 * @return mixed
	 */
	public function getDataResponse()
	{
		return $this->requestFromEndpoint('data')[0];
	}

	/**
	 * @return mixed
	 */
	public function getProviderKey()
	{
		return $this->getDataResponse()['id'];
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->getDataResponse()['display_name'];
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->getDataResponse()['email'];
	}

	/**
	 * @return string
	 */
	public function getProfileLink()
	{
		return 'https://www.twitch.tv/' . $this->getDataResponse()['login'];
	}

	/**
	 * @return mixed
	 */
	public function getAvatarUrl()
	{
		return $this->getDataResponse()['profile_image_url'];
	}
}