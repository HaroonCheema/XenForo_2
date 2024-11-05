<?php

namespace FS\ThreadScoringSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionIndex(ParameterBag $params)
    {
        $parent =  parent::actionIndex($params);

        $username = $this->filter('username', 'str');

        if (!($params->user_id || $username)) {

            $orderBy = \XF::options()->fs_thread_scoring_list_order;
            $minimumPoints = \XF::options()->fs_total_users_minimum_points;
            $listLimit = \XF::options()->fs_thread_scoring_system_notable_perpage;

            $records = $this->finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('user_id', '!=', 0)->where('total_score', '>=', $minimumPoints)->limitByPage(1, $listLimit)->order('total_score', $orderBy)->fetch();

            if (!count($records)) {
                return $parent;
            }

            // if ($options->fs_thread_scoring_list_format == 'points') {

            // } else {
            //     $data = $allTypePoints->getPercentageSums($records);
            // }

            $parent->setParam('data', $records);
        }

        return $parent;
    }

    public function actionAllUsersPoints()
    {

        $orderBy = \XF::options()->fs_thread_scoring_list_order;
        $minimumPoints = \XF::options()->fs_total_users_minimum_points;

        $records = $this->finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('total_score', '>=', $minimumPoints)->order('total_score', $orderBy)->fetch();

        $viewParams = [
            'data' => count($records) ? $records : [],
        ];

        return $this->view('FS\ThreadScoringSystem:Member\AllUsersPoints', 'fs_thread_scoring_all_score_notable', $viewParams);
    }

    public function actionDirectRunJoblksadjoiwesdjf()
    {
        $db = \XF::db();

        $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        $totalThreads = \XF::finder('XF:Thread')->total();
        $totalThreadsPendings = \XF::finder('XF:Thread')->where('points_collected', false)->total();

        $totalRecordInDb = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->total();

        $totalPosts = \XF::finder('XF:Post')->total();

        $threadsCount = $db->fetchAll('
            SELECT COUNT(*) AS total_count
            FROM xf_thread
            WHERE last_cron_run = 0 OR last_thread_update > last_cron_run          
            ');

        $pendingthreadsCount = $threadsCount['0']['total_count'];

        $threadIds = $db->fetchAllColumn('
                SELECT * FROM xf_thread 
                WHERE last_cron_run = ? 
                OR last_thread_update > last_cron_run 
                ', [
            0,
        ]);

        $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->where('node_id', '!=', $excludeForumIds)->total();


        $allDetails = "\n\nTotal Threads : " . $totalThreads . "\n\nPending Threads For Score (Threads) : " . $totalThreadsPendings . "\n\nExc Threads : " . $threads . "\n\n Total Posts : " . $totalPosts . "\n\n Pending Threads For Scoring (Reply, Words, Reactions) : " . $pendingthreadsCount . "\n\n Total Recods In My Tabel : " . $totalRecordInDb . "\n\n";

        echo "<pre>";
        var_dump($allDetails);
        exit;
    }

    // public function actionDirectRunJob()
    // {

    //     $totalReplyInMy = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('points_type', 'reply')->total();

    //     $options = \XF::options();

    //     $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

    //     $totalPostsCount = \XF::finder('XF:Post')->total();

    //     // $conditions = [
    //     //     ['last_cron_run', 0],
    //     //     ['last_thread_update', '>', 'last_cron_run'],
    //     // ];

    //     // $pendingthreadsCount = \XF::finder('XF:Thread')->where('node_id', '!=', $excludeForumIds)->whereOr($conditions)->total();

    //     $db = \XF::db();

    //     $threadsCount = $db->fetchAll('
    //     SELECT COUNT(*) AS total_count
    //     FROM xf_thread
    //     WHERE last_cron_run = 0 OR last_thread_update > last_cron_run          
    //     ');

    //     $pendingthreadsCount = $threadsCount['0']['total_count'];

    //     echo "<pre>";
    //     var_dump($totalReplyInMy, $totalPostsCount, $pendingthreadsCount);
    //     exit;


    //     if ($pendingthreadsCount) {

    //         $limit = 5;

    //         $threads = \XF::finder('XF:Thread')->where('node_id', '!=', $excludeForumIds)->whereOr($conditions)->limitByPage(1, $limit)->fetch();

    //         if (count($threads)) {
    //             foreach ($threads as $key => $thread) {

    //                 $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
    //                 $postReply->addEditReplyPoints($thread);

    //                 $currentTime = \XF::$time;

    //                 $thread->bulkSet([
    //                     'last_thread_update' => $currentTime,
    //                     'last_cron_run' => $currentTime,
    //                 ]);

    //                 $thread->save();
    //             }
    //         }
    //     }

    //     echo "<pre>";
    //     var_dump($totalReplyInMy, $totalPostsCount, $pendingthreadsCount);
    //     exit;

    //     $limit = 100;

    //     $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

    //     $db = \XF::db();

    //     $threadsCount = $db->fetchAll('
    //     SELECT COUNT(*) AS total_count
    //     FROM xf_thread
    //     WHERE last_cron_run = 0 OR last_thread_update > last_cron_run          
    //     ');


    //     $threadIds = $db->fetchAllColumn('
    //             SELECT * FROM xf_thread 
    //             WHERE last_cron_run = ? 
    //             OR last_thread_update > last_cron_run 
    //             LIMIT ?          
    //             ', [
    //         0,
    //         $limit,
    //     ]);

    //     $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->fetch();


    //     echo "<pre>";
    //     var_dump($threadsCount['0']['total_count'], $threadIds, $threads);
    //     exit;

    //     $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

    //     $pendingThreadsCount = \XF::finder('XF:Thread')
    //         ->where('node_id', '!=', $excludeForumIds)
    //         ->whereOr([
    //             ['last_cron_run', '=', 0],
    //             ['last_thread_update', '>', 'last_cron_run']
    //         ])
    //         ->total();

    //     $threads = \XF::finder('XF:Thread')
    //         ->where('node_id', '!=', $excludeForumIds)
    //         ->whereOr([
    //             ['last_cron_run', '=', 0],
    //             ['last_thread_update', '>', 'last_cron_run']
    //         ])
    //         ->limitByPage(1, 5)
    //         ->fetch();

    //     echo "<pre>";
    //     var_dump($pendingThreadsCount, $threads);
    //     exit;


    //     $totalReplyInMy = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('points_type', 'reply')->total();

    //     $options = \XF::options();

    //     $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

    //     $totalPostsCount = \XF::finder('XF:Post')->total();

    //     $conditions = [
    //         ['last_cron_run', 0],
    //         ['last_thread_update', '>', 'last_cron_run'],
    //     ];

    //     $pendingthreadsCount = \XF::finder('XF:Thread')->where('node_id', '!=', $excludeForumIds)->whereOr($conditions)->total();

    //     if ($pendingthreadsCount) {

    //         $limit = 5;

    //         $threads = \XF::finder('XF:Thread')->where('node_id', '!=', $excludeForumIds)->whereOr($conditions)->limitByPage(1, $limit)->fetch();

    //         if (count($threads)) {
    //             foreach ($threads as $key => $thread) {

    //                 $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
    //                 $postReply->addEditReplyPoints($thread);

    //                 $currentTime = \XF::$time;

    //                 $thread->bulkSet([
    //                     'last_thread_update' => $currentTime,
    //                     'last_cron_run' => $currentTime,
    //                 ]);

    //                 $thread->save();
    //             }
    //         }
    //     }

    //     echo "<pre>";
    //     var_dump($totalReplyInMy, $totalPostsCount, $pendingthreadsCount);
    //     exit;
    // }

    public function actionCustomUsersPoints()
    {

        $orderBy = \XF::options()->fs_thread_scoring_list_order;
        $minimumPoints = \XF::options()->fs_total_users_minimum_points;

        $records = $this->finder('FS\ThreadScoringSystem:TotalScoringCustom')->where('total_score', '>=', $minimumPoints)->order('total_score', $orderBy)->fetch();

        $viewParams = [
            'data' => count($records) ? $records : [],
        ];

        return $this->view('FS\ThreadScoringSystem:Member\CustomUsersPoints', 'fs_thread_scoring_all_score_custom', $viewParams);
    }

    public function actionMyPointsScore(ParameterBag $params)
    {
        $user = $this->assertViewableUser($params->user_id);

        if (!\xf::visitor()->hasPermission('fs_thread_scoring_system', 'can_view')) {
            return $this->noPermission();
        }

        $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $user->user_id)->fetch();

        if (count($records)) {
            $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

            $viewParams = $allTypePoints->getAllTypePointsScores($records);
        } else {
            $viewParams = array();
        }

        return $this->view('FS\ThreadScoringSystem\XF:Member\MyPointsScore', 'fs_thread_scoring_my_score', $viewParams);
    }
}
