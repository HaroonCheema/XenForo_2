<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;

class MonthWiseScore extends AbstractJob
{

    public function run($maxRunTime)
    {
        $options = \XF::options();

        $startDate = strtotime($options->fs_thread_start_date);
        $endDate = strtotime($options->fs_thread_end_date);

        $currentMonthUnix = strtotime(date("Y-m-01 00:00:00"));
        // $currentMonthUnix = '1725167466';

        if ($startDate && $endDate && ($endDate > $startDate)) {
            $postFinder = \XF::finder('XF:Post')->where('post_date', '>', $startDate)->where('post_date', '<', $endDate);
        } else {
            $postFinder = \XF::finder('XF:Post')->where('post_date', '>=', $currentMonthUnix);
        }

        $threadIds = $postFinder->pluckfrom('thread_id')->fetch()->toArray();

        $threadIds = array_unique($threadIds);

        $userIds = array();

        $options = \XF::options();

        $totalReplyPoints = intval($options->fs_post_reply_points);
        $totalWordsPoints = intval($options->fs_total_words_points);
        $totalPointsReactions = intval($options->fs_reply_reaction_points);

        $totalPointsThreads = intval($options->fs_thread_starter_points);
        $totalPointsSolutions = intval($options->fs_total_solution_points);

        $totalCounts = array();
        $userCounts = array();

        $userTotalCounts = array();

        if (count($threadIds)) {

            foreach ($threadIds as $key => $thread_id) {

                if ($startDate && $endDate && ($endDate > $startDate)) {
                    $posts = \XF::finder('XF:Post')->where('thread_id', $thread_id)->where('post_date', '>', $startDate)->where('post_date', '<', $endDate)->fetch();
                } else {
                    $posts = \XF::finder('XF:Post')->where('thread_id', $thread_id)->where('post_date', '>=', $currentMonthUnix)->fetch();
                }

                $totalCounts[$key]['Posts'] = 0;
                $totalCounts[$key]['Words'] = 0;
                $totalCounts[$key]['Reactions'] = 0;


                foreach ($posts as $post) {
                    if ($post->message_state == 'visible') {
                        $userId = $post->user_id;
                        $message = $post->message;
                        $reactions = $post->reaction_score;

                        $wordArray = str_word_count($message, 1);

                        $wordCount = count($wordArray);

                        $totalCounts[$key]['Posts'] += 1;
                        $totalCounts[$key]['Words'] += $wordCount;
                        $totalCounts[$key]['Reactions'] += $reactions;

                        if (isset($userCounts[$key][$userId])) {

                            $userCounts[$key][$userId]['Posts'] += 1;
                            $userCounts[$key][$userId]['Words'] += $wordCount;
                            $userCounts[$key][$userId]['Reactions'] += $reactions;
                        } else {
                            $userIds[$key] = $userId;

                            $userCounts[$key][$userId]['Posts'] = 1;
                            $userCounts[$key][$userId]['Words'] = $wordCount;
                            $userCounts[$key][$userId]['Reactions'] = $reactions;
                        }
                    }
                }

                if (isset($userCounts[$key])) {

                    foreach ($userCounts[$key] as $userKey => $value) {

                        if ($totalCounts[$key]['Posts']) {
                            $userPosts = $value['Posts'];

                            $percentageReply = ($userPosts / $totalCounts[$key]['Posts']) * 100;

                            $pointsFromPercentageReply = ($percentageReply / 100) * $totalReplyPoints;
                        } else {
                            $pointsFromPercentageReply = 0;
                        }

                        if ($totalCounts[$key]['Words']) {
                            $userWords = $value['Words'];

                            $percentageWords = ($userWords / $totalCounts[$key]['Words']) * 100;

                            $pointsFromPercentageWords = ($percentageWords / 100) * $totalWordsPoints;
                        } else {
                            $pointsFromPercentageWords = 0;
                        }

                        if ($totalCounts[$key]['Reactions']) {
                            $userReactions = $value['Reactions'];

                            $percentageReactions = ($userReactions / $totalCounts[$key]['Reactions']) * 100;

                            $pointsFromPercentageReactions = ($percentageReactions / 100) * $totalPointsReactions;
                        } else {
                            $pointsFromPercentageReactions = 0;
                        }

                        if (isset($userTotalCounts[$userKey])) {

                            $userTotalCounts[$userKey]['Post'] += $pointsFromPercentageReply;
                            $userTotalCounts[$userKey]['Word'] += $pointsFromPercentageWords;
                            $userTotalCounts[$userKey]['Reaction'] += $pointsFromPercentageReactions;
                        } else {

                            $userTotalCounts[$userKey]['Post'] = $pointsFromPercentageReply;
                            $userTotalCounts[$userKey]['Word'] = $pointsFromPercentageWords;
                            $userTotalCounts[$userKey]['Reaction'] = $pointsFromPercentageReactions;
                            $userTotalCounts[$userKey]['Thread'] = 0;
                            $userTotalCounts[$userKey]['Solution'] = 0;
                        }
                    }
                }
            }
        }

        if (count($userTotalCounts)) {

            $threadFinder = \XF::finder('XF:Thread')->where('thread_id',  $threadIds);

            $threadUserIds = $threadFinder->pluckfrom('user_id')->fetch()->toArray();

            if (count($threadUserIds)) {

                foreach ($threadUserIds as $UserId) {


                    if (isset($userTotalCounts[$UserId])) {

                        $userTotalCounts[$UserId]['Thread'] += $totalPointsThreads;
                    } else {

                        $userTotalCounts[$userKey]['Post'] = 0;
                        $userTotalCounts[$userKey]['Word'] = 0;
                        $userTotalCounts[$userKey]['Reaction'] = 0;
                        $userTotalCounts[$userKey]['Thread'] = $totalPointsThreads;
                        $userTotalCounts[$userKey]['Solution'] = 0;
                    }
                }
            }

            $threadSolutionFinder = \XF::finder('XF:ThreadQuestion')->where('thread_id',  $threadIds);

            $threadSolutionUserIds = $threadSolutionFinder->pluckfrom('solution_user_id')->fetch()->toArray();

            if (count($threadSolutionUserIds)) {

                foreach ($threadSolutionUserIds as $UserId) {

                    if ($UserId) {

                        if (isset($userTotalCounts[$UserId])) {

                            $userTotalCounts[$UserId]['Solution'] += $totalPointsSolutions;
                        } else {

                            $userTotalCounts[$userKey]['Post'] = 0;
                            $userTotalCounts[$userKey]['Word'] = 0;
                            $userTotalCounts[$userKey]['Reaction'] = 0;
                            $userTotalCounts[$userKey]['Thread'] = 0;
                            $userTotalCounts[$userKey]['Solution'] = $totalPointsSolutions;
                        }
                    }
                }
            }
        }

        if (count($userTotalCounts)) {
            foreach ($userTotalCounts as $key => $value) {
                $userExist = \XF::finder('FS\ThreadScoringSystem:TotalScoringCustom')->where('user_id', $key)->fetchOne();

                if (!$userExist) {
                    $userExist = \XF::em()->create('FS\ThreadScoringSystem:TotalScoringCustom');
                }

                $totalScore = $value['Thread'] + $value['Post'] + $value['Word'] + $value['Reaction'] + $value['Solution'];

                $userExist->bulkSet([
                    'user_id' => $key,
                    'threads_score' => $value['Thread'],
                    'reply_score' => $value['Post'],
                    'worlds_score' => $value['Word'],
                    'reactions_score' => $value['Reaction'],
                    'solutions_score' => $value['Solution'],
                    'total_score' => $totalScore
                ]);

                $userExist->save();
            }

            $userIds = array_keys($userTotalCounts);

            $anotherUsersExist = \XF::finder('FS\ThreadScoringSystem:TotalScoringCustom')->where('user_id', '!=', $userIds)->fetch();

            if (count($anotherUsersExist)) {

                foreach ($anotherUsersExist as $value) {

                    $value->delete();
                }
            }
        }

        return $this->complete();
    }

    public function writelevel() {}

    public function getStatusMessage()
    {
        return \XF::phrase('processing_successfully...');
    }

    public function canCancel()
    {
        return false;
    }

    public function canTriggerByChoice()
    {
        return false;
    }
}
