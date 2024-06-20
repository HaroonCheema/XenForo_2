<?php

namespace DC\LinkProxy\Cron;

class TFAuth
{
    public static function resetPassword()
    {
        $options = \XF::options();

        $checkResetPassword = \XF::finder('DC\LinkProxy:TFAuth')->order('id', 'DESC')->fetchOne();

        if (isset($checkResetPassword->id)) {

            $resetTime = $checkResetPassword->created_at + intval($options->DC_LinkProxy_pass_reset_time);
            if ($resetTime < time()) {
                $tfaPassword = self::generateTfaPassword(intval($options->DC_LinkProxy_pass_length));

                $insertPassword = \XF::em()->create('DC\LinkProxy:TFAuth');

                $insertPassword->expired_at = time() + intval($options->DC_LinkProxy_pass_expire_time);
                $insertPassword->auth_password = $tfaPassword;

                $insertPassword->save();
            }
        } else {
            $tfaPassword = self::generateTfaPassword(intval($options->DC_LinkProxy_pass_length));

            $insertPassword = \XF::em()->create('DC\LinkProxy:TFAuth');

            $insertPassword->expired_at = time() + intval($options->DC_LinkProxy_pass_expire_time);
            $insertPassword->auth_password = $tfaPassword;

            $insertPassword->save();
        }

        $deleteExpiredPasswords = \XF::finder('DC\LinkProxy:TFAuth')->where('expired_at', '<', time())->fetch();

        if (count($deleteExpiredPasswords)) {
            foreach ($deleteExpiredPasswords as $value) {
                $value->delete();
            }
        }
    }

    public static function generateTfaPassword($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
