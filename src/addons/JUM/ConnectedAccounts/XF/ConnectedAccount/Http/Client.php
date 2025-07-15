<?php

namespace JUM\ConnectedAccounts\XF\ConnectedAccount\Http;

use OAuth\Common\Http\Client\AbstractClient;
use OAuth\Common\Http\Uri\UriInterface;

class Client extends XFCP_Client
{
    public function retrieveResponse(UriInterface $endpoint, $requestBody, array $extraHeaders = [], $method = 'POST')
    {
        if (strpos($endpoint->getAbsoluteUri(), 'reddit.com/api') == false) {

            return parent::retrieveResponse($endpoint, $requestBody, $extraHeaders, $method);
        }

        $method = strtoupper($method);

        if ($method === 'GET' && !empty($requestBody)) {
            throw new \InvalidArgumentException('No body expected for "GET" request.');
        }

        // $extraHeaders['Host'] = $endpoint->getHost();
        $extraHeaders['Connection'] = 'close';
        $extraHeaders['User-Agent'] = $this->userAgent;

        $client = \XF::app()->http()->client();

        $requestBodyField = 'body';
        if ($method === 'POST' || $method === 'PUT') {
            if (is_array($requestBody)) {
                $requestBodyField = 'form_params';
            }
        }
        $extraHeaders['Content-length'] = ($requestBody && is_string($requestBody)) ? strlen($requestBody) : 0;

        $response = $client->post('https://www.reddit.com/api/v1/access_token', [
            'headers' => $extraHeaders,
            $requestBodyField => $requestBody,
        ]);

        $body = $response->getBody();
        $content = $body ? $body->getContents() : '';

        // $responseBody = json_decode($response->getBody()->getContents(), true);

        $code = $response->getStatusCode();
        if ($code != 200 || !$body) {
            return parent::retrieveResponse($endpoint, $requestBody, $extraHeaders, $method);
        }

        return $content;
    }
}
