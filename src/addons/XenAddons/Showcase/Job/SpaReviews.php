<?php

namespace XenAddons\Showcase\Job;

use XF\Job\AbstractJob;

class SpaReviews extends AbstractJob
{
    protected $defaultData = [
        'start' 	=> 0,        // last thread_id processed
        'batch' 	=> 10000,
        'spa_id' 	=> null,
        'phone'		=> null
    ];

    public function run($maxRunTime)
    {
    	if(!$this->data['phone'] || !$this->data['spa_id'])
    		return $this->complete();

        $startTime = microtime(true);

        $forumIds = \XF::db()->fetchAllColumn("
            SELECT node_id
            FROM xf_node
            WHERE node_type_id = 'Forum'
              AND (title LIKE 'Review%' OR title LIKE 'Alert%')
        ");

        $finder = $this->app->finder('XF:Thread')
            ->where('thread_id', '>', $this->data['start'])
            ->where('node_id', $forumIds)
            ->where('spa_id', 0)
            ->order('thread_id')
            ->limit($this->data['batch']);

        $threads = $finder->fetch();

        if (!$threads->count())
            return $this->complete();

        $this->data['phone'] = preg_replace('/\D/', '', $this->data['phone']);

        foreach ($threads as $thread) 
        {
            $this->data['start'] = $thread->thread_id;            

            $firstPost = $thread->FirstPost;

            if ($firstPost && $firstPost->message)
            {
                if (preg_match('/\[B\]Phone\[\/B\]:\s*([^\n\r]+)/i', $firstPost->message, $match)) 
                {
                    $phoneRaw = trim($match[1]);
                    $phoneDigits = preg_replace('/\D/', '', $phoneRaw);

                    if($phoneDigits == $this->data['phone'])
                    {
		                $thread->spa_id = $this->data['spa_id'];

					    if (strpos($firstPost->message, '[B]Recommendation[/B]: No') !== false)
			                $thread->review_type = 'A';
					    else
			                $thread->review_type = 'R';

		                $thread->save();
                    }
                }
            }

            if (microtime(true) - $startTime >= $maxRunTime)
                return $this->resume();
        }

        return $this->resume(); // Continue with next batch
    }

    public function getStatusMessage()
    {
        return 'Job Processing...';
        //return \XF::phrase('processing_threads') . '... (ID: ' . $this->data['start'] . ')';
    }

    public function canCancel()
    {
        return true;
    }

    public function canTriggerByChoice()
    {
        return false;
    }
}