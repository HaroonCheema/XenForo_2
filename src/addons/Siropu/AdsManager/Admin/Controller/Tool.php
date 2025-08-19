<?php

namespace Siropu\AdsManager\Admin\Controller;

class Tool extends AbstractController
{
     public function actionIndex()
     {
          return $this->view();
     }
     public function actionChangeAdOwner()
     {
          $input = $this->filter([
               'user_id'      => 'uint',
               'ad_id'        => 'array-uint',
               'username'     => 'str',
               'invoices'     => 'bool',
               'add_to_group' => 'bool',
               'complete'     => 'bool'
          ]);

          $viewParams = [
               'users' => $this->getAdRepo()->getUserPairs(),
               'input' => $input
          ];

          $errors = [];

          if ($this->isPost())
          {
               $currentOwner = $this->assertUserExists($input['user_id']);

               $currentOwnerAds = $this->getAdRepo()
                    ->findAdsForList()
                    ->forUser($currentOwner->user_id)
                    ->where('Extra.is_placeholder', 0)
                    ->order('name', 'ASC')
                    ->fetch();

               $viewParams['ads'] = $currentOwnerAds->pluckNamed('name', 'ad_id');

               if ($input['complete'])
               {
                    if (empty($input['ad_id']))
                    {
                         $errors[] = \XF::phrase('siropu_ads_manager_no_ads_selected');
                    }

                    if (!$newOwner = $this->em()->findOne('XF:User', ['username' => $input['username']]))
                    {
                         $errors[] = \XF::phrase('siropu_ads_manager_new_owner_not_valid');
                    }

                    if (empty($errors))
                    {
                         if ($currentOwner->user_id != $newOwner->user_id)
                         {
                              $this->getAdRepo()->changeOwner($input['ad_id'], $newOwner);

                              if ($input['invoices'])
                              {
                                   $this->getInvoiceRepo()->changeOwner($input['user_id'], $newOwner);
                              }

                              if ($input['add_to_group'])
                              {
                                   $ad = $this->em()->find('Siropu\AdsManager:Ad', $input['ad_id']);

                                   $userGroups = \XF::options()->siropuAdsManagerAdvertiserUserGroups;

                                   if ($ad->Package && $ad->Package->advertiser_user_groups)
                                   {
                                        $userGroups = $ad->Package->advertiser_user_groups;
                                   }

                                   if ($userGroups)
                                   {
                                        $userGroupChange = $this->service('XF:User\UserGroupChange');
                              		$userGroupChange->addUserGroupChange($newOwner->user_id, 'samAdvertiser', $userGroups);
                                   }
                              }
                         }

                         $viewParams['success'] = true;
                    }
                    else
                    {
                         $viewParams['errors'] = $errors;
                    }
               }
          }

          return $this->view('Siropu\AdsManager:Tool\ChangeAdOwner', 'siropu_ads_manager_tool_change_ad_owner', $viewParams);
     }
     public function actionStatsAccess()
     {
          return $this->rerouteController('Siropu\AdsManager:StatsAccess', 'index');
     }
     public function actionClickFraudMonitor()
     {
          $page        = $this->filterPage();
          $perPage     = 20;

          $linkFilters = [];

          $finder = $this->finder('Siropu\AdsManager:ClickFraud')
               ->order('log_date', 'DESC')
               ->limitByPage($page, $perPage);

          if ($adId = $this->filter('ad_id', 'uint'))
          {
               $finder->where('ad_id', $adId);
               $linkFilters['ad_id'] = $adId;
          }

          if ($ip = $this->filter('ip', 'str'))
          {
               $finder->where('ip', \XF\Util\Ip::convertIpStringToBinary($ip));
               $linkFilters['ip'] = $ip;
          }

          $viewParams = [
               'entries'     => $finder->fetch(),
               'total'       => $finder->total(),
               'page'        => $page,
               'perPage'     => $perPage,
               'linkFilters' => $linkFilters
          ];

          return $this->view('Siropu\AdsManager:Tool\ClickFraudMonitor', 'siropu_ads_manager_click_fraud_monitor', $viewParams);
     }
     public function actionMassExtend()
     {
          if ($this->isPost())
          {
               $adIds      = $this->filter('ads', 'array-uint');
               $packageIds = $this->filter('packages', 'array-uint');

               if (empty($packageIds) && empty($adIds))
               {
                    return $this->message(\XF::phrase('siropu_ads_manager_no_ads_or_packages_selected'));
               }

               $ads = $this->em()->findByIds('Siropu\AdsManager:Ad', $adIds);

               foreach ($ads as $ad)
               {
                    $this->extendAd($ad);
               }

               $packages = $this->em()->findByIds('Siropu\AdsManager:Package', $packageIds);

               foreach ($packages as $package)
               {
                    foreach ($package->Ads as $ad)
                    {
                         $this->extendAd($ad);
                    }
               }

               return $this->redirect($this->buildLink('ads-manager/tools/mass-extend'));
          }

          $adsFinder = $this->finder('Siropu\AdsManager:Ad')->active();
          $packagesFinder = $this->finder('Siropu\AdsManager:Package');

          $viewParams = [
               'ads'      => $adsFinder->fetch()->pluckNamed('name', 'ad_id'),
               'packages' => $packagesFinder->fetch()->pluckNamed('title', 'package_id')
          ];

          return $this->view('Siropu\AdsManager:Tool\MassExtend', 'siropu_ads_manager_tool_mass_extend', $viewParams);
     }
     protected function extendAd(\Siropu\AdsManager\Entity\Ad $ad)
     {
          $extendTime   = $this->filter('extend_time', 'uint');
          $extendLength = $this->filter('extend_length', 'str');
          $views        = $this->filter('views', 'uint');
          $clicks       = $this->filter('clicks', 'uint');

          if ($ad->view_limit)
          {
               $ad->view_limit += $views;
          }
          if ($ad->click_limit)
          {
               $ad->click_limit += $clicks;
          }
          if ($ad->end_date)
          {
               $dateTime = new \DateTime("@{$ad->end_date}", new \DateTimeZone(\XF::options()->guestTimeZone));
               $dateTime->modify("+{$extendTime} {$extendLength}");
               $ad->end_date = $dateTime->format('U');
          }
          $ad->saveIfChanged();
     }
}
