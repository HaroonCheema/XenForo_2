<?php

namespace FS\BulkMailer\Job;

use XF\Job\AbstractJob;

class ProcessMailQueue extends AbstractJob
{
    protected $defaultData = [
        'batch_size' => 100
    ];

    public function run($maxRunTime)
    {
        $mailSender = new \FS\BulkMailer\Service\MailSender(\XF::app());
        
        $mailSender->processQueue();

        return $this->complete();
    }

    public function getStatusMessage()
    {
        return 'Processing mail queue...';
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
