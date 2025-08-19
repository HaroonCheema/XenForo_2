<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class Ad extends AbstractController
{
     public function actionIndex(ParameterBag $params)
     {
          $visitor = \XF::visitor();

          if (!($this->isLoggedIn() && $visitor->canCreateAdsSiropuAdsManager()))
          {
               return $this->noPermission();
          }

          $input = $this->filter([
               'order_field'     => 'str',
               'order_direction' => 'str'
          ]);

          $fields = ['name', 'view_count', 'click_count', 'ctr'];

          if (!in_array($input['order_field'], $fields))
          {
               $input['order_field'] = '';
          }

          if (!in_array($input['order_direction'], ['asc', 'desc']))
          {
               $input['order_direction'] = '';
          }

          if ($this->isPost())
          {
               if ($input['order_field'])
               {
                    $this->app()->response()->setCookie('sam_ad_order_field', $input['order_field']);
               }

               if ($input['order_direction'])
               {
                    $this->app()->response()->setCookie('sam_ad_order_direction', $input['order_direction']);
               }
          }

          $orderField = $input['order_field'] ?: $this->app()->request()->getCookie('sam_ad_order_field', 'name');
          $orderDir   = $input['order_direction'] ?: $this->app()->request()->getCookie('sam_ad_order_direction', 'ASC');

          $ads = $this->getAdRepo()
               ->findAdsForList()
               ->isPurchase()
               ->forUser($visitor->user_id)
               ->order($orderField, $orderDir)
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\Ad $ad)
               {
                    return ($ad->Package);
               });

          $viewParams = [
               'ads'   => $ads,
               'total' => $ads->count(),
               'order' => [
                    'field'     => $orderField,
                    'direction' => $orderDir
               ]
          ];

          $view = $this->view('Siropu\AdsManager:Ad\List', 'siropu_ads_manager_ad_list', $viewParams);
          return $this->addWrapperParams($view, 'ads');
     }
     public function actionAdd(ParameterBag $params)
     {
          if (!$params->Package)
          {
               return $this->noPermission();
          }

          $ad = $this->em()->create('Siropu\AdsManager:Ad');
          $ad->type = $params->Package->type;
          $ad->package_id = $params->Package->package_id;
          $ad->status = '';

          return $this->adAddEdit($ad);
     }
     public function actionEdit(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id, 'Extra');
          return $this->adAddEdit($ad);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();
          $package = $this->assertAdvertiserPackage($this->filter('package_id', 'uint'));

          if ($params->ad_id)
          {
               $ad = $this->assertAdExistsAndValid($params->ad_id);
          }
          else
          {
               $ad = $this->em()->create('Siropu\AdsManager:Ad');
               $ad->status = 'pending';
          }

          $ad->type = $package->type;
          $ad->package_id = $package->package_id;
          $ad->inheritPackage(true);
          $ad->setOption('admin_edit', false);

          $this->adSaveProcess($ad)->run();

          if (!$params->ad_id && $ad->isOfStatus(['approved', 'queued_invoice']))
          {
               $invoice = $this->service('Siropu\AdsManager:Invoice\Manager', $ad);
               $invoice->setGenerateAlert(false);
               $invoice->generate();

               return $this->redirect($this->buildLink('ads-manager/invoices/pay', $invoice->getInvoice()));
          }

          return $this->redirect($this->buildLink('ads-manager/ads'));
     }
     public function actionExtend(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id, 'Extra');

          if (!$ad->canExtend())
          {
               return $this->noPermission();
          }

          $approver = $this->service('Siropu\AdsManager:Ad\Approver', $ad);
          $approver->verifyEmptySlots($error1);

          if ($ad->Package->isPurchaseLimitReached())
          {
               return $this->message(\XF::phrase('siropu_ads_manager_advertiser_ad_limit_reached', [
                    'limit' => $ad->Package->advertiser_purchase_limit
               ]));
          }

          if ($this->isPost())
          {
               $purchase     = $this->filter('purchase', 'uint');
               $exclusiveUse = $this->filter('exclusive_use', 'bool');
               $isSticky     = $this->filter('sticky', 'bool');
               $promoCode    = $this->filter('promo_code', 'str');

               $extraData = [
                    'purchase'        => $purchase,
                    'exclusive_use'   => $exclusiveUse,
                    'is_sticky'       => $isSticky,
                    'promo_code'      => $promoCode,
                    'pending_changes' => [
                         'exclusive_use' => [
                              'new_value' => $exclusiveUse,
                              'old_value' => $ad->Extra->exclusive_use
                         ],
                         'is_sticky' => [
                              'new_value' => $isSticky,
                              'old_value' => $ad->Extra->is_sticky
                         ]
                    ]
               ];

               if ($ad->isKeyword())
               {
                    $approver->verifyExclusiveKeywords($error2);

                    if ($error2)
                    {
                         return $this->message($error2);
                    }
               }

               if ($ad->isThread())
               {
                    if (!$ad->isActive())
                    {
                         $approver->setNodeId($ad->content_1);
                         $approver->verifyPromoThreadUserForumLimit($error3);

                         if ($error3)
                         {
                              return $this->message($error3);
                         }
                    }

                    if ($isSticky)
                    {
                         $approver->verifyEmptyPromoThreadStickySlots($error4);

                         if ($error4)
                         {
                              return $this->message($error4);
                         }
                    }
               }

               $phrase = '';

               if (!$approver->getEmptySlots())
               {
                    $ad->status = 'queued_invoice';

                    $phrase = \XF::phrase('siropu_ads_manager_ad_added_to_queue');
               }

               $ad->updateExtraData($extraData);
               $ad->save();

               if ($ad->isFree())
               {
                    $ad->updateExtraData(['pending_changes' => []]);
                    $ad->activate();

                    return $this->redirect($this->buildLink('ads-manager/ads'));
               }
               else
               {
                    return $this->redirect($this->buildLink('ads-manager/invoices/pay', $ad->generateInvoice()), $phrase);
               }
          }

          $viewParams = [
               'ad'               => $ad,
               'emptySlots'       => $approver->getEmptySlots(),
               'usablePromoCodes' => $this->getUsablePromoCodes()
          ];

          return $this->view('Siropu\AdsManager:Ad\Extend', 'siropu_ads_manager_ad_extend', $viewParams);
     }
     public function actionUnsubscribe(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id, 'Extra');

          if ($ad->Extra->hasEmailNotification())
          {
               $ad->Extra->email_notification = 0;
               $ad->Extra->save();
          }

          return $this->message(\XF::phrase('siropu_ads_manager_you_have_disabled_email_notifications_for_ad_x', [
               'name' => $ad->name,
               'edit' => $this->buildLink('ads-manager/ads/edit', $ad)
          ]));
     }
     public function actionDelete(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id);

          if (!$ad->canDelete())
          {
               return $this->noPermission();
          }

          if ($this->isPost())
          {
               $ad->delete();

               if ($ad->isPending())
               {
                    $this->service('Siropu\AdsManager:Ad\Notifier', $ad, 'delete')->sendAdminNotifications();
               }

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          $viewParams = [
               'ad' => $ad
          ];

          return $this->view('Siropu\AdsManager:Ad\Delete', 'siropu_ads_manager_ad_delete', $viewParams);
     }
     public function actionPause(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id);

          if (!$ad->canPause())
          {
               return $this->noPermission();
          }

          if ($ad->isPaused())
          {
               return $this->message(\XF::phrase('siropu_ads_manager_ad_is_already_paused'));
          }

          if ($this->isPost())
          {
               $length = $this->filter('length', 'uint');
               $limit  = \XF::visitor()->canPauseAdsSiropuAdsManager();

               if ($limit > 0 && $length > $limit)
               {
                    $length = $limit;
               }

               $dateTime = new \DateTime('now', new \DateTimeZone(\XF::options()->guestTimeZone));
               $dateTime->modify("+$length hours");

               $ad->start_date = $dateTime->format('U');
               $ad->status = 'paused';
               $ad->save();

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          $viewParams = [
               'ad' => $ad
          ];

          return $this->view('Siropu\AdsManager:Ad\Pause', 'siropu_ads_manager_ad_pause', $viewParams);
     }
     public function actionUnpause(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id);

          if (!$ad->isPaused())
          {
               return $this->message(\XF::phrase('siropu_ads_manager_ad_is_not_paused'));
          }

          if ($this->isPost())
          {
               $ad->start_date = 0;
               $ad->updateEndDate();
               $ad->status = 'active';
               $ad->save();

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          $viewParams = [
               'ad' => $ad
          ];

          return $this->view('Siropu\AdsManager:Ad\Unpause', 'siropu_ads_manager_ad_unpause', $viewParams);
     }
     public function actionGetBackup(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          if (!$ad->hasBackup())
          {
               return $this->view();
          }

          $jsonParams = [
               'backup' => $ad->content_3
          ];

          $reply = $this->view('Siropu\AdsManager:Ad\Backup');
          $reply->setJsonParams($jsonParams);

          return $reply;
     }
     public function actionTrackView(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          if ($ad->settings['count_views'])
          {
               if (\XF::options()->siropuAdsManagerViewCountCondition)
               {
                    $statsTracker = $this->service('Siropu\AdsManager:Stats\Tracker', $ad);

                    if ($statsTracker->isViewed())
                    {
                         return $this->view();
                    }

                    $statsTracker->trackView();
               }

               $ad->countView();
               $ad->save();
          }

          if ($ad->settings['daily_stats'])
          {
               $this->getDailyStatsRepo()->logAction($ad, 'view');
          }

          $jsonParams = [
               'viewed' => true
          ];

          if ($ad->settings['ga_stats'])
          {
               $jsonParams['ga'] = [
                    'name'     => $ad->name,
                    'type'     => $ad->getTypePhrase()->render(),
                    'position' => $this->getPositionTitle()
               ];
          }

          $reply = $this->view('Siropu\AdsManager:XRobots');
          $reply->setJsonParams($jsonParams);

          return $reply;
     }
     public function actionTrackClick(ParameterBag $params)
     {
          $this->assertPostOnly();
          $ad = $this->assertAdExists($params->ad_id);

          if ($ad->settings['count_clicks'])
          {
               if (\XF::options()->siropuAdsManagerClickCountCondition)
               {
                    $statsTracker = $this->service('Siropu\AdsManager:Stats\Tracker', $ad);

                    if ($statsTracker->isClicked())
                    {
                         return $this->view();
                    }

                    $statsTracker->trackClick();
               }

               $ad->countClick();
               $ad->save();
          }

          if ($ad->settings['daily_stats'])
          {
               $this->getDailyStatsRepo()->logAction($ad, 'click');
          }

          if ($ad->settings['click_stats'])
          {
               $clickStats = $this->em()->create('Siropu\AdsManager:ClickStats');
               $clickStats->ad_id = $ad->ad_id;
               $clickStats->position_id = $this->filter('position_id', 'str');
               $clickStats->image_url = $this->filter('image_url', 'str');
               $clickStats->page_url = $this->filter('page_url', 'str');
               $clickStats->visitor = $this->getClickStatsRepo()->getVisitorData();
               $clickStats->save();
          }

          $jsonParams = [
               'clicked' => true
          ];

          if ($ad->settings['ga_stats'])
          {
               $jsonParams['ga'] = [
                    'name'     => $ad->name,
                    'type'     => $ad->getTypePhrase()->render(),
                    'position' => $this->getPositionTitle()
               ];
          }

          $reply = $this->view('Siropu\AdsManager:Ad\TrackClick');
          $reply->setJsonParams($jsonParams);

          return $reply;
     }
     public function actionMonitorClick(ParameterBag $params)
     {
          $this->assertPostOnly();
          $ad = $this->assertAdExists($params->ad_id);

          $jsonParams = [];

          if ($ad->isClickFraudEnabled())
          {
               $clickFraudRepo = $this->repository('Siropu\AdsManager:ClickFraud');
               $clickFraudRepo->logClick($ad->ad_id, $this->filter('page_url', 'str'));

               $clickFraud = $ad->settings['click_fraud'];

               if ($clickFraudRepo->getClickCount($ad->ad_id) >= $clickFraud['click_limit'])
               {
                    $jsonParams['blocked'] = true;

                    $blockTime = $clickFraud['block_time'];

                    if ($blockTime && $this->options()->siropuAdsManagerClickFraudGlobalBlock)
                    {
                         $clickFraudRepo->blockIp($ad->ad_id, \XF::$time + $blockTime * 3600);
                    }
               }
          }

          $reply = $this->view('Siropu\AdsManager:Ad\MonitorClick');
          $reply->setJsonParams($jsonParams);

          return $reply;
     }
     public function actionLoad(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          if (!$ad->getSetting('lazyload'))
          {
               return $this->view();
          }

          if ($ad->isCode() || $ad->isBanner() && $ad->content_2)
          {
               $html = $ad->getCode($this->filter('position_id', 'str'));
          }
          else
          {
               $html = '<a ' . $ad->getLinkAttributes() . '><img src="' . $ad->getBanner() . '" alt="' . $ad->forAttr($ad->content_4) . '"' . $ad->getWidthHeight() . '></a>';
          }

          $reply = $this->view('Siropu\AdsManager:XRobots');
          $reply->setJsonParam('ad', $html);

          return $reply;
     }
     public function actionDailyStats(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id);

          if  (!\XF::visitor()->canViewDailyStatsSiropuAdsManager())
          {
               return $this->view();
          }

          $plugin = $this->plugin('Siropu\AdsManager:DailyStats');
          return $this->addWrapperParams($plugin->getDailyStatsForAd($ad, false), 'ads');
     }
     public function actionClickStats(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id);

          if  (!\XF::visitor()->canViewClickStatsSiropuAdsManager())
          {
               return $this->view();
          }

          $plugin = $this->plugin('Siropu\AdsManager:ClickStats');
          return $this->addWrapperParams($plugin->getClickStatsForAd($ad), 'ads');
     }
     public function actionTrackImpressions()
     {
          $impressions = array_filter($this->filter('impressions', 'array'), function($item)
          {
               return (count($item) == 2 && is_numeric($item[0]) && preg_match('/[\w]+/', $item[1]));
          });

          $adList = [];

          foreach ($impressions as $data)
          {
               $adList[$data[0]][] = $data[1];
          }

          $statsDate  = $this->getDailyStatsRepo()->getStatsDate();
          $dailyStats = [];
          $gaStats    = [];

          foreach ($this->finder('Siropu\AdsManager:Ad')->where('ad_id', array_keys($adList)) as $ad)
          {
               if (\XF::options()->siropuAdsManagerViewCountCondition)
               {
                    $statsTracker = $this->service('Siropu\AdsManager:Stats\Tracker', $ad);

                    if ($statsTracker->isViewed())
                    {
                         continue;
                    }

                    $statsTracker->trackView();
               }

               $positions = $adList[$ad->ad_id];

               foreach ($positions as $positionId)
               {
                    $ad->countView();

                    if ($ad->settings['daily_stats'])
                    {
                         $dailyStats[] = [
                              'stats_date'  => $statsDate,
                              'ad_id'       => $ad->ad_id,
                              'position_id' => $positionId,
                              'view_count'  => 1,
                              'click_count' => 0
                         ];
                    }

                    if ($ad->settings['ga_stats'])
                    {
                         $gaStats[] = [
                              'name'     => $ad->name,
                              'type'     => $ad->getTypePhrase()->render(),
                              'position' => $this->getPositionTitle($positionId)
                         ];
                    }
               }

               $ad->save();
          }

          if ($dailyStats)
          {
               $this->getDailyStatsRepo()->insertBulk($dailyStats);
          }

          $reply = $this->view('Siropu\AdsManager:XRobots');

          if ($gaStats)
          {
               $reply->setJsonParams(['ga' => $gaStats]);
          }

          return $reply;
     }
     public function actionImage(ParameterBag $params)
     {
          $ad = $this->em()->find('Siropu\AdsManager:Ad', $params->ad_id);
          return $this->view('Siropu\AdsManager:Image', null, ['ad' => $ad]);
     }
     public function actionClick(ParameterBag $params)
     {
          $ad = $this->em()->find('Siropu\AdsManager:Ad', $params->ad_id);
          return $this->view('Siropu\AdsManager:Click', null, ['ad' => $ad]);
     }
     public function actionDeleteFile(ParameterBag $params)
     {
          $ad = $this->assertAdExistsAndValid($params->ad_id);
          $ad->deleteFile($this->filter('file', 'str'));
          $ad->save();

          $reply = $this->view('Siropu\AdsManager:Ad\DeleteFile');
          $reply->setJsonParams(['deleted' => true]);

          return $reply;
     }
     protected function adAddEdit(\Siropu\AdsManager\Entity\Ad $ad)
	{
          $viewParams = [
               'ad'               => $ad,
               'extra'            => $ad->Extra,
               'promoCode'        => $ad->isUpdate() ? $ad->Extra->PromoCode : null,
               'package'          => $ad->Package,
               'deviceCriteria'   => $this->app->criteria('Siropu\AdsManager:Device', $ad->device_criteria),
               'geoCriteria'      => $this->app->criteria('Siropu\AdsManager:Geo', $ad->geo_criteria),
               'usablePromoCodes' => $this->getUsablePromoCodes()
          ];

          $options = \XF::options();
          $visitor = \XF::visitor();

          if ($ad->isOfStatus(['', 'pending', 'rejected']))
          {
               if ($ad->isOfType(['thread', 'sticky']))
               {
                    $forumIds = $ad->isThread()
                         ? $options->siropuAdsManagerPromoThreadForums
                         : $options->siropuAdsManagerAllowedStickyForums;

                    if ($forumIds)
                    {
                         $forums = $this->finder('XF:Node')
                              ->where('node_id', $forumIds)
                              ->order('title', 'ASC')
                              ->fetch();

                         $viewParams['forums'] = $forums;
                    }

                    if ($ad->isThread() && $visitor->canUploadAttachmentsSiropuAdsManager())
                    {
                         $attachmentRepo = $this->repository('XF:Attachment');
                         $attachmentData = $attachmentRepo->getEditorData('siropu_ads_manager_ad', $ad);
                         $attachmentData['context']['node_id'] = $ad->content_1 ?: 0;

                         $viewParams['attachmentData'] = $attachmentData;
                    }
               }
               else if ($ad->isResource() && ($categoryIds = $options->siropuAdsManagerAllowedFeaturedResourceCategories))
               {
                    $categories = $this->finder('XFRM:Category')
                         ->where('resource_category_id', $categoryIds)
                         ->order('title', 'ASC')
                         ->fetch();

                    $viewParams['categories'] = $categories;
               }
          }

          $pendingAdCount = $this->finder('Siropu\AdsManager:Ad')
               ->pending()
               ->where('Extra.prev_status', '')
               ->total();

          if ($pendingAdCount)
          {
               $viewParams['pendingAdCount'] = $pendingAdCount;
          }

          $view = $this->view('Siropu\AdsManager:Ad\Edit', 'siropu_ads_manager_ad_edit', $viewParams);
          return $this->addWrapperParams($view, 'ads');
     }
     protected function adSaveProcess(\Siropu\AdsManager\Entity\Ad $ad)
	{
          $input = $this->filter([
               'name'        => 'str',
               'content_1'   => 'str',
               'content_2'   => 'str',
               'content_4'   => 'str',
               'banner_url'  => 'array',
               'title'       => 'str',
               'target_url'  => 'str',
               'item_id'     => 'uint'
          ]);

          $extraData = [
               'purchase'           => $this->filter('purchase', 'uint'),
               'exclusive_use'      => $this->filter('exclusive_use', 'bool'),
               'is_sticky'          => $this->filter('sticky', 'bool'),
               'prefix_id'          => $this->filter('prefix_id', 'uint'),
               'custom_fields'      => $this->filter('custom_fields', 'array'),
               'promo_code'         => $this->filter('promo_code', 'str'),
               'alert_notification' => $this->filter('alert_notification', 'bool'),
               'email_notification' => $this->filter('email_notification', 'bool'),
               'notes'              => $this->filter('notes', 'str')
          ];

          if (strlen($input['content_4']) > 50)
          {
               $input['content_4'] = substr($input['content_4'], 0, 50);
          }

          if ($ad->isUpdate())
          {
               if ($ad->isKeyword() && !$ad->canEditKeywords())
               {
                    unset($input['content_1']);
               }

               unset($input['item_id']);
          }

          if ($ad->canUseDeviceCriteria())
          {
               $input['device_criteria'] = $this->filter('device_criteria', 'array');
          }

          if ($ad->canUseGeoCriteria())
          {
               $input['geo_criteria'] = $this->filter('geo_criteria', 'array');
          }

          if ($ad->isThread())
          {
               if ($ad->canEditPromoThread())
               {
                    $input['content_3'] = $this->plugin('XF:Editor')->convertToBbCode($this->filter('content_html', 'str,no-clean'));
               }
               else
               {
                    unset($input['content_1'], $input['content_2'], $input['content_3']);

                    $extraData = [];
               }
          }

          if ($ad->isPopup())
          {
               $input['content_1'] = strip_tags($input['content_1'], '<br><p><span><b><i><em><a><ul><ol><li>');

               unset($input['content_2'], $input['target_url']);
          }

          $form = $this->formAction();
          $form->basicEntitySave($ad, $input);

          $preparer = $this->service('Siropu\AdsManager:Ad\Preparer', $ad, $input, false);
          $preparer->runValidation();

          $form->validate(function(FormAction $form) use ($ad, $preparer, $extraData)
          {
               if (!$preparer->isValid())
               {
                    $form->logErrors($preparer->getErrors());
                    $preparer->deleteFiles();
               }
          });

          $form->setup(function(FormAction $form) use ($ad, $preparer, $extraData)
          {
               $preparer->saveFiles();

               $canBypassApproval = false;

               if ($ad->Package->getSetting('no_approval'))
               {
                    $canBypassApproval = true;
               }

               if ($ad->isUpdate()
                    && $ad->isChanged(['content_1', 'content_2', 'content_3', 'content_4', 'banner_file', 'banner_url', 'target_url'])
                    && $ad->isOfStatus(['active', 'approved', 'queued', 'queued_invoice', 'paused'])
                    && !($canBypassApproval || \XF::visitor()->canEditWithoutApprovalSiropuAdsManager()))
               {
                    $ad->status = 'pending';
               }

               if ($ad->canEditPromoThread())
               {
                    $extra = $this->em()->create('Siropu\AdsManager:AdExtra');
                    $extra->bulkSet($extraData);
                    $extra->hydrateRelation('Ad', $ad);

                    if (!$extra->validatePromoThread($errors))
                    {
                         $form->logErrors($errors);
                    }
               }

               $canBypassApproval = $canBypassApproval ?: \XF::visitor()->canBypassApprovalSiropuAdsManager();

               if ($ad->isInsert() && $canBypassApproval)
               {
                    $approver = $this->service('Siropu\AdsManager:Ad\Approver', $ad);
                    $approver->verifyEmptySlots($error);

                    if ($approver->getEmptySlots())
                    {
                         $ad->status = 'approved';
                    }
                    else if ($ad->isFree())
                    {
                         $ad->status = 'queued';
                    }
                    else
                    {
                         $ad->status = 'queued_invoice';
                    }
               }
          });

          $form->setup(function() use ($ad, $extraData)
          {
               $ad->updateExtraData($extraData);
          });

          $isInsert = $ad->isInsert();

          $form->complete(function() use ($ad, $isInsert)
          {
               $canBypassApproval = \XF::visitor()->canBypassApprovalSiropuAdsManager();

               if ($ad->Package->getSetting('no_approval'))
               {
                    $canBypassApproval = true;
               }

               if (!$ad->Extra)
               {
                    $ad->hydrateExtraRelation('PromoCode');

                    if ($ad->isFree() && !$ad->isQueued() && $canBypassApproval)
                    {
                         $ad->activate();
                    }
               }

               if (!$canBypassApproval
                    && $ad->isPending()
                    && ($isInsert || $ad->Extra->isOfPrevStatus(['active', 'approved', 'queued', 'queued_invoice', 'paused'])))
               {
                    if ($ad->Extra->prev_status)
                    {
                         $action = 'reapprove';
                    }
                    else
                    {
                         $action = 'new';
                    }

                    $this->service('Siropu\AdsManager:Ad\Notifier', $ad, $action)->sendAdminNotifications();
               }

               $attachmentHash = $this->filter('attachment_hash', 'str');

               if ($ad->isThread() && $attachmentHash)
               {
                    $inserter = $this->service('XF:Attachment\Preparer');
          		$associated = $inserter->associateAttachmentsWithContent(
                         $attachmentHash,
                         'siropu_ads_manager_ad',
                         $ad->ad_id
                    );
               }
          });

		return $form;
     }
     protected function getPositionTitle($positionId = null)
     {
          $position = $this->getPositionRepo()->getDynamicPosition($positionId ?: $this->filter('position_id', 'str'));

          if ($position)
          {
               return $position->title;
          }
          else
          {
               return \XF::phrase('n_a')->render();
          }
     }
     protected function assertAdExistsAndValid($id, $with = null)
     {
          $ad = $this->assertAdExists($id, $with);

          if (!$ad->canEdit())
          {
               throw $this->exception($this->noPermission());
          }

          return $ad;
     }
     protected function getUsablePromoCodes()
     {
          return $this->getPromoCodeRepo()
               ->findPromoCodesForList()
               ->enabled()
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\PromoCode $promoCode)
               {
                    return ($promoCode->canApply());
               });
     }
}
