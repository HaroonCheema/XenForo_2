<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Vimeo extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'Vimeo';
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
			'scopes' => [],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}
}