<?php

namespace ThemeHouse\Monetize\Job;

use XF\Job\AbstractJob;

/**
 * Class AbstractCommunication
 * @package ThemeHouse\Monetize\Job
 */
class SendCommunication extends AbstractJob
{
    /**
     * @var array
     */
    protected $defaultData = [
        'steps' => 0,
        'start' => 0,
        'batch' => 100,
        'communication_id' => null
    ];

    /**
     * @return mixed
     */
    protected function getTypePhrase()
    {
        return \XF::phrase('thmonetize_communcations');
    }

    /**
     * @return null|\XF\Mvc\Entity\Entity
     */
    protected function getContent()
    {
        if (empty($this->data['communication_id'])) {
            return null;
        }

        return \XF::em()->find('ThemeHouse\Monetize:Communication', intval($this->data['communication_id']));
    }

    /**
     * @param int $maxRunTime
     * @return \XF\Job\JobResult
     * @throws \XF\PrintableException
     */
    public function run($maxRunTime)
    {
        if (!$this->data['communication_id']) {
            return $this->complete();
        }

        $content = $this->getContent();
        if (!$content) {
            return $this->complete();
        }

        $startTime = microtime(true);

        $this->data['steps']++;
        $ids = $this->getNextBatch();
        if (!$ids) {
            return $this->complete();
        }

        /** @var \XF\Finder\User $userFinder */
        $userFinder = $this->app->finder('XF:User');
        $userFinder->where('user_id', $ids)
            ->with(['Profile', 'Option'])
            ->order('user_id');

        $users = $userFinder->fetch();

        $done = 0;

        /** @var \XF\Repository\UserUpgrade $userUpgradeRepo */
        $userUpgradeRepo = $this->app->repository('XF:UserUpgrade');
        $userUpgrades = $userUpgradeRepo->findUserUpgradesForList()->fetch();

        foreach ($users as $user) {
            $this->data['start'] = $user->user_id;

            $this->processContent($content, $user, $userUpgrades);

            $done++;

            if (microtime(true) - $startTime >= $maxRunTime) {
                break;
            }
        }

        $this->data['batch'] = $this->calculateOptimalBatch($this->data['batch'], $done, $startTime, $maxRunTime, 1000);

        return $this->resume();
    }

    /**
     * @return array
     */
    protected function getNextBatch()
    {
        $cutoff = \XF::options()->thmonetize_messageActiveCutoff * 86400;
        if ($cutoff) {
            $cutoff = \XF::$time - $cutoff;
        }

        $validityString = '';
        if (\XF::options()->thmonetize_messageActiveOnly) {
            $validityString .= "AND user_state = 'valid'";
        }

        $db = $this->app->db();
        return $db->fetchAllColumn($db->limit(
            "
				SELECT user_id
				FROM xf_user
				WHERE user_id > ?
				  AND last_activity >= ?
				  {$validityString}
				ORDER BY user_id
			",
            $this->data['batch']
        ), [$this->data['start'], $cutoff]);
    }

    /**
     * @param $content
     * @param $user
     * @param $userUpgrades
     * @throws \XF\PrintableException
     */
    protected function processContent($content, $user, $userUpgrades)
    {
        /** @var \ThemeHouse\Monetize\Entity\Communication $content */
        $content->sendForUser($user, $userUpgrades);
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        $actionPhrase = \XF::phrase('thmonetize_sending');
        $typePhrase = $this->getTypePhrase();
        return sprintf('%s... %s (%s)', $actionPhrase, $typePhrase, $this->data['start']);
    }

    /**
     * @return bool
     */
    public function canCancel()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function canTriggerByChoice()
    {
        return true;
    }
}