<?php

namespace FS\BulkMailer\Job;

use XF\Job\AbstractJob;

class DeleteMailingList extends AbstractJob
{
    protected $defaultData = [
        'mailing_list_id' => null,
        'batch_size' => 1000,
        'position' => 0
    ];

    public function run($maxRunTime)
    {
        $mailingList = \XF::em()->find('FS\BulkMailer:MailingList', $this->data['mailing_list_id']);
        if (!$mailingList) {
            return $this->complete();
        }

        // Delete queue records in batches
        $queueRecords = \XF::db()->delete(
            'xf_fs_mail_queue',
            'mailing_list_id = ? LIMIT ' . $this->data['batch_size'],
            $this->data['mailing_list_id']
        );

        if ($queueRecords == 0) {
            // Delete associated file if exists
            if ($mailingList->file_path) {
                \XF\Util\File::deleteFromAbstractedPath('data://email-lists/' . $mailingList->file_path);
            }

            // Delete the mailing list itself
            $mailingList->delete();
            return $this->complete();
        }

        $this->data['position'] += $this->data['batch_size'];
        return $this->resume();
    }

   public function getStatusMessage()
    {
       return 'Deleting mailing list data...';
    }

    public function canCancel()
    {
        return true;
    }

    public function canTriggerByChoice()
    {
        return true;
    }
}