<?php

namespace FS\LastCreditAssigned\XF\Entity;


class User extends XFCP_User
{
    public function getLastCreditDate()
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id || !$visitor->is_admin || !$visitor->is_moderator) {
            return false;
        }

        $finder = $this->finder('ThemeHouse\ThreadCredits:UserCreditPackage')->where('user_id', $this->user_id)->order('purchased_at', 'DESC')->fetchOne();

        return  $finder ?: false;
    }
}
