<?php

namespace AddonFlare\PaidRegistrations\XF\Entity;
use AddonFlare\PaidRegistrations\Listener;

class User extends XFCP_User
{
    // used to publically call this verification method and only return the errors it has (if any)
    public function verifyVerifyEmail(&$email, &$errors = [])
    {
        $errorsBefore = $this->getErrors();

        $verify = $this->verifyEmail($email);

        $errorsAfter = $this->getErrors();

        // find differences incase any errors existsted before this method was called (not likely but just incase)
        $errors = array_diff_key($errorsAfter, $errorsBefore);

        if ($errors)
        {
            // used to patch a bug in the "AllowedEmails" add-on from our end, since it adds an error but doesn't return false
            $verify = false;
        }

        return $verify;
    }

    public function canGiftUserUpgrade($toUser = null)
    {
        // required to prevent class doesn't exist error
        $class = \XF::extendClass('XF\Pub\Controller\Purchase');

        if (!$toUser)
        {
            $toUserCanBeGifted = true;
        }
        else
        {
            $toUserCanBeGifted = (
                ($this->user_id != $toUser->user_id)
            );
        }

        return (
            Listener::classMethodExists($class, 'actionGiftUpgrade') &&
            $this->app()->options()->af_paidregistrations_gift_upgrades &&
            $this->user_id &&
            $toUserCanBeGifted
        );
    }
}