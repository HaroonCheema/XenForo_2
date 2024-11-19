<?php

namespace FS\EmbedZoomMeeting\Service;

use XF\Mvc\FormAction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Meeting extends \XF\Service\AbstractService
{

    public function freshToken()
    {

        $refresh_token = \xf::options()->fs_zoom_refresh_token;  // Set your refresh token here
        $client_id = \xf::options()->fs_zoom_client_id;  // Set your client ID here
        $client_secret = \xf::options()->fs_zoom_client_secret;  // Set your client secret here

        if (!$refresh_token || !$client_id || !$client_secret) {

            return;
        }

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
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refresh_token
                ],
            ]);

            $responseBody = $response->getBody()->getContents();

            $tokenData = json_decode($responseBody, true);

            if (isset($tokenData['access_token'])) {

                $accessToken = $tokenData['access_token'];
                $refresh_token = $tokenData['refresh_token'];

                $this->saveOption("fs_zoom_access_token", $accessToken);
                $this->saveOption("fs_zoom_refresh_token", $refresh_token);
            }
        } catch (RequestException $e) {
        }
    }

    public function createZoomMeeting($topic, $start_time, $duration, $timezone, $token)
    {
        $url = "https://api.zoom.us/v2/users/me/meetings";

        $data = [
            "topic" => $topic,
            "type" => 2, // Scheduled meeting
            "start_time" => $start_time, // ISO 8601 format: 'YYYY-MM-DDTHH:MM:SS'
            "duration" => $duration, // Duration in minutes
            "timezone" => $timezone, // Example: 'America/New_York' or 'UTC'
            "settings" => [
                "join_before_host" => true,
                "approval_type" => 2,
                "registration_type" => 3,
                "waiting_room" => false,
                "meeting_authentication" => false,
                "mute_upon_entry" => true
            ]
        ];

        // Headers for the request
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/json',
        ];

        // Create a Guzzle client
        $client = new Client();

        try {
            // Make the POST request to the Zoom API
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $data  // Automatically encodes the data to JSON
            ]);

            $responseBody = $response->getBody()->getContents();

            // Check if the status code is 201 (Created)
            if ($response->getStatusCode() === 201) {
                // Get the response body

                $responseBody = json_decode($responseBody, true);

                return [$responseBody['id'], $responseBody['start_time'], $responseBody['start_url'], $responseBody['join_url']];
            } else {


                throw new \XF\PrintableException('Unexpected status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            // Handle any exceptions that occur during the request
            if ($e->hasResponse()) {

                throw new \XF\PrintableException($e->getResponse()->getBody()->getContents());
            } else {

                throw new \XF\PrintableException($e->getMessage());
            }
        }
    }

    public function updateZoomMeeting($meetingId, $topic, $start_time, $duration, $timezone, $token)
    {

        $url = "https://api.zoom.us/v2/meetings/" . $meetingId;

        $data = [
            "topic" => $topic,
            "type" => 2,
            "start_time" => $start_time,
            "duration" => $duration,
            "timezone" => $timezone,
            "settings" => [
                "join_before_host" => true,
                "approval_type" => 2,
                "registration_type" => 1,
                "waiting_room" => false,
                "meeting_authentication" => false,
                "mute_upon_entry" => true
            ]
        ];

        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/json',
        ];

        $client = new Client();

        try {

            $response = $client->patch($url, [
                'headers' => $headers,
                'json' => $data
            ]);

            $responseBody = $response->getBody()->getContents();

            if ($response->getStatusCode() === 204) {

                $responseBody = json_decode($responseBody, true);

                return $this->getMeeting($meetingId, $token);
            } else {
                throw new \XF\PrintableException('Unexpected status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                throw new \XF\PrintableException($e->getResponse()->getBody()->getContents());
            } else {
                throw new \XF\PrintableException($e->getMessage());
            }
        }
    }

    public function zoomMeetingTime($startdate, $startTime)
    {

        $combinedDateTime = $startdate . ' ' . $startTime;

        // Create a DateTime object
        $dateTime = new \DateTime($combinedDateTime);

        // Format the DateTime object to ISO 8601 format (YYYY-MM-DDTHH:MM:SS)
        return $dateTime->format('Y-m-d\TH:i:s');
    }

    public function saveOption($key, $value)
    {

        $option = $this->assertOptionExists($key);

        $option->option_value = $value;

        $option->save();
    }

    protected function assertOptionExists($optionId)
    {

        return $this->finder('XF:Option')->where('option_id', $optionId)->fetchOne();
    }

    public function getMeeting($meetingId, $token)
    {
        $url = "https://api.zoom.us/v2/meetings/{$meetingId}";

        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/json',
        ];

        $client = new Client();

        try {

            $response = $client->get($url, [
                'headers' => $headers,
            ]);

            $responseBody = $response->getBody()->getContents();

            if ($response->getStatusCode() === 200) {

                $responseBody = json_decode($responseBody, true);
                return [$responseBody['id'], $responseBody['start_time'], $responseBody['start_url'], $responseBody['join_url']];
            } else {
                throw new \XF\PrintableException('Unexpected status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            // Handle any exceptions that occur during the request
            if ($e->hasResponse()) {
                throw new \XF\PrintableException($e->getResponse()->getBody()->getContents());
            } else {
                throw new \XF\PrintableException($e->getMessage());
            }
        }
    }

    public function deleteMeeting($meetingId, $token)
    {

        $url = "https://api.zoom.us/v2/meetings/{$meetingId}";

        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/json',
        ];

        $client = new Client();

        try {

            $response = $client->delete($url, [
                'headers' => $headers,
            ]);

            if ($response->getStatusCode() == 204) {

                return true;
            }
        } catch (RequestException $e) {
            // Handle any exceptions that occur during the request
            if ($e->hasResponse()) {
                throw new \XF\PrintableException($e->getResponse()->getBody()->getContents());
            } else {
                throw new \XF\PrintableException($e->getMessage());
            }
        }
    }

    public function meetingStartDateTime($startDate, $startTime)
    {
        $timezone = "UTC";

        $tz = new \DateTimeZone($timezone);

        $dateTime = new \DateTime("@" . strtotime($startDate), $tz);

        list($hours, $minutes) = explode(':', $startTime);

        $dateTime->setTime($hours, $minutes);
        return $dateTime->getTimestamp();
    }


    public function joinMeeting($username, $email, $participant_uuid, $meetingId)
    {
        $join = $this->finder('FS\EmbedZoomMeeting:Register')->where('participant_uuid', $participant_uuid)->where('meeting_id', $meetingId)->fetchOne();

        if ($join) {

            $join->join_date = \xf::$time;
            $join->status = 1;
            $join->save();
        } else {

            $user = $this->em()->findOne('XF:User', ['username' => $username]);

            $email = isset($user->email) ? $user->email : '';
            $UserId = isset($user->user_id) ? $user->user_id : 0;

            $join = $this->em()->create('FS\EmbedZoomMeeting:Register');
            $join->username = $username;
            $join->email = $email;
            $join->user_id = $UserId;
            $join->participant_uuid = $participant_uuid;
            $join->meeting_id = $meetingId;
            $join->status = 1;
            $join->save();
        }
    }

    public function leftMeeting($userName, $participant_uuid, $meetingId)
    {

        $join = $this->finder('FS\EmbedZoomMeeting:Register')->where('username', $userName)->where('meeting_id', $meetingId)->fetchOne();

        if ($join) {

            $join->status = 0;
            $join->save();
        }
    }

    public function startMeeting($meetingId)
    {

        $meeting = $this->finder('FS\EmbedZoomMeeting:Meeting')->where('z_meeting_id', $meetingId)->fetchOne();

        if ($meeting) {

            $meeting->start_time = \xf::$time;
            $meeting->status = 1;
            $meeting->save();
        }
    }

    public function endMeeting($meetingId)
    {
        $meeting = $this->finder('FS\EmbedZoomMeeting:Meeting')->where('z_meeting_id', $meetingId)->fetchOne();

        if ($meeting) {

            // $meeting->end_time = \xf::$time;
            // $meeting->status = 2;
            // $meeting->save();
            $meeting->delete();
        }

        $userRegisters = $this->finder('FS\EmbedZoomMeeting:Register')->where('meeting_id', $meetingId)->fetch();

        if (count($userRegisters)) {

            foreach ($userRegisters as $userRegister) {

                // $userRegister->status = 0;
                // $userRegister->save();
                $userRegister->delete();
            }
        }
    }
}
