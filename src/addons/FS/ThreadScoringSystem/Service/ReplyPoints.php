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

        if ($totalPost) {
            $this->postReplyPointsAddEdits($thread, $usersPostCounts, $totalPost, $userIds);
        }

        if ($totalWords) {
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

            $percentage = ($userPosts / $totalPost) * 100;

            $pointsFromPercentage = ($percentage / 100) * $totalPoints;

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

        return true;
    }

    protected function postReplyWordsPointsAddEdits(\XF\Entity\Thread $thread, $usersWordCounts, $totalWords, $userIds)
    {
        $options = \XF::options();

        $totalPoints = intval($options->fs_total_words_points);

        foreach ($usersWordCounts as $key => $value) {

            $userWords = $value;

            $percentage = ($userWords / $totalWords) * 100;

            $pointsFromPercentage = ($percentage / 100) * $totalPoints;

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

        return true;
    }

    protected function postReplyReactionsPointsAddEdits(\XF\Entity\Thread $thread, $usersReactionCounts, $totalReactions, $userIds)
    {
        $options = \XF::options();

        $totalPoints = intval($options->fs_reply_reaction_points);

        foreach ($usersReactionCounts as $key => $value) {

            $userReactions = $value;

            $percentage = ($userReactions / $totalReactions) * 100;

            $pointsFromPercentage = ($percentage / 100) * $totalPoints;

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

        return true;
    }

    public function getAllTypePointsScores($records)
    {

        $totalCounts = array();
        $newRecords = array();

        foreach ($records as  $value) {

            $userId = $value->user_id;

            if (isset($totalCounts[$userId]['totalPoints'])) {

                $totalCounts[$userId]['totalPoints'] += $value['points'];
            } else {
                $newRecords[] = $value;

                $totalCounts[$userId]['totalPoints'] = $value['points'];
            }

            switch ($value['points_type']) {
                case 'reply': {
                        if (isset($totalCounts[$userId]['reply'])) {

                            $totalCounts[$userId]['reply'] += floatval($value['points']);
                        } else {

                            $totalCounts[$userId]['reply'] = floatval($value['points']);
                        }
                    }
                    break;

                case 'words': {
                        if (isset($totalCounts[$userId]['words'])) {

                            $totalCounts[$userId]['words'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['words'] = $value['points'];
                        }
                    }
                    break;

                case 'reactions': {
                        if (isset($totalCounts[$userId]['reactions'])) {

                            $totalCounts[$userId]['reactions'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['reactions'] = $value['points'];
                        }
                    }
                    break;

                case 'thread': {
                        if (isset($totalCounts[$userId]['thread'])) {

                            $totalCounts[$userId]['thread'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['thread'] = $value['points'];
                        }
                    }
                    break;

                case 'solution': {
                        if (isset($totalCounts[$userId]['solution'])) {

                            $totalCounts[$userId]['solution'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['solution'] = $value['points'];
                        }
                    }
                    break;
                    // default:
                    //     $value = 0;
            }
        }

        $sumParams = [
            'totalCounts' => $totalCounts,
            'records' => $newRecords,
        ];

        return $sumParams;
    }

    public function getAllTypePercentageScores($records)
    {

        $totalPercentage = array();
        $newRecords = array();

        foreach ($records as  $value) {

            $userId = $value->user_id;

            if (isset($totalPercentage[$userId]['totalPoints'])) {

                $totalPercentage[$userId]['totalPoints'] += $value['percentage'];
            } else {
                $newRecords[] = $value;

                $totalPercentage[$userId]['totalPoints'] = $value['percentage'];
            }

            switch ($value['points_type']) {
                case 'reply': {
                        if (isset($totalPercentage[$userId]['reply'])) {

                            $totalPercentage[$userId]['reply'] += floatval($value['percentage']);
                        } else {

                            $totalPercentage[$userId]['reply'] = floatval($value['percentage']);
                        }
                    }
                    break;

                case 'words': {
                        if (isset($totalPercentage[$userId]['words'])) {

                            $totalPercentage[$userId]['words'] += $value['percentage'];
                        } else {

                            $totalPercentage[$userId]['words'] = $value['percentage'];
                        }
                    }
                    break;

                case 'reactions': {
                        if (isset($totalPercentage[$userId]['reactions'])) {

                            $totalPercentage[$userId]['reactions'] += $value['percentage'];
                        } else {

                            $totalPercentage[$userId]['reactions'] = $value['percentage'];
                        }
                    }
                    break;

                case 'thread': {
                        if (isset($totalPercentage[$userId]['thread'])) {

                            $totalPercentage[$userId]['thread'] += $value['percentage'];
                        } else {

                            $totalPercentage[$userId]['thread'] = $value['percentage'];
                        }
                    }
                    break;

                case 'solution': {
                        if (isset($totalPercentage[$userId]['solution'])) {

                            $totalPercentage[$userId]['solution'] += $value['percentage'];
                        } else {

                            $totalPercentage[$userId]['solution'] = $value['percentage'];
                        }
                    }
                    break;
            }
        }

        $sumParams = [
            'totalPercentage' => $totalPercentage,
            'records' => $newRecords,
        ];

        return $sumParams;
    }

    public function getPointsSums($records)
    {

        if (count($records)) {
            $options = \XF::options();

            $sumParams = $this->getAllTypePointsScores($records);

            if ($options->fs_thread_scoring_list_order == 'asc') {
                uasort($sumParams['totalCounts'], function ($a, $b) {
                    return $a['totalPoints'] <=> $b['totalPoints'];
                });
            } else {
                uasort($sumParams['totalCounts'], function ($a, $b) {
                    return $b['totalPoints'] <=> $a['totalPoints'];
                });
            }

            $newRecordOrderBy = array();

            foreach ($sumParams['totalCounts'] as $key => $value) {

                if ($value['totalPoints'] >= $options->fs_total_minimum_req_points) {
                    foreach ($sumParams['records'] as $value) {
                        if ($key == $value->user_id) {
                            $newRecordOrderBy[] = $value;
                        }
                    }
                }
            }

            $sumOredByParams = [
                'totalCounts' => $sumParams['totalCounts'],
                'records' => $newRecordOrderBy,
            ];
        } else {
            $sumOredByParams = array();
        }

        return $sumOredByParams;
    }

    public function getPercentageSums($records)
    {
        if (count($records)) {
            $options = \XF::options();

            $sumParams = $this->getAllTypePercentageScores($records);

            if ($options->fs_thread_scoring_list_order == 'asc') {
                uasort($sumParams['totalPercentage'], function ($a, $b) {
                    return $a['totalPoints'] <=> $b['totalPoints'];
                });
            } else {
                uasort($sumParams['totalPercentage'], function ($a, $b) {
                    return $b['totalPoints'] <=> $a['totalPoints'];
                });
            }

            $newRecordOrderBy = array();

            foreach ($sumParams['totalPercentage'] as $key => $value) {

                if ($value['totalPoints'] >= $options->fs_total_minimum_req_points) {
                    foreach ($sumParams['records'] as $value) {
                        if ($key == $value->user_id) {
                            $newRecordOrderBy[] = $value;
                        }
                    }
                }
            }

            $sumOredByParams = [
                'totalPercentage' => $sumParams['totalPercentage'],
                'records' => $newRecordOrderBy,
            ];
        } else {
            $sumOredByParams = array();
        }

        return $sumOredByParams;
    }
}
