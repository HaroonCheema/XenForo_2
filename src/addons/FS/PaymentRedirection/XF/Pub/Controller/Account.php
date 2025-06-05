<?php

namespace FS\PaymentRedirection\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{

    public function actionUpgrades()
    {
        $apiKey = \XF::options()->fspr_api_key;
        $paymentSiteUrl = \XF::options()->fspr_payment_site_url;

        $findUrl = $paymentSiteUrl . 'index.php/api/users/find-name?username=' . urlencode(\XF::visitor()->username);

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
        $userData = json_decode($response, true);
        $userId = $userData['exact']['user_id'] ?? null;

        if ($userId) {
            $this->loginUserRedirect($userId);
        } else {
            $user = \XF::visitor();
            $apiUrl = $paymentSiteUrl . 'index.php/api/users';
            $postData = [
                'username' => $user->username,
                'email' => $user->email,
                'password' => 'wasif',
                'user_group_id' => $user->user_group_id,
                'secondary_group_ids' => $user->secondary_group_ids ?: [],

                'user_state' => $user->user_state,
                'is_staff' => (bool)$user->is_staff,
                'message_count' => $user->message_count,
                'reaction_score' => $user->reaction_score,
                'trophy_points' => $user->trophy_points,
                //'username_change_visible' => (bool)$user->username_change_visible,
                'visible' => (bool)$user->visible,
                'activity_visible' => (bool)$user->activity_visible,
                'timezone' => $user->timezone,
                'custom_title' => $user->custom_title,

                'dob' => [
                    'day' => (int)$user->Profile->dob_day,
                    'month' => (int)$user->Profile->dob_month,
                    'year' => (int)$user->Profile->dob_year,
                ],

                'option' => [
                    'creation_watch_state' => $user->Option->creation_watch_state,
                    'interaction_watch_state' => $user->Option->interaction_watch_state,
                    'content_show_signature' => (bool)$user->Option->content_show_signature,
                    'email_on_conversation' => (bool)$user->Option->email_on_conversation,
                    'push_on_conversation' => (bool)$user->Option->push_on_conversation,
                    'receive_admin_email' => (bool)$user->Option->receive_admin_email,
                    'show_dob_year' => (bool)$user->Option->show_dob_year,
                    'show_dob_date' => (bool)$user->Option->show_dob_date,
                    'is_discouraged' => (bool)$user->Option->is_discouraged,
                ],

                'profile' => [
                    'location' => $user->Profile->location,
                    'website' => $user->Profile->website,
                    'about' => $user->Profile->about,
                    'signature' => $user->Profile->signature,
                ],

                'privacy' => [
                    'allow_view_profile' => $user->Privacy->allow_view_profile,
                    'allow_post_profile' => $user->Privacy->allow_post_profile,
                    'allow_receive_news_feed' => $user->Privacy->allow_receive_news_feed,
                    'allow_send_personal_conversation' => $user->Privacy->allow_send_personal_conversation,
                    'allow_view_identities' => $user->Privacy->allow_view_identities,
                ],

                //'custom_fields' => $user->Profile->getBehavior('XF:CustomFields')->getValues(),

                'api_bypass_permissions' => 1,
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
                        "XF-Api-Key: $apiKey\r\n" .
                        "XF-Api-User: 1\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($postData),
                    'ignore_errors' => true,
                ]
            ];

            $context  = stream_context_create($options);
            $response = file_get_contents($apiUrl, false, $context);

            $statusLine = $http_response_header[0] ?? '';
            preg_match('{HTTP\/\S*\s(\d{3})}', $statusLine, $match);
            $statusCode = $match[1] ?? 0;

            $data = json_decode($response, true);

            if ($statusCode == 200 && isset($data['user']['user_id'])) {
                $this->loginUserRedirect($data['user']['user_id']);

            }
        }
    }

    private function loginUserRedirect($userId)
    {

        $apiKey = \XF::options()->fspr_api_key;
        $paymentSiteUrl = \XF::options()->fspr_payment_site_url;

        // **** User Login ***********************************

        $returnUrl = $paymentSiteUrl . 'index.php?account/upgrades'; 

        $apiUrl = $paymentSiteUrl . 'index.php/api/auth/login-token';

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

        if ($statusCode == 200 && !empty($data['login_url'])) {
            // Redirect to Site B login URL
            header('Location: ' . $data['login_url']);
            exit;
        } else {
            return $this->error(\XF::phrase('failed'));

        }
    }
}
