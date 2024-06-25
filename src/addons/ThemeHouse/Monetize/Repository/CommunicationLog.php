<?php

namespace ThemeHouse\Monetize\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class CommunicationLog extends Repository
{
    /**
     * @return Finder
     */
    public function findLogsForList()
    {
        $finder = $this->finder('ThemeHouse\Monetize:CommunicationLog')
            ->with('User', true)->with('Communication', true)
            ->setDefaultOrder('log_date', 'DESC');

        return $finder;
    }

    /**
     * @return array
     */
    public function getUsersInLog()
    {
        return $this->db()->fetchPairs("
			SELECT user.user_id, user.username
			FROM (
				SELECT DISTINCT user_id FROM xf_th_monetize_communication_log
			) AS log
			INNER JOIN xf_user AS user ON (log.user_id = user.user_id)
			ORDER BY user.username
		");
    }

    /**
     * @param $type
     * @param null $cutOff
     * @return bool
     * @throws \XF\Db\Exception
     */
    public function pruneLogs($type, $cutOff = null)
    {
        if ($cutOff === null) {
            $key = 'thmonetize_' . $type . 'LogLength';
            $logLength = $this->options()->{$key};
            if (!$logLength) {
                return 0;
            }

            $cutOff = \XF::$time - 86400 * $logLength;
        }

        return (bool) $this->db()->query('
            DELETE
              log
            FROM
              xf_th_monetize_communication_log AS log
            LEFT JOIN
              xf_th_monetize_communication AS comm USING(communication_id)
            WHERE
              comm.type = ?
              AND log.log_date < ? 
        ', [$type, $cutOff]);
    }
}