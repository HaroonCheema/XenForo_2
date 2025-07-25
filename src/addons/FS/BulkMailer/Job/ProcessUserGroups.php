<?php

namespace FS\BulkMailer\Job;

use XF\Job\AbstractJob;

class ProcessUserGroups extends AbstractJob {

    protected $defaultData = [
        'mailing_list_id' => 0,
        'position' => 0
    ];

    public function run($maxRunTime) {

         $currentTime = \xf::$time;
          
        $mailingList = $this->app->finder('FS\BulkMailer:MailingList')
                ->where('mailing_list_id', $this->data['mailing_list_id'])
                ->fetchOne();

        if (!$mailingList || !$mailingList->usergroup_ids) {
            return $this->complete();
        }



        $db = \xf::app()->db();
        $usergroups = array_map('intval', $mailingList->usergroup_ids);

        $conditions = [];
        foreach ($usergroups as $groupId) {
            $conditions[] = "FIND_IN_SET($groupId, secondary_group_ids)";
        }


        $sql = "SELECT user_id, email 
        FROM xf_user 
        WHERE email != '' 
        AND (
            user_group_id IN (" . implode(',', $usergroups) . ")
            OR " . implode(' OR ', $conditions) . "
        )
        LIMIT " . $this->data['position'] . ", 1000";

        $users = $db->fetchPairs($sql);

       
        foreach ($users as $userId => $email) {
            $db->insert('xf_fs_mail_queue', [
                'mailing_list_id' => $mailingList->mailing_list_id,
                'user_id' => $userId,
                'email' => $email,
                'status' => 'pending'
            ]);
        }

        if (count($users)) {
            
            $mailingList->total_emails = $db->fetchOne(
                    'SELECT COUNT(*) FROM xf_fs_mail_queue WHERE mailing_list_id = ?',
                    [$mailingList->mailing_list_id]
            );
            $mailingList->process_status=0;
            $mailingList->next_run= $currentTime + 1200;
            $mailingList->save();
            return $this->complete();
        }

       
        return $this->complete();
    }

    public function getStatusMessage() {
        
    }

    public function canCancel() {
        return true;
    }

    public function canTriggerByChoice() {
        return true;
    }
}
