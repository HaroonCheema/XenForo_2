<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Odnoklassniki extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'JUM\\ConnectedAccounts:Service\\Odnoklassniki';
	}

	/**
	 * @return string
	 */
	public function getProviderDataClass()
	{
		return 'JUM\\ConnectedAccounts:ProviderData\\Odnoklassniki';
	}

	/**
	 * @return array
	 */
	public function getDefaultOptions()
	{
		return [
			'app_id' => '',
			'app_pub_key' => '',
			'app_secret_key' => '',
			'scope_email' => '0'
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
			'secret' => $provider->options['app_secret_key'],
			'scopes' => $provider->options['scope_email'] ? ['GET_EMAIL'] : [],
			'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
		];
	}

	/**
	 * @param array $options
	 * @param null $error
	 * @return bool
	 */
	public function verifyConfig(array &$options, &$error = null)
	{
		$options['scope_email'] = $options['scope_email'] ?? '0';

		return parent::verifyConfig($options, $error);
	}
}