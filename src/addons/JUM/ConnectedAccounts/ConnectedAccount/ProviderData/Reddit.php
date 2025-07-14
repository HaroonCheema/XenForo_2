<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Reddit extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'api/v1/me/';
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
		return $this->requestFromEndpoint('name');
	}

	/**
	 * @return mixed|null
	 */
	public function getAvatarUrl()
	{
		return $this->requestFromEndpoint('icon_img');
	}

	/**
	 * @return string
	 */
	public function getProfileLink()
	{
		return 'https://reddit.com/u/' . $this->getUsername();
	}
}