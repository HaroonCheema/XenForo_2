<?php

namespace DC\LinkProxy\Cron;

class TFAuth
{
    //    public static function resetPassword()
    //    {
    //        $options = \XF::options();
    //
    //        $checkResetPassword = \XF::finder('DC\LinkProxy:TFAuth')->order('id', 'DESC')->fetchOne();
    //
    //        if (isset($checkResetPassword->id)) {
    //
    //            $resetTime = $checkResetPassword->created_at + intval($options->DC_LinkProxy_pass_reset_time);
    //            if ($resetTime < time()) {
    //                $tfaPassword = self::generateTfaPassword(intval($options->DC_LinkProxy_pass_length));
    //
    //                $insertPassword = \XF::em()->create('DC\LinkProxy:TFAuth');
    //
    //                $insertPassword->expired_at = time() + intval($options->DC_LinkProxy_pass_expire_time);
    //                $insertPassword->auth_password = $tfaPassword;
    //
    //                $insertPassword->save();
    //            }
    //        } else {
    //            $tfaPassword = self::generateTfaPassword(intval($options->DC_LinkProxy_pass_length));
    //
    //            $insertPassword = \XF::em()->create('DC\LinkProxy:TFAuth');
    //
    //            $insertPassword->expired_at = time() + intval($options->DC_LinkProxy_pass_expire_time);
    //            $insertPassword->auth_password = $tfaPassword;
    //
    //            $insertPassword->save();
    //        }
    //
    //        $deleteExpiredPasswords = \XF::finder('DC\LinkProxy:TFAuth')->where('expired_at', '<', time())->fetch();
    //
    //        if (count($deleteExpiredPasswords)) {
    //            foreach ($deleteExpiredPasswords as $value) {
    //                $value->delete();
    //            }
    //        }
    //    }


    public static function resetPassword()
    {
        $options = \XF::options();
        $currentTime = time();

        $host = $options->DC_LinkProxy_db_host;
        $dbname = $options->DC_LinkProxy_db_name;
        $username = $options->DC_LinkProxy_db_username;
        $dbPassword = $options->DC_LinkProxy_db_password;

        if (empty($host) && empty($dbname) && empty($username) && empty($dbPassword)) {
            $passwordResetTime = intval($options->DC_LinkProxy_pass_reset_time);
            $passwordExpaireTime = intval($options->DC_LinkProxy_pass_expire_time);
            $passwordLength = intval($options->DC_LinkProxy_pass_length);


            self::deleteExpirePasswords();                                                 // Delete expired passwords

            // Check if there are any existing passwords
            $existingPassword = \XF::finder('DC\LinkProxy:TFAuth')
                ->order('id', 'DESC')
                ->fetchOne();

            $tfaPassword = self::generateTfaPassword($passwordLength);                     // Generate new TFA password

            if (!$existingPassword) {
                // Create a new TFAuth entity
                $newTFAuth = \XF::em()->create('DC\LinkProxy:TFAuth');
                $newTFAuth->expired_at = $currentTime + $passwordExpaireTime;
                $newTFAuth->auth_password = $tfaPassword;
                $newTFAuth->save();
            } elseif ($existingPassword->created_at + $passwordResetTime < $currentTime)   // reset password (update the $existing record )
            {
                $existingPassword->created_at = $currentTime;
                $existingPassword->expired_at = $currentTime + $passwordExpaireTime;
                $existingPassword->auth_password = $tfaPassword;
                $existingPassword->save();
            }
        }
    }

    public static function deleteExpirePasswords()   // Delete expired passwords
    {
        $currentTime = time();

        $expiredPasswords = \XF::finder('DC\LinkProxy:TFAuth')
            ->where('expired_at', '<', $currentTime)
            ->fetch();

        foreach ($expiredPasswords as $expiredPassword) {
            $expiredPassword->delete();
        }
    }


    public static function generateTfaPassword($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
