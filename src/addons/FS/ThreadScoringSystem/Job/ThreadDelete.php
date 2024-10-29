<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;
use XF\Mvc\Entity\Finder;
use XF\Mvc\ParameterBag;
use XF\Http\Response;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use XF\Mvc\FormAction;
use XF\Mvc\View;

class ThreadDelete extends AbstractJob
{

    public function run($maxRunTime)
    {

        if ($this->data['thread_id']) {

            $exist = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('thread_id', $this->data['thread_id'])->fetch();

            if (count($exist)) {

                foreach ($exist as  $value) {
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
