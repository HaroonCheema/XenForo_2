<?php

namespace FS\ExcludeReactionScore\Job;

use XF\Job\AbstractJob;
use XF\Mvc\Entity\Finder;
use XF\Mvc\ParameterBag;
use XF\Http\Response;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use XF\Mvc\FormAction;
use XF\Mvc\View;

class Reaction extends AbstractJob
{

    public function run($maxRunTime)
    {

        if ($this->data['node_id']) {

            $app = \xf::app();


            $threadFinder = $app->finder('XF:Thread')->where('node_id', $this->data['node_id']);

            $threadIds = $threadFinder->pluckfrom('thread_id')->fetch()->toArray();


            if (count($threadIds)) {

                $postFinder = $app->finder('XF:Post')->where('thread_id', $threadIds);

                $postIds = $postFinder->pluckfrom('post_id')->fetch()->toArray();


                if (count($postIds)) {

                    $postIdsStr = implode(",", $postIds);

                    $setVal = $this->data['count_reactions'];


                    $db = \xf::db();

                    $db->update(
                        'xf_reaction_content',
                        ['is_counted' => $setVal],
                        "content_id IN ({$postIdsStr})"
                    );

                    $app->jobManager()->enqueueUnique('reactionChange' . time(), 'XF:ReactionScore');
                }
            }

            return $this->complete();
        }

        return $this->complete();
    }

    public function writelevel()
    {
    }

    public function getStatusMessage()
    {
        return \XF::phrase('processing_export_acess_log...');
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
