<?php

namespace FS\ApproveRejectedUser\XF\ApprovalQueue;

class User extends XFCP_User
{
    public function actionReject(\XF\Entity\User $user)
    {
        $parent = parent::actionReject($user);

        \XF::app()->db()->insert('xf_approval_queue', [
            'content_type' => 'fs_rejected_user',
            'content_id' => $user->user_id,
            'content_date' => \XF::$time
        ], false, 'content_date = VALUES(content_date)');

        return $parent;
    }
}
