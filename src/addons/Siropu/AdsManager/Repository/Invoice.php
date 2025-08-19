<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Invoice extends Repository
{
     public function findInvoicesForList()
     {
          return $this->finder('Siropu\AdsManager:Invoice')->order('create_date', 'DESC');
     }
     public function findInvoicesForUser($userId)
     {
          return $this->findInvoicesForList()->forUser($userId);
     }
     public function findInvoicesForAd($adId)
     {
          return $this->findInvoicesForList()->forAd($adId);
     }
     public function deleteAdInvoices($adId)
     {
          $this->db()->delete('xf_siropu_ads_manager_invoice', 'ad_id = ?', $adId);
     }
     public function changeOwner($userId, \XF\Entity\User $user)
     {
          $this->db()->update('xf_siropu_ads_manager_invoice',
               ['user_id' => $user->user_id, 'username' => $user->username],
               'user_id = ?
          ', $userId);
     }
     public function getAdInvoiceCount($adId, $status = null)
     {
          $finder = $this->findInvoicesForAd($adId);

          if ($status)
          {
               $finder->ofStatus($status);
          }

          return $finder->total();
     }
     public function getRevenewPerCurrency()
     {
          return $this->db()->fetchAll('
               SELECT i1.cost_currency, COALESCE((SELECT SUM(cost_amount)
                    FROM xf_siropu_ads_manager_invoice AS i2
                    WHERE i2.status = "completed"
                    AND i2.cost_currency = i1.cost_currency), 0) AS total
               FROM xf_siropu_ads_manager_invoice AS i1
               GROUP BY i1.cost_currency
          ');
     }
     public function getStatistics($currency = 'USD')
     {
          date_default_timezone_set(\XF::options()->guestTimeZone);

          $intervals = [
               'today' => [
                    strtotime('-' . date('G') . ' Hours'),
                    time()
               ],
               'yesterday' => [
                    strtotime('-1 Day 00:00'),
                    strtotime('-1 Day 23:59')
               ],
               'this_week' => [
                    strtotime('This Week Monday'),
                    time()
               ],
               'this_month' => [
                    strtotime('first day of this month 00:00'),
                    time()
               ],
               'last_week' => [
                    strtotime('-1 Week Last Monday'),
                    strtotime('-1 Week Sunday 23:59')
               ],
               'last_month' => [
                    strtotime('first day of last month 00:00'),
                    strtotime('last day of last month 23:59')
               ],
               'all_time' => [
                    strtotime('Jan 1, 1970'),
                    time()
               ]
          ];

          $statistics = [];

          foreach ($intervals as $key => $val)
          {
               $statistics[$key] = $this->db()->fetchOne('
                    SELECT COALESCE(SUM(cost_amount), 0) AS total
                    FROM xf_siropu_ads_manager_invoice
                    WHERE status = "completed"
                    AND cost_currency = ?
                    AND complete_date BETWEEN ? AND ?
               ', [$currency, $val[0], $val[1]]);
          }

          return $statistics;
     }
}
