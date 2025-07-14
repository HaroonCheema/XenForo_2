<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Tumblr extends AbstractProvider
{
	/**
	 * Tumblr constructor.
	 * @param $providerId
	 */
	public function __construct($providerId)
	{
		parent::__construct($providerId);
		$this->oAuthVersion = 1;
	}

	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'Tumblr';
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
			'consumer_key' => '',
			'consumer_secret' => ''
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
			'key' => $provider->options['consumer_key'],
			'secret' => $provider->options['consumer_secret'],
			'scopes' => [],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}
}