<?php

namespace FS\HideUsernames\Service;

use XF\Mvc\FormAction;

class HideUserNames extends \XF\Service\AbstractService
{
    public function genrateRandomNames()
    {
        $allUsers = \XF::finder('XF:User')->fetch();

        foreach ($allUsers as $user) {

            $length = rand(4, 6); // Generate a random length between 4 and 6

            $randomName = ucwords(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, $length));

            $user->fastUpdate('random_name', $randomName);
        }
    }
}
