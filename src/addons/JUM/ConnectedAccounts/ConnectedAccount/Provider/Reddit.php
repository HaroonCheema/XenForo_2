<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Reddit extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'Reddit';
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
			'app_id' => '',
			'app_secret' => ''
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
			'key' => $provider->options['app_id'],
			'secret' => $provider->options['app_secret'],
			'scopes' => ['identity'],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}
}