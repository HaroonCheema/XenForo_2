<?php


namespace JUM\ConnectedAccounts\Job;

use XF\Job\AbstractRebuildJob;

class ConnectedAccountsRebuild extends AbstractRebuildJob
{
    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn($db->limit(
            "
				SELECT user_id
				FROM xf_user
				WHERE user_id > ?
				ORDER BY user_id
			", $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        /** @var \XF\Entity\User $user */
        $user = $this->app->em()->find('XF:User', $id, ['Profile']);
        if (!$user)
        {
            return;
        }

        $db = $this->app->db();

        $db->beginTransaction();

        $user->save(true, false);

        $user->Profile->repository('XF:ConnectedAccount')->rebuildUserConnectedAccountCache($user);

        $db->commit();
    }

    protected function getStatusType()
    {
        return \XF::phrase('users');
    }

    public function canCancel()
    {
        return false;
    }

    public function canTriggerByChoice()
    {
        return true;
    }
}