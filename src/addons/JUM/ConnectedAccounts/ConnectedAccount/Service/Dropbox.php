<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Service;

use OAuth\Common\{Http\Uri\Uri,
	Consumer\CredentialsInterface,
	Http\Client\ClientInterface,
	Storage\TokenStorageInterface,
	Http\Uri\UriInterface};

class Dropbox extends \OAuth\OAuth2\Service\Dropbox
{
	/**
	 * Dropbox constructor.
	 * @param CredentialsInterface $credentials
	 * @param ClientInterface $httpClient
	 * @param TokenStorageInterface $storage
	 * @param array $scopes
	 * @param UriInterface|null $baseApiUri
	 * @throws \OAuth\OAuth2\Service\Exception\InvalidScopeException
	 */
	public function __construct(
		CredentialsInterface $credentials,
		ClientInterface $httpClient,
		TokenStorageInterface $storage,
		$scopes = [],
		UriInterface $baseApiUri = null
	) {
		parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri);

		if (null === $baseApiUri) {
			$this->baseApiUri = new Uri('https://api.dropbox.com/2/');
		}
	}

	/**
	 * @return Uri|UriInterface
	 */
	public function getAuthorizationEndpoint()
	{
		return new Uri('https://www.dropbox.com/oauth2/authorize');
	}

	/**
	 * @return Uri|UriInterface
	 */
	public function getAccessTokenEndpoint()
	{
		return new Uri('https://api.dropboxapi.com/oauth2/token');
	}

	/**
	 * @return int
	 */
	protected function getAuthorizationMethod()
	{
		return static::AUTHORIZATION_METHOD_HEADER_BEARER;
	}

	/**
	 * @param UriInterface|string $path
	 * @param string $method
	 * @param null $body
	 * @param array $extraHeaders
	 * @return string
	 * @throws \OAuth\Common\Exception\Exception
	 * @throws \OAuth\Common\Token\Exception\ExpiredTokenException
	 */
	public function request($path, $method = 'GET', $body = null, array $extraHeaders = [])
	{
		$method = 'POST';
		return parent::request($path, $method, $body, $extraHeaders);
	}
}