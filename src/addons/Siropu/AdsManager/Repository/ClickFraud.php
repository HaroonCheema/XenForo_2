<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class ClickFraud extends Repository
{
     public function logClick($adId, $pageUrl)
     {
          $values = [
               'ad_id'       => $adId,
               'ip'          => $this->getBinaryIp(),
               'page_url'    => $pageUrl . " \n ",
               'log_date'    => \XF::$time,
               'click_count' => 1
          ];

          $this->db()->query("
               INSERT INTO xf_siropu_ads_manager_click_fraud
                    (ad_id, ip, page_url, log_date, click_count)
               VALUES
                    (?, ?, ?, ?, ?)
               ON DUPLICATE KEY UPDATE
                    click_count = click_count + 1,
                    page_url = CONCAT(page_url, " . $this->db()->quote($values['page_url']) . ")
          ", $values);
     }
     public function getClickCount($adId, $ip = null)
     {
          if ($ip === null)
          {
               $ip = $this->getBinaryIp();
          }

          return $this->db()->fetchOne('
               SELECT click_count
               FROM xf_siropu_ads_manager_click_fraud
               WHERE ad_id = ?
               AND ip = ?
          ', [$adId, $ip]);
     }
     public function deleteIp($adId, $ip)
     {
          $this->db()->delete('xf_siropu_ads_manager_click_fraud', 'ad_id = ? AND ip = ?', [$adId, $ip]);
     }
     public function blockIp($adId, $blockTime)
     {
          $this->db()->update('xf_siropu_ads_manager_click_fraud', ['ip_blocked' => $blockTime], 'ad_id = ?', $adId);
     }
     public function deleteOlderEntries()
     {
          $daysOld = \XF::options()->siropuAdsManagerClickFraudDeleteDaysOld;

          if ($daysOld)
          {
               $this->db()->delete('xf_siropu_ads_manager_click_fraud', 'log_date <= ?', \XF::$time - $daysOld * 86400);
          }
     }
     public function deleteAdEntries($adId)
     {
          $this->db()->delete('xf_siropu_ads_manager_click_fraud', 'ad_id IN (' . $this->db()->quote($adId) . ')');
     }
     public function getBinaryIp($ip = null)
     {
          return \XF\Util\Ip::convertIpStringToBinary($ip ?: \XF::app()->request()->getIp());
     }
     public function isIpBlocked($ip)
     {
          return $this->db()->fetchOne('
               SELECT *
               FROM xf_siropu_ads_manager_click_fraud
               WHERE ip = ?
               AND ip_blocked > ?', [$ip, \XF::$time]);
     }
}
