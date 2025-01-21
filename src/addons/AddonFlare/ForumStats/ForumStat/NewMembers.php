<?php

namespace AddonFlare\ForumStats\ForumStat;

class NewMembers extends AbstractForumStat
{
    protected $defaultOptions = [
        'limit'          => 5,
        'rich_usernames' => true,
        'show_counter' => false,
    ];

    public function render()
    {
        if (!\XF::visitor()->canViewMemberList())
        {
            return '';
        }

        $userFinder = $this->finder('XF:User')
            ->isValidUser()
            ->order('register_date', 'DESC')
            ->limit($this->options['limit']);

        foreach ($users = $userFinder->fetch() AS $userId => $user)
        {
            if ($this->ignoreContentAddonIsIgnored($user))
            {
                unset($users[$userId]);
            }
        }

        $viewParams = [
            'users' => $users,
        ];
        return $this->renderer('af_forumstats_new_members', $viewParams);
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit' => 'uint',
            'rich_usernames' => 'bool',
            'show_counter' => 'bool',
        ]);

        if ($options['limit'] < 1)
        {
            $options['limit'] = 1;
        }

        return true;
    }
}