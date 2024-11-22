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

            $records = $this->finder('XF:User')->where('total_score', '>=', $minimumPoints)->limitByPage(1, $listLimit)->order('total_score', $orderBy)->fetch();

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
        if (!\xf::visitor()->hasPermission('fs_thread_scoring_system', 'can_view')) {
            return $this->noPermission();
        }

        $orderBy = \XF::options()->fs_thread_scoring_list_order;
        $minimumPoints = \XF::options()->fs_total_users_minimum_points;

        $records = $this->finder('XF:User')->where('total_score', '>=', $minimumPoints)->order('total_score', $orderBy)->fetch();

        $viewParams = [
            'data' => count($records) ? $records : [],
        ];

        return $this->view('FS\ThreadScoringSystem:Member\AllUsersPoints', 'fs_thread_scoring_all_score_notable', $viewParams);
    }

    public function actionCustomUsersPoints()
    {

        if (!\xf::visitor()->hasPermission('fs_thread_scoring_system', 'can_view')) {
            return $this->noPermission();
        }

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

        $viewParams = [
            'user' => $user,
        ];

        return $this->view('FS\ThreadScoringSystem\XF:Member\MyPointsScore', 'fs_thread_scoring_my_score', $viewParams);
    }

    public function actionTotalPointslskdjflksdjflkjsdflj()
    {
        $totalRecords = \XF::finder('XF:Thread')->where('points_collected', false)->total();

        if ($totalRecords) {

            $limit = 100;

            // $endLimit = round($totalRecords / $limit) ?: 1;
            $endLimit = 10;

            for ($i = 0; $i < $endLimit; $i++) {

                $threads = \XF::finder('XF:Thread')->where('points_collected', false)->limitByPage(1, $limit)->fetch();

                if (!$threads->count()) {

                    break;
                }

                foreach ($threads as $key => $thread) {

                    $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
                    $postReply->addEditReplyPoints($thread);

                    $currentTime = \XF::$time;

                    $thread->bulkSet([
                        'last_thread_update' => $currentTime,
                        'last_cron_run' => $currentTime,
                    ]);

                    $thread->save();
                }
            }
        }

        echo "<pre>";
        var_dump($totalRecords);
        exit;
    }

    public function actionDirectRunJoblksadjoiwesdjf()
    {
        $db = \XF::db();

        $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        $totalThreads = \XF::finder('XF:Thread')->total();
        $totalThreadsPendings = \XF::finder('XF:Thread')->where('points_collected', false)->total();

        $totalRecordInDb = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->total();

        // $totalPosts = \XF::finder('XF:Post')->total();
        $totalPosts = 0;

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

        // $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->where('node_id', '!=', $excludeForumIds)->total();
        $threads = 0;

        $allDetails = "\n\nTotal Threads : " . $totalThreads . "\n\nPending Threads For Score (Threads) : " . $totalThreadsPendings . "\n\nExc Threads : " . $threads . "\n\n Total Posts : " . $totalPosts . "\n\n Pending Threads For Scoring (Reply, Words, Reactions) : " . $pendingthreadsCount . "\n\n Total Recods In My Tabel : " . $totalRecordInDb . "\n\n";

        echo "<pre>";
        var_dump($allDetails);
        exit;
    }
}
