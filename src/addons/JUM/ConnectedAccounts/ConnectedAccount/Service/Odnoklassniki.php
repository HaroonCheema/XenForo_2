<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\Service;

use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\OAuth2\{Service\AbstractService, Token\StdOAuth2Token};
use OAuth\Common\Http\{Client\ClientInterface, Exception\TokenResponseException, Uri\Uri, Uri\UriInterface};

class Odnoklassniki extends AbstractService
{
	/**
	 * Defined scopes
	 *
	 * https://apiok.ru/ext/oauth/permissions
	 */
	const SCOPE_VALUABLE_ACCESS = 'VALUABLE_ACCESS';
	const SCOPE_LONG_ACCESS_TOKEN = 'LONG_ACCESS_TOKEN';
	const SCOPE_PHOTO_CONTENT = 'PHOTO_CONTENT';
	const SCOPE_GROUP_CONTENT = 'GROUP_CONTENT';
	const SCOPE_VIDEO_CONTENT = 'VIDEO_CONTENT';
	const SCOPE_APP_INVITE = 'APP_INVITE';
	const SCOPE_GET_EMAIL = 'GET_EMAIL';

	/**
	 * Odnoklassniki constructor.
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
		parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri, true);

		if (null === $baseApiUri) {
			$this->baseApiUri = new Uri('https://api.ok.ru/');
		}
	}

	/**
	 * Parses the access token response and returns a TokenInterface.
	 *
	 *
	 * @param string $responseBody
	 *
	 * @return StdOAuth2Token
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
	 * Returns the authorization API endpoint.
	 *
	 * @return UriInterface
	 */
	public function getAuthorizationEndpoint()
	{
		return new Uri('https://connect.ok.ru/oauth/authorize');
	}

	/**
	 * Returns the access token API endpoint.
	 *
	 * @return Uri
	 */
	public function getAccessTokenEndpoint()
	{
		return new Uri('https://api.ok.ru/oauth/token.do');
	}

	/**
	 * @return int
	 */
	protected function getAuthorizationMethod()
	{
		return static::AUTHORIZATION_METHOD_QUERY_STRING;
	}

	/**
	 * @param UriInterface|string $path
	 * @param string $method
	 * @param null $body
	 * @param array $extraHeaders
	 * @return string
	 * @throws \OAuth\Common\Exception\Exception
	 * @throws \OAuth\Common\Storage\Exception\TokenNotFoundException
	 * @throws \OAuth\Common\Token\Exception\ExpiredTokenException
	 */
	public function request($path, $method = 'GET', $body = null, array $extraHeaders = array())
	{
		$uri = $this->determineRequestUriFromPath($path, $this->baseApiUri);
		$token = $this->storage->retrieveAccessToken($this->service());

		$pubKey = $this->getBubKey();
		$secretKey = md5($token->getAccessToken() . $this->credentials->getConsumerSecret());
		$signature =  md5('application_key=' . $pubKey . 'fields=*method=users.getCurrentUser' . $secretKey);

		$queryParams = [
			'application_key' => $pubKey,
			'fields' => '*',
			'method' => 'users.getCurrentUser',
			'sig' => $signature
		];

		foreach ($queryParams as $key => $val) {
			$uri->addToQuery($key, $val);
		}

		return parent::request($uri, $method, $body);
	}

	/**
	 * @return string
	 */
	protected function getScopesDelimiter()
	{
		return ';';
	}

	/**
	 * @return mixed
	 */
	protected function getBubKey()
	{
		$data = \XF::app()->em()->findOne('XF:ConnectedAccountProvider', [
			'provider_id' => 'odnoklassniki'
		]);

		return $data ->options['app_pub_key'];
	}
}