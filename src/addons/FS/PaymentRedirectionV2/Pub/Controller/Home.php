<?php

namespace FS\PaymentRedirectionV2\Pub\Controller;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Home extends AbstractController
{
    // private string $apiKey = 'LJ_oO0Mh_hp3rRRIaOfrR8KJvOeynVMx';
    // private string $mainSiteUrl = 'http://localhost/x22tst/';

    // protected function preDispatchController($action, ParameterBag $params)
    // {
    //     if (!\XF::visitor()->is_moderator)
    //     {
    //         throw $this->exception($this->noPermission());
    //     }
    // }

    public function actionIndex()
    {
        $apiKey = \XF::options()->fspr_v2_api_key;
        $mainSiteUrl = \XF::options()->fspr_v2_main_site_url;

        // Find user by username
        $findUrl = $mainSiteUrl . 'index.php/api/users/find-name?username=' . urlencode(\XF::visitor()->username);

        $headers = [
            "XF-Api-Key: $apiKey",
            "XF-Api-User: 1"
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $headers),
                'ignore_errors' => true,
            ]
        ]);

        $response = file_get_contents($findUrl, false, $context);
        
        if(!$response)
        {
            header("Location: https://celebforum.to/");
            exit;            
        }

        $userData = json_decode($response, true);
        $userId = $userData['exact']['user_id'] ?? null;
        $this->loginUserRedirect($userId);

        // if($userId)
        // {
        //     // ** If user already exists
        //     $this->loginUserRedirect($userId);
        // }
        // else
        // {
        //     header("Location: https://celebforum.to/");
        //     exit;            
        // }
    }

    private function loginUserRedirect($userId)
    {

        $apiKey = \XF::options()->fspr_v2_api_key;
        $mainSiteUrl = \XF::options()->fspr_v2_main_site_url;

        // **** User Login ***********************************
        //$userId = 3; // The user ID you want to login on SiteB
        $returnUrl = $mainSiteUrl . 'index.php'; // Where to redirect after login

        $apiUrl = $mainSiteUrl . 'index.php/api/auth/login-token';

        $postData = http_build_query([
            'user_id' => $userId,
            'return_url' => $returnUrl,
            'force' => true,
            'remember' => true
        ]);

        $options = [
            'http' => [
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                             "XF-Api-Key: $apiKey\r\n" .
                             "XF-Api-User: 1\r\n",
                'method'  => 'POST',
                'content' => $postData,
                'ignore_errors' => true,
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($apiUrl, false, $context);

        // Get HTTP status code
        $statusLine = $http_response_header[0] ?? '';
        preg_match('{HTTP\/\S*\s(\d{3})}', $statusLine, $match);
        $statusCode = $match[1] ?? 0;

        $data = json_decode($response, true);

        if ($statusCode == 200 && !empty($data['login_url']))
        {
            // Redirect to Site B login URL
            header('Location: ' . $data['login_url']);
            exit;
        }
        else 
        {
            return $this->error(\XF::phrase('failed'));

            // echo "Failed to get login token:<br>";
            // echo "HTTP Status: $statusCode<br>";
            // echo "Response:<br><pre>";
            // print_r($data);
            // echo "</pre>";
        }
    }
}