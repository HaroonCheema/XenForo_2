<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Service;

use OAuth\Common\{Consumer\CredentialsInterface,
	Http\Client\ClientInterface,
	Http\Exception\TokenResponseException,
	Http\Uri\Uri,
	Http\Uri\UriInterface,
	Storage\TokenStorageInterface,
	Token\TokenInterface};
use OAuth\OAuth2\{Service\AbstractService, Token\StdOAuth2Token};

class Yandex extends AbstractService
{
	/**
	 * Yandex constructor.
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
		$scopes = array(),
		UriInterface $baseApiUri = null
	) {
		parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri);

		if (null === $baseApiUri) {
			$this->baseApiUri = new Uri('https://login.yandex.ru/');
		}
	}

	/**
	 * Parses the access token response and returns a TokenInterface.
	 *
	 *
	 * @param string $responseBody
	 *
	 * @return TokenInterface
	 *
	 * @throws TokenResponseException
	 */

	protected function parseAccessTokenResponse($responseBody)
	{
		$data = json_decode($responseBody, true);

		if (null === $data || !is_array($data)) {
			throw new TokenResponseException('Unable to parse response.');
		} elseif (isset($data['error_description'])) {
			throw new TokenResponseException(
				'Error in retrieving token: "' . $data['error_description'] . '"'
			);
		} elseif (isset($data['error'])) {
			throw new TokenResponseException(
				'Error in retrieving token: "' . $data['error'] . '"'
			);
		}

		$token = new StdOAuth2Token();
		$token->setAccessToken($data['access_token']);

		if (isset($data['refresh_token'])) {
			$token->setRefreshToken($data['refresh_token']);
			unset($data['refresh_token']);
		}
		if (isset($data['expires_in'])) {
			$token->setLifeTime($data['expires_in']);
			unset($data['expires_in']);
		}

		unset($data['access_token']);

		$token->setExtraParams($data);

		return $token;
	}

	/**
	 * @return int
	 */
	protected function getAuthorizationMethod()
	{
		return static::AUTHORIZATION_METHOD_HEADER_BEARER;
	}

	/**
	 * Returns the authorization API endpoint.
	 *
	 * @return UriInterface
	 */
	public function getAuthorizationEndpoint()
	{
		return new Uri('https://oauth.yandex.ru/authorize');
	}

	/**
	 * Returns the access token API endpoint.
	 *
	 * @return UriInterface
	 */
	public function getAccessTokenEndpoint()
	{
		return new Uri('https://oauth.yandex.ru/token');
	}
}