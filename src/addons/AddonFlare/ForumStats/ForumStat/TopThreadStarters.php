<?php

namespace AddonFlare\ForumStats\ForumStat;

class TopThreadStarters extends AbstractForumStat
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

        $mostThreadsUsers = $this->db()->query("
            SELECT COUNT(thread.thread_id) AS amount, user.*
            FROM xf_thread thread
            INNER JOIN xf_user user ON (user.user_id = thread.user_id)
            WHERE
                user.is_banned = 0
                AND user.user_state = 'valid'
            GROUP BY thread.user_id
            ORDER BY amount DESC
            LIMIT " . intval($this->options['limit'])
        );

        $users = $threadCounts = [];

        while ($row = $mostThreadsUsers->fetchAliasGrouped())
        {
            $user = $this->em()->instantiateEntity('XF:User', $row['user']);

            $threadCounts[$user->user_id] = $row['__extra']['amount'];

            $users[$user->user_id] = $user;
        }

        $users = $this->em()->getBasicCollection($users);

        foreach ($users AS $userId => $user)
        {
            if ($this->ignoreContentAddonIsIgnored($user))
            {
                unset($users[$userId]);
            }
        }

        $viewParams = [
            'users'        => $users,
            'threadCounts' => $threadCounts,
        ];

        return $this->renderer('af_forumstats_top_thread_starters', $viewParams);
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