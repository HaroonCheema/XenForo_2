<?php

namespace FS\ThreadScoringSystem\Service;

class ReplyPoints extends \XF\Service\AbstractService
{
    public function addEditReplyPoints(\XF\Entity\Thread $thread, $postId = 0)
    {
        $posts = \XF::finder('XF:Post')->where('thread_id', $thread->thread_id)->fetch();

        $userIds = array();

        $totalPost = 0;
        $totalWords = 0;
        $totalReactions = 0;

        $usersPostCounts = array();
        $usersWordCounts = array();
        $usersReactionCounts = array();

        foreach ($posts as  $post) {
            if (($post->message_state == 'visible') && ($post->post_id != $postId)) {
                $userId = $post->user_id;
                $message = $post->message;
                $reactions = $post->reaction_score;

                $wordArray = str_word_count($message, 1);

                $wordCount = count($wordArray);

                $totalPost += 1;
                $totalWords += $wordCount;
                $totalReactions += $reactions;

                if (isset($usersPostCounts[$userId])) {

                    $usersPostCounts[$userId] += 1;
                    $usersWordCounts[$userId] += $wordCount;
                    $usersReactionCounts[$userId] += $reactions;
                } else {
                    $userIds[] = $userId;

                    $usersPostCounts[$userId] = 1;
                    $usersWordCounts[$userId] = $wordCount;
                    $usersReactionCounts[$userId] = $reactions;
                }
            }
        }

        if ($usersPostCounts) {
            $this->postReplyPointsAddEdits($thread, $usersPostCounts, $totalPost, $userIds);
        }

        if ($usersWordCounts) {
            $this->postReplyWordsPointsAddEdits($thread, $usersWordCounts, $totalWords, $userIds);
        }

        if ($totalReactions) {
            $this->postReplyReactionsPointsAddEdits($thread, $usersReactionCounts, $totalReactions, $userIds);
        }

        return true;
    }

    public function addEditSolutionPoints(\XF\Entity\ThreadQuestion $threadQuestion)
    {
        $options = \XF::options();

        $userId = $threadQuestion->solution_user_id;
        $threadId = $threadQuestion->thread_id;

        $userSolutionScore = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $userId)->where('points_type', 'solution')->where('thread_id', $threadId)->fetchOne();

        if (!$userSolutionScore) {
            $userSolutionScore = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
        }

        $userSolutionScore->bulkSet([
            'thread_id' => $threadId,
            'user_id' => $userId,
            'points_type' => 'solution',
            'points' => $options->fs_total_solution_points,
            'percentage' => '100',
        ]);

        $userSolutionScore->save();

        $otherUsers = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', '!=', $userId)->where('points_type', 'solution')->where('thread_id', $threadId)->fetch();

        if (count($otherUsers)) {
            foreach ($otherUsers as $value) {
                $value->delete();
            }
        }

        return true;
    }

    protected function postReplyPointsAddEdits(\XF\Entity\Thread $thread, $usersPostCounts, $totalPost, $userIds)
    {
        $options = \XF::options();

        $totalPoints = intval($options->fs_post_reply_points);

        foreach ($usersPostCounts as $key => $value) {

            $userPosts = $value;

            $percentage = round(($userPosts / $totalPost) * 100);

            $pointsFromPercentage = round(($percentage / 100) * $totalPoints);

            $userRepyScore = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $key)->where('points_type', 'reply')->where('thread_id', $thread->thread_id)->fetchOne();

            if (!$userRepyScore) {
                $userRepyScore = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
            }

            $userRepyScore->bulkSet([
                'thread_id' => $thread->thread_id,
                'user_id' => $key,
                'points_type' => 'reply',
                'points' => $pointsFromPercentage,
                'percentage' => $percentage,
            ]);

            $userRepyScore->save();
        }

        $otherUsers = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', '!=', $userIds)->where('points_type', 'reply')->where('thread_id', $thread->thread_id)->fetch();

        if (count($otherUsers)) {
            foreach ($otherUsers as $value) {
                $value->delete();
            }
        }
    }

    protected function postReplyWordsPointsAddEdits(\XF\Entity\Thread $thread, $usersWordCounts, $totalWords, $userIds)
    {
        $options = \XF::options();

        $totalPoints = intval($options->fs_total_words_points);

        foreach ($usersWordCounts as $key => $value) {

            $userWords = $value;

            $percentage = round(($userWords / $totalWords) * 100);

            $pointsFromPercentage = round(($percentage / 100) * $totalPoints);

            $userWordsScore = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $key)->where('points_type', 'words')->where('thread_id', $thread->thread_id)->fetchOne();

            if (!$userWordsScore) {
                $userWordsScore = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
            }

            $userWordsScore->bulkSet([
                'thread_id' => $thread->thread_id,
                'user_id' => $key,
                'points_type' => 'words',
                'points' => $pointsFromPercentage,
                'percentage' => $percentage,
            ]);

            $userWordsScore->save();
        }

        $otherUsers = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', '!=', $userIds)->where('points_type', 'words')->where('thread_id', $thread->thread_id)->fetch();

        if (count($otherUsers)) {
            foreach ($otherUsers as $value) {
                $value->delete();
            }
        }
    }

    protected function postReplyReactionsPointsAddEdits(\XF\Entity\Thread $thread, $usersReactionCounts, $totalReactions, $userIds)
    {
        $options = \XF::options();

        $totalPoints = intval($options->fs_reply_reaction_points);

        foreach ($usersReactionCounts as $key => $value) {

            $userReactions = $value;

            $percentage = round(($userReactions / $totalReactions) * 100);

            $pointsFromPercentage = round(($percentage / 100) * $totalPoints);

            $userReactionsScore = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $key)->where('points_type', 'reactions')->where('thread_id', $thread->thread_id)->fetchOne();

            if (!$userReactionsScore) {
                $userReactionsScore = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
            }

            $userReactionsScore->bulkSet([
                'thread_id' => $thread->thread_id,
                'user_id' => $key,
                'points_type' => 'reactions',
                'points' => $pointsFromPercentage,
                'percentage' => $percentage,
            ]);

            $userReactionsScore->save();
        }

        $otherUsers = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', '!=', $userIds)->where('points_type', 'reactions')->where('thread_id', $thread->thread_id)->fetch();

        if (count($otherUsers)) {
            foreach ($otherUsers as $value) {
                $value->delete();
            }
        }
    }
}
