<?php

namespace FS\ZoomMeeting\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Misc extends XFCP_Misc {

    public function actionZoomOAuthSetup() {


        $zoom_access_token = \xf::options()->zoom_access_token;

        $code = $this->filter('code', 'str');

        $session = \XF::app()['session.public'];
        $connectedAccountRequest = $session->get('zoomCredentials');

        $client_id = $connectedAccountRequest['client_id'];
        $client_secret = $connectedAccountRequest['client_secret'];

        $redirectUri = $this->buildLink('canonical:misc/zoom-oauth-setup');

        // Ensure the redirect URI is URL encoded
        $encodedRedirectUri = "https://forum-solution.com/forum/admin.php?misc/zoom-oauth-setup";

        // OAuth token URL
        $url = "https://zoom.us/oauth/token";

        // Set the headers for the Guzzle request
        $headers = [
            'Authorization' => 'Basic ' . base64_encode($client_id . ":" . $client_secret),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $client = new Client();

        try {
            // Make the POST request using Guzzle
            $response = $client->post($url, [
                'headers' => $headers,
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $redirectUri, // This will be encoded automatically by Guzzle
                ],
            ]);

            $httpCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            $tokenData = json_decode($responseBody, true);
            

            

            if ($httpCode == 200 && isset($tokenData['access_token'])) {

                $accessToken = $tokenData['access_token'];
                $refresh_token = $tokenData['refresh_token'];
                
                $meetingService = $this->service('FS\ZoomMeeting:Meeting');
                
                $meetingService->saveOption("zoom_access_token",$accessToken);
                $meetingService->saveOption("zoom_refresh_token",$refresh_token);

                
                $group = $this->assertGroupExists("zoom_meeting");

                return $this->redirect($this->buildLink('options/groups', $group) . $this->buildLinkHash($group->group_id));
            }
        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                \XF::logException($e);
                return $this->error("Error: " . $e->getResponse()->getBody()->getContents());

                echo "Error: " . $e->getResponse()->getBody()->getContents();
            } else {

                \XF::logException($e);
                return $this->error("Request failed: " . $e->getMessage());
            }
        }
    }

    
    protected function assertGroupExists($groupId, $with = null, $phraseKey = null) {
        return $this->assertRecordExists('XF:OptionGroup', $groupId, $with, $phraseKey);
    }
}