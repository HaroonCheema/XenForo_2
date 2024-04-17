<?php

namespace FS\UsergroupUsersCount\Service;

class UsersCount extends \XF\Service\AbstractService
{
    public function countAllUsers()
    {
        $userGroups = \XF::finder('XF:UserGroup')->fetch();

        if (count($userGroups) > 0) {

            foreach ($userGroups as $userGroup) {

                $primaryUsersCount = \XF::finder('XF:User')->where('user_group_id', $userGroup->user_group_id)->fetch();

                // $secondaryUsersCount = \XF::finder('XF:User')->where('secondary_group_ids', 'LIKE', '%' . $userGroup->user_group_id . '%')->fetch();

                $secondaryUsersCount = 0;

                $allUsers = \XF::finder('XF:User')->fetch();

                foreach ($allUsers as $user) {

                    if (in_array($userGroup->user_group_id, $user->secondary_group_ids)) {
                        $secondaryUsersCount += 1;
                    }
                }

                $update = [
                    'primary_users_count' => count($primaryUsersCount),
                    'secondary_users_count' => $secondaryUsersCount
                ];

                $userGroup->fastUpdate($update);
            }
        }
    }
}
