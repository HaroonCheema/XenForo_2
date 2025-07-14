<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Pinterest extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'v1/me';
	}

	/**
	 * @return mixed
	 */
	public function getProviderKey()
	{
		return $this->requestFromEndpoint('data')['id'];
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->requestFromEndpoint('data')['first_name'] .
			' ' .
			$this->requestFromEndpoint('data')['last_name'];
	}

	/**
	 * @return mixed
	 */
	public function getProfileLink()
	{
		return $this->requestFromEndpoint('data')['url'];
	}
}