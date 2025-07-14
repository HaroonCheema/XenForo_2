<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Instagram extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'Instagram';
	}

	/**
	 * @return string
	 */
	public function getProviderDataClass()
	{
		return 'JUM\\ConnectedAccounts:ProviderData\\' . $this->getOAuthServiceName();
	}

	/**
	 * @return array
	 */
	public function getDefaultOptions()
	{
		return [
			'client_id' => '',
			'client_secret' => ''
		];
	}

	/**
	 * @param ConnectedAccountProvider $provider
	 * @param null $redirectUri
	 * @return array
	 */
	public function getOAuthConfig(ConnectedAccountProvider $provider, $redirectUri = null)
	{
		return [
			'key' => $provider->options['client_id'],
			'secret' => $provider->options['client_secret'],
			'scopes' => ['basic'],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}
}