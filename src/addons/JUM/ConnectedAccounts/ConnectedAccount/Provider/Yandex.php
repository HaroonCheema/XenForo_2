<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Yandex extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'JUM\\ConnectedAccounts:Service\\Yandex';
	}

	/**
	 * @return string
	 */
	public function getProviderDataClass()
	{
		return 'JUM\\ConnectedAccounts:ProviderData\\Yandex';
	}

	/**
	 * @return array
	 */
	public function getDefaultOptions()
	{
		return [
			'app_id' => '',
			'app_password' => ''
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
			'secret' => $provider->options['app_password'],
			'scopes' => [],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}
}