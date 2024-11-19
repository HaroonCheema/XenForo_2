<?php


namespace FS\EmbedZoomMeeting\Service;

require __DIR__ . '../../vendor/autoload.php';

use XF\Mvc\FormAction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Firebase\JWT\JWT;

class MeetingSdk extends \XF\Service\AbstractService
{

    public  function generateSignature($sdkKey, $sdkSecret, $meetingNumber, $role)
    {

        $iat = time() - 30;
        $exp = $iat + 60 * 60 * 2;  // Token expiry: 2 hours

        $payload = [
            'sdkKey' => $sdkKey,
            'mn' => $meetingNumber,
            'role' => $role,
            'iat' => $iat,
            'exp' => $exp,
            'appKey' => $sdkKey,
            'tokenExp' => $exp
        ];

        return JWT::encode($payload, $sdkSecret, 'HS256');
    }
}
