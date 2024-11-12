<?php

namespace FS\ThreadScoringSystem\Service;

class ReplyPoints extends \XF\Service\AbstractService
{
    public function addEditReplyPoints(\XF\Entity\Thread $thread, $postId = 0)
    {
        $posts = \XF::finder('XF:Post')->where('thread_id', $thread->thread_id)->fetch();

        $userIds = array();
        $userIdUsers = array();

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
                    $userIdUsers[$userId] = isset($post->User) ? $post->User : [];

                    $usersPostCounts[$userId] = 1;
                    $usersWordCounts[$userId] = $wordCount;
                    $usersReactionCounts[$userId] = $reactions;
                }
            }
        }

        if ($totalPost) {
            $this->postReplyPointsAddEdits($thread, $usersPostCounts, $totalPost, $userIds, $usersWordCounts, $totalWords, $usersReactionCounts, $totalReactions, $userIdUsers);
        }

        return true;
    }

    protected function postReplyPointsAddEdits(\XF\Entity\Thread $thread, $usersPostCounts, $totalPost, $userIds, $usersWordCounts, $totalWords, $usersReactionCounts, $totalReactions, $userIdUsers)
    {
        $options = \XF::options();
        $db = \XF::db();

        $replyTotalPoints = intval($options->fs_post_reply_points);
        $wordTotalPoints = intval($options->fs_total_words_points);
        $reactionTotalPoints = intval($options->fs_reply_reaction_points);

        $reactionUserIds = array();

        foreach ($usersPostCounts as $key => $value) {

            if ($value) {
                $userPosts = $value;

                $replyPercentage = ($userPosts / $totalPost) * 100;

                $replyPoints = ($replyPercentage / 100) * $replyTotalPoints;
            } else {
                $replyPoints = 0;
                $replyPercentage = 0;
            }

            if ($totalWords && isset($usersWordCounts[$key])) {
                $userWords = $usersWordCounts[$key];

                $wordPercentage = ($userWords / $totalWords) * 100;

                $wordPoints = ($wordPercentage / 100) * $wordTotalPoints;
            } else {
                $wordPoints = 0;
                $wordPercentage = 0;
            }

            if ($totalReactions && isset($usersReactionCounts[$key])) {
                $userReaction = $usersReactionCounts[$key];

                $reactionPercentage = ($userReaction / $totalReactions) * 100;

                $reactionPoints = ($reactionPercentage / 100) * $reactionTotalPoints;

                $reactionUserIds[] = $key;
            } else {
                $reactionPoints = 0;
                $reactionPercentage = 0;
            }

            $totalPoints = $replyPoints + $wordPoints + $reactionPoints;
            $totalPercentage = $replyPercentage + $wordPercentage + $reactionPercentage;

            $userExist = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $key)->where('thread_id', $thread->thread_id)->fetchOne();

            if (!$userExist) {
                $userExist = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
                $userExist->total_points = $totalPoints;
                $userExist->total_percentage = $totalPercentage;
            } else {
                $userExist->total_points += $totalPoints;
                $userExist->total_percentage += $totalPercentage;
            }

            $userExist->thread_id = $thread->thread_id;
            $userExist->user_id = $key;
            $userExist->reply_points = $replyPoints;
            $userExist->reply_percentage = $replyPercentage;

            $userExist->word_points = $wordPoints;
            $userExist->word_percentage = $wordPercentage;

            $userExist->reaction_points = $reactionPoints;
            $userExist->reaction_percentage = $reactionPercentage;

            $userExist->save();


            $currentUser = $userIdUsers[$key];

            if (isset($currentUser) && $thread->last_cron_run == 0) {

                $currentUser->reply_score += $replyPoints;
                $currentUser->worlds_score += $wordPoints;
                $currentUser->reactions_score += $reactionPoints;
                $currentUser->total_score += $totalPoints;

                $currentUser->save();
            }
        }

        $reactionPendingUserIds = array_diff($userIds, $reactionUserIds);

        if ($totalReactions && count($reactionPendingUserIds)) {

            foreach ($reactionPendingUserIds as $value) {

                if (isset($usersReactionCounts[$value])) {
                    $userReaction = $usersReactionCounts[$value];

                    $reactionPercentage = ($userReaction / $totalReactions) * 100;

                    $reactionPoints = ($reactionPercentage / 100) * $reactionTotalPoints;
                } else {
                    $reactionPoints = 0;
                    $reactionPercentage = 0;
                }

                if ($reactionPoints) {

                    $userExist = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $value)->where('thread_id', $thread->thread_id)->fetchOne();

                    if (!$userExist) {
                        $userExist = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
                        $userExist->total_points = $reactionPoints;
                        $userExist->total_percentage = $reactionPercentage;
                    } else {
                        $userExist->total_points += $reactionPoints;
                        $userExist->total_percentage += $reactionPercentage;
                    }

                    $userExist->thread_id = $thread->thread_id;
                    $userExist->user_id = $value;

                    $userExist->reaction_points = $reactionPoints;
                    $userExist->reaction_percentage = $reactionPercentage;

                    $userExist->save();

                    $currentUser = $userIdUsers[$value];

                    if (isset($currentUser) && $thread->last_cron_run == 0) {

                        $currentUser->reactions_score += $reactionPoints;
                        $currentUser->total_score += $reactionPoints;

                        $currentUser->save();
                    }
                }
            }
        }

        if ($thread->last_thread_update > $thread->last_cron_run) {

            foreach ($userIdUsers as $key => $user) {
                if ($user) {

                    $updateThreadUserTotal =  $db->fetchRow(
                        "SELECT SUM(`thread_points`) AS threads_score,
                    SUM(`reply_points`) AS reply_score,
                    SUM(`word_points`) AS worlds_score,
                    SUM(`reaction_points`) AS reactions_score,
                    SUM(`solution_points`) AS solutions_score,
                    SUM(`total_points`) AS total_score
                    FROM fs_thread_scoring_system
                    WHERE user_id  = ?
                ",
                        [
                            $key,
                        ]
                    );

                    $user->threads_score = floatval($updateThreadUserTotal['threads_score']);
                    $user->reply_score = floatval($updateThreadUserTotal['reply_score']);
                    $user->worlds_score = floatval($updateThreadUserTotal['worlds_score']);
                    $user->reactions_score = floatval($updateThreadUserTotal['reactions_score']);
                    $user->solutions_score = floatval($updateThreadUserTotal['solutions_score']);
                    $user->total_score = floatval($updateThreadUserTotal['total_score']);

                    $user->save();
                }
            }
        }

        $prevUsers = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', '!=', $userIds)->where('thread_id', $thread->thread_id)->fetch();

        if (count($prevUsers)) {
            foreach ($prevUsers as $value) {
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
