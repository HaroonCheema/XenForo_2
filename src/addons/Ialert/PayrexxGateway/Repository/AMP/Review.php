<?php


namespace Ialert\PayrexxGateway\Repository\AMP;

use AMP\Entity\Review as ReviewEntity;



class Review extends \AMP\Repository\Review
{

    /**
     * Builds up a table of each day, and the number of reviews the user got on that day
     *
     * @param integer userId
     * @return array
     */
    public function getReviewsLedger($userId)
    {
	/* if ($_SERVER['REMOTE_ADDR'] == '173.183.104.132') */ return $this->getReviewsLedgerAlternate($userId);

        $user = \XF::em()->find('XF:User', $userId);
	$joinDate = date('Y-m-d', ($user->register_date - 86400));

        $days = $this->app()->options->reviews_days_awarded;
        return \XF::db()->fetchAll("
            SELECT selected_date
                 , reviews
                 , @total := GREATEST(0, @total - daily_loss + daily_gain) AS balance
                 , @total > 0 AS has_access
              FROM ( SELECT dates.selected_date
                          , COUNT(review.thread_id) AS reviews
                          , 1 AS daily_loss
                          , (COUNT(review.thread_id) * $days + IFNULL((SELECT sum(gain) FROM amp_reviews_balance_upgrade_log as u WHERE u.gain > 0 AND u.user_id = $userId AND u.date = selected_date), 0)) AS daily_gain
                       FROM ( SELECT *
                                FROM ( SELECT adddate('$joinDate', t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date
                                         FROM ( SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                              ( SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                              ( SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                              ( SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                              ( SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) v
                                        WHERE selected_date BETWEEN '$joinDate' AND NOW() ) AS dates
                     LEFT OUTER
                       JOIN amp_review AS review
                         ON dates.selected_date = date(from_unixtime(review.date_approved))
                        AND review.user_id = ?
                        AND review.status = 1
                     GROUP
                         BY dates.selected_date ) AS data
              JOIN ( SELECT @total := 0 ) AS t
            ORDER
                BY selected_date
        ", $userId);
    }

    /**
     * Builds up a table of each day, and the number of reviews the user got on that day
     *
     * @param integer userId
     */
    public function getReviewsLedgerAlternate($userId)
    {
	set_time_limit(0);
        $days = $this->app()->options->reviews_days_awarded;
        $user = \XF::em()->find('XF:User', $userId);
        if (!$user) {
            return array();
        }

        $reviewsByDay = \XF::db()->fetchAll("
            SELECT COUNT(*) as reviews
                 , COUNT(*) * $days AS gain
                 , date(from_unixtime(date_approved)) AS date
              FROM amp_review
             WHERE user_id = ?
              AND status = " . ReviewEntity::STATUS_ACCEPTED . "
            GROUP
               BY date
        ", $user['user_id']);


	$rbd = array_column($reviewsByDay, 'reviews', 'date');

        $gains = array(
            'reviews' => array_column($reviewsByDay, 'gain', 'date'),
            'subscriptions' => $this->fetchPaymentGains($userId),
        );



        $out = $this->combineGainsIntoLedger($user, $gains);
        return array_map(function(&$row) use ($rbd) {
            $row['reviews'] = $rbd[$row['selected_date']] ?? 0;
            return $row;
        }, $out);
    }

    private function fetchPaymentGains($userId)
    {
        return array_column(\XF::db()->fetchAll("
            SELECT date
                 , COALESCE(SUM(gain), 0) AS gain
              FROM amp_reviews_balance_upgrade_log
             WHERE user_id = ?
           GROUP
                BY date
        ", $userId), 'gain', 'date');
    }

    private function combineGainsIntoLedger($user, array $gains)
    {
        $joinDate = \DateTime::createFromFormat('U', $user['register_date']);
        $joinDate->modify('-1 day');
	$joinDate->setTime(0, 0, 0);
	

        $now = new \DateTime();
        $ledger = array();

        for ($total = 0, $date = clone $joinDate; $date <= $now; $date->modify('+1 day')) {
            $day = $date->format('Y-m-d');
            $total = max(0, $total - 1);

            foreach ($gains as $type => $dates) {
                if (!empty($dates[$day])) {
                    $total += $dates[$day];
                }
            }

            $ledger[] = array(
                'selected_date' => $day,
                'balance' => $total,
                'has_access' => $total > 0
            );
        }

        return $ledger;
    }


}
