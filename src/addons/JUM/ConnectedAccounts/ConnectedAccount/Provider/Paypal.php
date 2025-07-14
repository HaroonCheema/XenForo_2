<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Paypal extends AbstractProvider
{
	/**
	 * @return string
	 */
	public function getOAuthServiceName()
	{
		return 'Paypal';
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
			'client_secret' => '',
			'scope_email' => '0',
			'scope_location' => '0'
		];
	}

	/**
	 * @param ConnectedAccountProvider $provider
	 * @param null $redirectUri
	 * @return array
	 */
	public function getOAuthConfig(ConnectedAccountProvider $provider, $redirectUri = null)
	{
		$scope_email = $provider->options['scope_email'] ? ['email'] : [] ;
		$scope_address  = $provider->options['scope_location'] ? ['address'] : [] ;

		return [
			'key' => $provider->options['client_id'],
			'secret' => $provider->options['client_secret'],
			'scopes' => array_merge(['profile'], $scope_email, $scope_address),
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
		$options['scope_location'] = $options['scope_location'] ?? '0';

		return parent::verifyConfig($options, $error);
	}


}