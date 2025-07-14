<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Tumblr extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'user/info';
	}

	/**
	 * @return mixed
	 */
	public function getProviderKey()
	{
		return $this->getUuid();
	}

	/**
	 * @return mixed
	 */
	public function getUuid()
	{
		return $this->requestFromEndpoint('response')['user']['blogs'][0]['uuid'];
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->requestFromEndpoint('response')['user']['name'];
	}

	/**
	 * @return string
	 */
	public function getAvatarUrl()
	{
		return "https://api.tumblr.com/v2/blog/{$this->getUuid()}/avatar/128";
	}

	/**
	 * @return string
	 */
	public function getProfileLink()
	{
		return "https://{$this->getUsername()}.tumblr.com/";
	}
}