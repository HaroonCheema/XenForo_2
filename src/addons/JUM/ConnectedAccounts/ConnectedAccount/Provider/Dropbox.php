<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Dropbox extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'JUM\\ConnectedAccounts:Service\\Dropbox';
	}

	/**
	 * @return string
	 */
	public function getProviderDataClass()
	{
		return 'JUM\\ConnectedAccounts:ProviderData\\Dropbox';
	}

	/**
	 * @return array
	 */
	public function getDefaultOptions()
	{
		return [
			'app_key' => '',
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
			'key' => $provider->options['app_key'],
			'secret' => $provider->options['app_secret'],
			'scopes' => [],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}
}