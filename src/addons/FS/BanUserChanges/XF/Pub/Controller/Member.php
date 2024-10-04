<?php

namespace FS\BanUserChanges\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionBanLift(ParameterBag $params)
    {
        if ($this->isPost()) {
            $user = $this->assertViewableUser($params->user_id, [], true);

            $bannedUserthread = $user->Ban->Thread;

            if ($bannedUserthread) {

                $postAll = $this->finder('XF:Post')->where('thread_id', $bannedUserthread->thread_id)->where('post_id', '!=', $bannedUserthread->FirstPost->post_id)->fetch();

                if (count($postAll)) {
                    foreach ($postAll as $value) {

                        $value->delete();
                    }
                }
                $bannedUserthread->fastUpdate('discussion_open', false);
            }

            return parent::actionBanLift($params);
        } else {
            return parent::actionBanLift($params);
        }
    }

    public function actionBanSave(ParameterBag $params)
    {
        $parent = parent::actionBanSave($params);

        $bannedUser = \xf::app()->em()->find('XF:User', $params->user_id);

        $threadId = $bannedUser->Ban->thread_id;

        $options = \XF::options();
        $applicableForum = $options->fs_banned_users_applic_forum;

        if (intval($applicableForum) && $bannedUser && !$threadId) {
            $forum = $this->assertViewableForum($applicableForum ?: 0);

            if ($forum) {

                $isPreRegThread = $forum->canCreateThreadPreReg();

                $creatableThreadTypes = [];
                foreach ($forum->getCreatableThreadTypes() as $threadType) {
                    $handler = $this->app->threadType($threadType, false);
                    if ($handler) {
                        $creatableThreadTypes[$threadType] = $handler;
                    }
                }

                $draftThreadType = $forum->draft_thread['discussion_type'];
                if ($draftThreadType && isset($creatableThreadTypes[$draftThreadType])) {
                    $defaultThreadType = $draftThreadType;
                } else {
                    $defaultThreadType = key($creatableThreadTypes);
                }

                $switches = [
                    'inline-mode' => false,
                    'more-options' => false
                ];

                if ($switches['more-options']) {
                    $switches['inline-mode'] = false;
                }

                $thread = null;
                $post = null;
                $tags = null;

                $creator = $this->setupThreadCreate($forum, $bannedUser);
                $creator->checkForSpam();

                if (!$creator->validate($errors)) {
                    return $this->error($errors);
                }
                $this->assertNotFlooding('thread', $this->app->options()->floodCheckLengthDiscussion ?: null);

                /** @var \XF\Entity\Thread $thread */
                $thread = $creator->save();
                $this->finalizeThreadCreate($creator, $bannedUser);
            }
        } elseif ($threadId) {

            $bannedUserThread = $bannedUser->Ban->Thread;

            if ($bannedUserThread) {

                $issuedTo = $bannedUser->username;
                $issuedBy = $bannedUser->Ban->BanUser->username;
                $banDate = date('M d Y', $bannedUser->Ban->ban_date);
                $endDate = $bannedUser->Ban->end_date ? date('M d Y', $bannedUser->Ban->end_date) : 'Permanent';
                $reasonBan = $bannedUser->Ban->user_reason;


                $message = "Issued to:  $issuedTo
Issued by: $issuedBy  
Ban date: $banDate
End date: $endDate
Reason: $reasonBan";


                $bannedUserThread->FirstPost->fastUpdate('message', $message);
            }
        }

        return $parent;
    }

    /**
     * @param \XF\Entity\Forum $forum
     *
     * @return \XF\Service\Thread\Creator
     */
    protected function setupThreadCreate(\XF\Entity\Forum $forum, $user)
    {
        // $user = \xf::app()->em()->find('XF:User', $bannedUserId);

        $input = $this->filter([
            'ban_length' => 'str',
            'end_date' => 'datetime',
            'user_reason' => 'str'
        ]);

        if ($input['ban_length'] == 'permanent') {
            $input['end_date'] = 0;
        }


        $visitor = \XF::visitor();

        $banDate = date('M d Y', time());
        $endDate = $input['end_date'] ? date('M d Y', $input['end_date']) : 'Permanent';
        $reasonBan = $input["user_reason"];


        $title = "Ban issued to user " . $user->username;
        $message = "Issued to:  $user->username
Issued by: $visitor->username  
Ban date: $banDate
End date: $endDate
Reason: $reasonBan";

        /** @var \XF\Service\Thread\Creator $creator */

        $creator = $this->service('XF:Thread\Creator', $forum);

        // $creator->setBannedUser($user);

        $isPreRegAction = $forum->canCreateThreadPreReg();

        $creator->setDiscussionTypeAndData(
            "discussion",
            $this->request
        );

        $creator->setContent($title, $message);

        $canEditTags = \XF::asPreRegActionUserIfNeeded(
            $isPreRegAction,
            function () use ($forum) {
                return $forum->canEditTags();
            }
        );
        if ($canEditTags) {
            $creator->setTags("");
        }

        $setOptions = [
            'watch_thread' => true,
            'discussion_open' => false,
            'sticky' => false
        ];

        if ($setOptions) {
            $thread = $creator->getThread();

            $creator->setDiscussionOpen(true);
        }

        $customFields = [];
        $creator->setCustomFields($customFields);

        return $creator;
    }

    protected function finalizeThreadCreate(\XF\Service\Thread\Creator $creator, $bannedUser)
    {
        $creator->sendNotifications();

        $forum = $creator->getForum();
        $thread = $creator->getThread();
        $visitor = \XF::visitor();

        $bannedUser->Ban->fastUpdate('thread_id', $thread->thread_id);

        if ($thread->canWatch()) {
            /** @var \XF\Repository\ThreadWatch $threadWatchRepo */
            $threadWatchRepo = $this->repository('XF:ThreadWatch');

            $state = 'watch_email';
            $threadWatchRepo->setWatchState($thread, $visitor, $state);
        }

        if ($visitor->user_id) {
            $this->getThreadRepo()->markThreadReadByVisitor($thread, $thread->post_date);

            $forum->draft_thread->delete();
        }
    }

    /**
     * @return \XF\Repository\Thread
     */
    protected function getThreadRepo()
    {
        return $this->repository('XF:Thread');
    }

    /**
     * @param string|int $nodeIdOrName
     * @param array $extraWith
     *
     * @return \XF\Entity\Forum
     *
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertViewableForum($nodeIdOrName, array $extraWith = [])
    {
        if ($nodeIdOrName === null) {
            throw $this->exception($this->notFound(\XF::phrase('requested_forum_not_found')));
        }
        $visitor = \XF::visitor();

        $extraWith[] = 'Node.Permissions|' . $visitor->permission_combination_id;
        if ($visitor->user_id) {
            $extraWith[] = 'Read|' . $visitor->user_id;
        }

        $finder = $this->em()->getFinder('XF:Forum');
        $finder->with('Node', true)->with($extraWith);
        if (is_int($nodeIdOrName) || $nodeIdOrName === strval(intval($nodeIdOrName))) {
            $finder->where('node_id', $nodeIdOrName);
        } else {
            $finder->where(['Node.node_name' => $nodeIdOrName, 'Node.node_type_id' => 'Forum']);
        }

        /** @var \XF\Entity\Forum $forum */
        $forum = $finder->fetchOne();
        if (!$forum) {
            throw $this->exception($this->notFound(\XF::phrase('requested_forum_not_found')));
        }
        if (!$forum->canView($error)) {
            throw $this->exception($this->noPermission($error));
        }

        $this->plugin('XF:Node')->applyNodeContext($forum->Node);

        return $forum;
    }
}
