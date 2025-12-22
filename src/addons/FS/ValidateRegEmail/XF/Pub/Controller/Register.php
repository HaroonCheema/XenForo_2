<?php

namespace FS\ValidateRegEmail\XF\Pub\Controller;

class Register extends XFCP_Register
{
    protected function setupRegistration(array $input)
    {
        $email = $input['email'];

        $key = \XF::options()->fs_validate_email_api_key;

        if (!$key) {
            return parent::setupRegistration($input);
        }

        $url = "https://apps.emaillistverify.com/api/verifyEmail?secret=" . $key . "&email=" . urlencode($email) . "&timeout=15";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        // echo $response;
        curl_close($ch);

        if ($response != "ok") {
            throw $this->exception(
                $this->error(\XF::phrase('fs_validate_email_spam_detected'))
            );
        }

        return parent::setupRegistration($input);
    }
}
