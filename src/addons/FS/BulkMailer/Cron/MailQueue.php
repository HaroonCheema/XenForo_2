<?php

namespace FS\BulkMailer\Cron;

class MailQueue {

    public static function runMails() {

        $app = \xf::app();

        $jobID = "fs_mail_queue";

        $jobRecord = \xf::db()->fetchOne("
            SELECT job_id
            FROM xf_job
            WHERE unique_key = ?
            LIMIT 1
        ", [$jobID]);
        
      

        if ($jobRecord) {

            return;
        }


        $app->jobManager()->enqueueUnique($jobID, 'FS\BulkMailer:ProcessMailQueue', [
                ], true);

        $app->jobManager()->runUnique($jobID, 120);
    }
}
