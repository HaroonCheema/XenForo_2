<?php

namespace FS\ThreadScoringSystem\Service;

class ReplyPoints extends \XF\Service\AbstractService
{
    public function addEditReplyPoints($thread)
    {
        $posts = \XF::finder('XF:Post')->where('thread_id', $thread->thread_id)->fetch();

        $usersPostCounts = array();
        $userIds = array();

        foreach ($posts as  $post) {

            $userId = $post->user_id;

            if (isset($usersPostCounts[$userId])) {
                $usersPostCounts[$userId] += 1;
            } else {
                $usersPostCounts[$userId] = 1;
                $userIds[] = $userId;
            }
        }

        $options = \XF::options();

        $totalPoints = intval($options->fs_post_reply_points);

        foreach ($usersPostCounts as $key => $value) {
            $totalPost = $thread->reply_count + 1;
            $userPosts = $value;

            $percentage = round(($userPosts / $totalPost) * 100);

            $pointsFromPercentage = round(($percentage / 100) * $totalPoints);

            $userRepyScore = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $key)->where('points_type', 'reply')->where('thread_id', $thread->thread_id)->fetchOne();

            if (!$userRepyScore) {
                $userRepyScore = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
            }

            $userRepyScore->thread_id = $thread->thread_id;
            $userRepyScore->user_id = $key;
            $userRepyScore->points_type = 'reply';
            $userRepyScore->points = $pointsFromPercentage;
            $userRepyScore->percentage = $percentage;

            $userRepyScore->save();
        }

        $otherUsers = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', '!=', $userIds)->where('points_type', 'reply')->where('thread_id', $thread->thread_id)->fetch();

        if (count($otherUsers)) {
            foreach ($otherUsers as $value) {
                $value->delete();
            }
        }

        return true;
    }
}
