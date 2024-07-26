<?php

namespace FS\CancelMultipleSubscriptions\Job;

use XF\Job\AbstractJob;

class RemoveUsergroups extends AbstractJob
{
    protected $defaultData = [];

    public function run($maxRunTime)
    {
        $s = microtime(true);
        $app = \xf::app();

        $visitor = \XF::visitor();

        $finder = \XF::finder('FS\CancelMultipleSubscriptions:SubscriptionUserGroups')->where('end_at', '<=', time())->fetch();

        if (count($finder)) {
            foreach ($finder as $value) {
                $user = \xf::app()->em()->find('XF:User', $value['user_id']);

                if ($user['user_id']) {

                    if (in_array($value['user_group_id'], $user['secondary_group_ids'])) {
                        $secondaryGroupIds = array_diff($user['secondary_group_ids'], [$value['user_group_id']]);

                        $secondaryGroupIds = array_values($secondaryGroupIds);

                        $user->fastUpdate('secondary_group_ids', $secondaryGroupIds);
                    }

                    $value->delete();
                }
            }
        }

        return $this->complete();
    }

    public function getStatusMessage()
    {
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
