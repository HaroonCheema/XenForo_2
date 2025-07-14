<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Paypal extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'identity/oauth2/userinfo?schema=paypalv1.1';
	}

	/**
	 * @return mixed|null
	 */
	public function getProviderKey()
	{
		return $this->requestFromEndpoint('user_id');
	}

	/**
	 * @return mixed|null
	 */
	public function getUsername()
	{
		return $this->requestFromEndpoint('name');
	}
}