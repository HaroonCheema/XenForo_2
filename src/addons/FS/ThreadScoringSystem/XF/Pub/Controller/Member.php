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

        $records = $this->finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('user_id', '!=', 0)->where('total_score', '>=', $minimumPoints)->order('total_score', $orderBy)->fetch();

        $viewParams = [
            'data' => count($records) ? $records : [],
        ];

        return $this->view('FS\ThreadScoringSystem:Member\AllUsersPoints', 'fs_thread_scoring_all_score_notable', $viewParams);
    }

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

    // public function actionTotalPointslskdjflksdjflkjsdflj()
    // {

    //     $totalRecords = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->total();

    //     if ($totalRecords) {

    //         $limit = 100000;

    //         $endLimit = round($totalRecords / $limit) ?: 1;

    //         $records = array();

    //         for ($i = 0; $i < 10; $i++) {

    //             $offset = $i + 1;
    //             $recordsFinder = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->limitByPage($offset, $limit)->fetch();

    //             if (count($recordsFinder)) {
    //                 $records[] = $recordsFinder;
    //             }
    //         }
    //     }

    //     // $app = \XF::app();
    //     // $jobID = "notable_member_total_points" . time();

    //     // $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:NotableMemberTotalPoints', [], true);
    //     // $app->jobManager()->runUnique($jobID, 120);

    //     echo "<pre>";
    //     var_dump(count($records));
    //     exit;

    //     $perPage = 100000;
    //     $records = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->total();

    //     echo "<pre>";
    //     var_dump($records);
    //     exit;
    // }

    // public function actionDirectRunJoblksadjoiwesdjf()
    // {
    //     $db = \XF::db();

    //     $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

    //     $totalThreads = \XF::finder('XF:Thread')->total();
    //     $totalThreadsPendings = \XF::finder('XF:Thread')->where('points_collected', false)->total();

    //     $totalRecordInDb = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->total();

    //     $totalPosts = \XF::finder('XF:Post')->total();

    //     $threadsCount = $db->fetchAll('
    //         SELECT COUNT(*) AS total_count
    //         FROM xf_thread
    //         WHERE last_cron_run = 0 OR last_thread_update > last_cron_run          
    //         ');

    //     $pendingthreadsCount = $threadsCount['0']['total_count'];

    //     $threadIds = $db->fetchAllColumn('
    //             SELECT * FROM xf_thread 
    //             WHERE last_cron_run = ? 
    //             OR last_thread_update > last_cron_run 
    //             ', [
    //         0,
    //     ]);

    //     $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->where('node_id', '!=', $excludeForumIds)->total();


    //     $allDetails = "\n\nTotal Threads : " . $totalThreads . "\n\nPending Threads For Score (Threads) : " . $totalThreadsPendings . "\n\nExc Threads : " . $threads . "\n\n Total Posts : " . $totalPosts . "\n\n Pending Threads For Scoring (Reply, Words, Reactions) : " . $pendingthreadsCount . "\n\n Total Recods In My Tabel : " . $totalRecordInDb . "\n\n";

    //     echo "<pre>";
    //     var_dump($allDetails);
    //     exit;
    // }
}
