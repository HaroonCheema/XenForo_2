<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class Ad extends AbstractController
{
     public function actionIndex()
     {
          $page    = $this->filterPage();
          $perPage = $this->options()->siropuAdsManagerAdsPerPage;

          $filter = $this->filter('_xfFilter', [
			'text'   => 'str',
			'prefix' => 'bool'
		]);

          if (strlen($filter['text']))
          {
               $perPage = 300;
          }

          $input = $this->filter([
               'type'            => 'str',
               'username'        => 'str',
               'package_id'      => 'uint',
               'status'          => 'str',
               'ad_status'       => 'array',
               'order_field'     => 'str',
               'order_direction' => 'str'
          ]);

          $fields = ['name', 'display_order', 'create_date', 'view_count', 'click_count', 'ctr'];

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
               $status = $input['ad_status'];

               if (!empty($status))
               {
                    $entities = $this->em()->findByIds('Siropu\AdsManager:Ad', array_keys($status));

                    foreach ($entities as $id => $entity)
                    {
                         $activeState = $status[$id];

                         if ($entity->status == 'active' && $activeState == 0)
                         {
                              $entity->status = 'inactive';
                         }
                         else if ($entity->status != 'active' && $activeState == 1)
                         {
                              $entity->status = 'active';
                         }

                         $entity->saveIfChanged();
                    }
               }

               if ($input['order_field'])
               {
                    $this->app()->response()->setCookie('sam_ad_order_field', $input['order_field']);
               }

               if ($input['order_direction'])
               {
                    $this->app()->response()->setCookie('sam_ad_order_direction', $input['order_direction']);
               }

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          $orderField = $input['order_field'] ?: $this->app()->request()->getCookie('sam_ad_order_field', 'name');
          $orderDir   = $input['order_direction'] ?: $this->app()->request()->getCookie('sam_ad_order_direction', 'ASC');

          $finder = $this->getAdRepo()
               ->findAdsForList()
               ->whereOr([['Extra.is_placeholder', 0], ['Extra.is_placeholder', 2]])
               ->order('package_id')
               ->order($orderField, $orderDir)
               ->limitByPage($page, $perPage);

          if (strlen($filter['text']))
		{
			$finder->where('name', 'LIKE', $finder->escapeLike($filter['text'], $filter['prefix'] ? '?%' : '%?%'));
		}

          $filters = [];

          if ($input['type'])
          {
               $finder->ofType($input['type']);
               $filters['type'] = $input['type'];
          }

          if ($input['status'])
          {
               $finder->ofStatus($input['status']);
               $filters['status'] = $input['status'];
          }
          else
          {
               $finder->notOfStatus('archived');
          }

          if ($input['package_id'])
          {
               $finder->forPackage($input['package_id']);
               $filters['package_id'] = $input['package_id'];
          }

          if ($input['username'])
          {
               $finder->where('username', $input['username']);
               $filters['username'] = $input['username'];
          }

          $ads = $finder->fetch();

          $pendingAds = $this->getAdRepo()
               ->findAdsForList()
               ->ofStatus('pending')
               ->order('create_date', 'ASC')
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\Ad $ad)
               {
                    return ($ad->isPendingApproval());
               });

          $viewParams = [
               'ads'        => $ads->groupBy('package_id'),
               'total'      => $finder->total(),
               'adCount'    => $ads->count(),
               'pendingAds' => $pendingAds,
               'packages'   => $this->getPackageRepo()->findPackagesForAdList(),
               'order'      => [
                    'field'     => $orderField,
                    'direction' => $orderDir
               ],
               'page'       => $page,
               'perPage'    => $perPage,
               'filters'    => $filters
          ];

          return $this->view('Siropu\AdsManager:Ad\List', 'siropu_ads_manager_ad_list', $viewParams);
     }
     public function actionCreate()
     {
          return $this->view('Siropu\AdsManager:Ad\Create', 'siropu_ads_manager_ad_create');
     }
     public function actionAdd()
     {
          $ad = $this->em()->create('Siropu\AdsManager:Ad');
          $ad->type = $this->getType();

          $packageId = $this->filter('package_id', 'uint');

          if ($packageId)
          {
               $ad->package_id = $packageId;
               $ad->inheritPackage();
          }

          if ($ad->isResource() && !$this->em()->find('XF:AddOn', 'XFRM'))
          {
               return $this->error(\XF::phrase('siropu_ads_manager_xfrm_not_installed'));
          }

          return $this->adAddEdit($ad);
     }
     public function actionEdit(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);
          return $this->adAddEdit($ad);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->ad_id)
		{
			$ad = $this->assertAdExists($params->ad_id);
		}
		else
		{
			$ad = $this->em()->create('Siropu\AdsManager:Ad');
		}

		$this->adSaveProcess($ad)->run();

		return $this->redirect($this->getDynamicRedirect());
     }
     public function actionDelete(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          if ($this->isPost())
          {
               if ($ad->Extra->is_placeholder)
               {
                    $ad->Package->disablePlaceholder();
               }
               else
               {
                    $ad->delete();
               }

               if ($this->filter('delete_invoices', 'bool'))
               {
                    $invoices = $ad->Invoices;

                    if ($invoices)
                    {
                         foreach ($invoices as $invoice)
                         {
                              $invoice->delete();
                         }
                    }
               }

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          $viewParams = [
               'ad' => $ad
          ];

          return $this->view('Siropu\AdsManager:Ad\Delete', 'siropu_ads_manager_ad_delete', $viewParams);
     }
     public function actionDetails(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id, 'Extra');

          if ($ad->isPurchase())
          {
               $alertRepo = $this->repository('XF:UserAlert');
               $alertRepo->fastDeleteAlertsToUser(\XF::visitor()->user_id, 'siropu_ads_manager_ad', $ad->ad_id, 'new');
          }

          $blockedIps = $this->finder('Siropu\AdsManager:ClickFraud')
               ->where('ad_id', $ad->ad_id)
               ->where('click_count', '>=', $ad->settings['click_fraud']['click_limit'])
               ->order('log_date', 'DESC');

          $attachments = $this->finder('XF:Attachment')
               ->where('content_type', 'siropu_ads_manager_ad')
               ->where('content_id', $ad->ad_id)
               ->fetch();

          $viewParams = [
               'ad'          => $ad,
               'positions'   => $this->em()->findByIds('Siropu\AdsManager:Position', $ad->position),
               'blockedIps'  => $blockedIps->fetch(),
               'attachments' => $attachments
          ];

          return $this->view('Siropu\AdsManager:Ad\Details', 'siropu_ads_manager_ad_details', $viewParams);
     }
     public function actionClone(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          if ($this->isPost())
          {
               $data = $ad->toArray();

               unset($data['ad_id']);

               $data['view_count']  = 0;
               $data['click_count'] = 0;
               $data['ctr']         = 0;

               $input = $this->filter([
                    'name'            => 'str',
                    'package_id'      => 'uint',
                    'inherit_package' => 'bool',
                    'position'        => 'array',
                    'title'           => 'str',
                    'content_1'       => 'str',
                    'content_2'       => 'str',
                    'content_3'       => 'str',
                    'content_4'       => 'str',
                    'item_array'      => 'array',
                    'banner_url'      => 'array',
                    'target_url'      => 'str',
                    'item_id'         => 'uint',
                    'status'          => 'str'
               ]);

               if (empty($input['name']))
               {
                    $input['name'] = \XF::phrase('siropu_ads_manager_clone_of', ['name' => $ad->name]);
               }

               $data = array_merge($data, $input);

               $clone = $this->em()->create('Siropu\AdsManager:Ad');
               $clone->bulkSet($data);

               $preparer = $this->service('Siropu\AdsManager:Ad\Preparer', $clone, $data);
               $preparer->runValidation();

               if (!$preparer->isValid())
               {
                    return $this->error($preparer->getErrors());
               }

               $preparer->saveFiles();

               if ($ad->start_date && $ad->start_date > \XF::$time)
               {
                    $clone->status = 'inactive';
               }

               $clone->save();

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          $viewParams = [
               'ad'       => $ad,
               'packages' => $this->getPackageRepo()->getTypePackagesForSelect($ad->type)
          ];

          return $this->view('Siropu\AdsManager:Ad\Delete', 'siropu_ads_manager_ad_clone', $viewParams);
     }
     public function actionEmbed(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);
          $plugin = $this->plugin('Siropu\AdsManager:Embed');

          return $plugin->embedUnit($ad);
     }
     public function actionExport(ParameterBag $params)
     {
          if ($this->isPost())
          {
               $finder = $this->finder('Siropu\AdsManager:Ad')->where('ad_id', $params->ad_id);
               return $this->initExport($finder);
          }

          $viewParams = [
               'ad' => $this->assertAdExists($params->ad_id)
          ];

          return $this->view('Siropu\AdsManager:Ad\Export', 'siropu_ads_manager_ad_export', $viewParams);
     }
     public function actionMassExport(ParameterBag $params)
     {
          if ($this->isPost())
          {
               $finder = $this->finder('Siropu\AdsManager:Ad')->where('ad_id', $this->filter('export', 'array-uint'));
               return $this->initExport($finder);
          }

          $finder = $this->getAdRepo()
               ->findAdsForList()
               ->order('type', 'ASC')
               ->order('name', 'ASC');

          $viewParams = [
               'ads'   => $finder->fetch()->groupBy('type'),
               'total' => $finder->total()
          ];

          return $this->view('Siropu\AdsManager:Ad\Export', 'siropu_ads_manager_ad_mass_export', $viewParams);
     }
     public function actionImport()
     {
          if ($this->isPost())
          {
               $upload = $this->app()->request->getFile('upload', false, false);

               if ($upload && $upload->getExtension() == 'zip')
               {
                    return $this->importFromZip($upload);
               }
               else
               {
                    return $this->plugin('XF:Xml')->actionImport(
                         'ads-manager/ads',
                         'ads_manager',
                         'Siropu\AdsManager:Package\Import'
                    );
               }
          }

          return $this->view('Siropu\AdsManager:Ad\Import', 'siropu_ads_manager_import', ['route' => 'ads']);
     }
     public function actionGeneralStats(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          $viewParams = [
               'ad' => $ad
          ];

          return $this->view('Siropu\AdsManager:Ad\GeneralStats', 'siropu_ads_manager_ad_general_stats', $viewParams);
     }
     public function actionDailyStats(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          $plugin = $this->plugin('Siropu\AdsManager:DailyStats');
          return $plugin->getDailyStatsForAd($ad);
     }
     public function actionClickStats(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          $plugin = $this->plugin('Siropu\AdsManager:ClickStats');
          return $plugin->getClickStatsForAd($ad);
     }
     public function actionResetStats(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          $plugin = $this->plugin('Siropu\AdsManager:ResetStats');
          return $plugin->resetAdStats($ad, $this->filter('type', 'str'));
     }
     public function actionApprove(ParameterBag $params)
     {
          $this->assertPostOnly();

          $ad     = $this->assertAdExists($params->ad_id);
          $isFree = $ad->isFree();

          if ($ad->isPending())
          {
               $approver = $this->service('Siropu\AdsManager:Ad\Approver', $ad);
               $approver->verifyEmptySlots($error);

               if ($ad->Extra->prev_status)
               {
                    $ad->status = $ad->Extra->prev_status;

                    if ($ad->end_date && $ad->Extra->prev_status == 'active')
                    {
                         $ad->updateEndDate();
                    }

                    $ad->save();

                    $alertRepo = $this->repository('XF:UserAlert');

                    foreach (\XF::finder('XF:User')->where('is_admin', 1)->fetch() as $admin)
                    {
                         $alertRepo->markUserAlertsReadForContent(
                              'siropu_ads_manager_ad',
                              $ad->ad_id,
                              'reapprove',
                              $admin,
                              $ad->Extra->last_active ?: $ad->Extra->last_change
                         );
                    }
               }
               else if ($approver->getEmptySlots())
               {
                    if ($isFree)
                    {
                         $ad->activate();
                    }
                    else
                    {
                         $ad->approve();
                    }
               }
               else if ($isFree)
               {
                    $ad->queue();
               }
               else
               {
                    $ad->queueAndInvoice();
               }

               if (!$isFree)
               {
                    $notifier = $this->service('Siropu\AdsManager:Ad\Notifier', $ad, 'approved');
                    $notifier->sendNotification();
               }
          }

          return $this->redirect($this->buildLink('ads-manager/ads'));
     }
     public function actionReject(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          if ($this->isPost())
          {
               $ad->status = 'rejected';
               $ad->updateExtraData(['reject_reason' => $this->filter('reject_reason', 'str')]);
               $ad->save();

               $notifier = $this->service('Siropu\AdsManager:Ad\Notifier', $ad, 'rejected');
               $notifier->sendNotification();

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          $viewParams = [
               'ad' => $ad
          ];

          return $this->view('Siropu\AdsManager:Ad\Reject', 'siropu_ads_manager_ad_reject', $viewParams);
     }
     public function actionMessage(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);

          $type    = $this->filter('type', 'str');
          $subject = $this->filter('subject', 'str');
          $message = $this->filter('message', 'str');

          if ($this->isPost())
          {
               $notifier = $this->service('Siropu\AdsManager:Ad\Notifier', $ad, 'message');

               if (!$message)
               {
                    return $this->message(\XF::phrase('siropu_ads_manager_message_required'));
               }

               switch ($type)
               {
                    case 'alert':
                         $notifier->setReceiveAlert(true);
                         $notifier->setAlertExtraData(['message' => $message]);
                         break;
                    case 'email':
                         if (!$subject)
                         {
                              return $this->message(\XF::phrase('siropu_ads_manager_subject_required'));
                         }
                         $notifier->setReceiveEmail(true);
                         $notifier->setEmailParams(['subject' => $subject, 'message' => $message]);
                         break;
               }

               if ($notifier->sendNotification())
               {
                    return $this->redirect(
                         $this->buildLink('ads-manager/ads/details', $ad),
                         \XF::phrase('siropu_ads_manager_message_sent')
                    );
               }
          }

          $viewParams = [
               'ad'   => $ad,
               'type' => $type ?: 'alert'
          ];

          return $this->view('Siropu\AdsManager:Ad\Message', 'siropu_ads_manager_ad_message', $viewParams);
     }
     public function actionDeblockIp(ParameterBag $params)
     {
          $ad     = $this->assertAdExists($params->ad_id);
          $ip     = $this->filter('ip', 'str');
          $return = $this->filter('return', 'str');

          if ($this->isPost())
          {
               $clickFraudRepo = $this->repository('Siropu\AdsManager:ClickFraud');
               $clickFraudRepo->deleteIp($ad->ad_id, $clickFraudRepo->getBinaryIp($ip));

               switch ($return)
               {
                    case 'monitor':
                         return $this->redirect($this->buildLink('ads-manager/tools/click-fraud-monitor'));
                         break;
                    default:
                         return $this->redirect($this->buildLink('ads-manager/ads/details', $ad));
                         break;
               }
          }

          $viewParams = [
               'ad'     => $ad,
               'ip'     => $ip,
               'return' => $return
          ];

          return $this->view('Siropu\AdsManager:Ad\DeblockIp', 'siropu_ads_manager_ad_deblock_ip', $viewParams);
     }
     public function actionDeleteFile(ParameterBag $params)
     {
          $ad = $this->assertAdExists($params->ad_id);
          $ad->deleteFile($this->filter('file', 'str'));
          $ad->save();

          $reply = $this->view('Siropu\AdsManager:Ad\DeleteFile');
          $reply->setJsonParams(['deleted' => true]);

          return $reply;
     }
     public function actionTopPerforming()
     {
          $page     = $this->filterPage();
          $perPage  = 20;

          $finder = $this->getAdRepo()
               ->findAdsForList()
               ->notOfType(['sticky', 'resource'])
               ->setDefaultOrder('ctr', 'DESC')
               ->limitByPage($page, $perPage);

          $status = $this->filter('status', 'str');

          if ($status)
          {
               $finder->ofStatus($status);
          }

          $orderField = $this->filter('order_field', 'str');
          $orderDir   = $this->filter('order_direction', 'str');

          if ($orderField)
          {
               $finder->order($orderField, $orderDir);
          }

          $viewParams = [
               'ads'     => $finder->fetch(),
               'total'   => $finder->total(),
               'page'    => $page,
               'perPage' => $perPage,
               'status'  => $status,
               'order'   => [
                    'field'     => $orderField,
                    'direction' => $orderDir
               ]
          ];

          return $this->view('Siropu\AdsManager:Ad\TopPerforming', 'siropu_ads_manager_ad_top_performing', $viewParams);
     }
     public function actionCallback()
     {
          return $this->view('Siropu\AdsManager:Ad\Callback', 'siropu_ads_manager_ad_callback');
     }
     public function actionDeleteAll()
     {
          if ($this->isPost())
          {
               $ads = $this->getAdRepo()
                    ->findAdsForList()
                    ->where('Extra.is_placeholder', 0)
                    ->fetch();

               foreach ($ads as $ad)
               {
                    $invoices = $ad->Invoices;

                    $ad->delete();

                    if ($invoices && $this->filter('delete_invoices', 'bool'))
                    {
                         foreach ($invoices as $invoice)
                         {
                              $invoice->delete();
                         }
                    }

               }

               return $this->redirect($this->buildLink('ads-manager/ads'));
          }

          return $this->view('Siropu\AdsManager:Ad\DeleteAll', 'siropu_ads_manager_ad_delete_all');
     }
     public function actionGetAffiliateLinkFormPhrase()
     {
          $ad = $this->em()->create('Siropu\AdsManager:Ad');
          $ad->content_2 = $this->filter('type', 'str');

          $reply = $this->view('Siropu\AdsManager:AffiliateLink');
          $reply->setJsonParams($ad->getAffiliateLinkFormPhrase());
          return $reply;
     }
     protected function adAddEdit(\Siropu\AdsManager\Entity\Ad $ad)
	{
          $hours = [];

		for ($i = 0; $i < 24; $i++)
		{
			$hh = str_pad($i, 2, '0', STR_PAD_LEFT);
			$hours[$hh] = $hh;
		}

		$minutes = [];

		for ($i = 0; $i < 60; $i++)
		{
			$mm = str_pad($i, 2, '0', STR_PAD_LEFT);
			$minutes[$mm] = $mm;
		}

          $startDate = new \DateTime();
          $startDate->setTimezone(new \DateTimeZone(\XF::options()->guestTimeZone));
          $startDate->setTimestamp($ad->start_date);

          $endDate = new \DateTime();
          $endDate->setTimezone(new \DateTimeZone(\XF::options()->guestTimeZone));
          $endDate->setTimestamp($ad->end_date);

          $viewParams = [
               'ad'               => $ad,
               'packages'         => $this->getPackageRepo()->getTypePackagesForSelect($ad->type),
               'positionCriteria' => $this->app->criteria('Siropu\AdsManager:Position', $ad->position_criteria),
               'userCriteria'     => $this->app->criteria('XF:User', $ad->user_criteria),
               'pageCriteria'     => $this->app->criteria('XF:Page', $ad->page_criteria),
               'deviceCriteria'   => $this->app->criteria('Siropu\AdsManager:Device', $ad->device_criteria),
               'geoCriteria'      => $this->app->criteria('Siropu\AdsManager:Geo', $ad->geo_criteria),
               'hours'            => $hours,
               'minutes'          => $minutes,
               'startHour'        => $startDate->format('H'),
               'endHour'          => $endDate->format('H')
          ];

          if ($ad->isThread() && $ad->isInsert())
          {
               $attachmentRepo = $this->repository('XF:Attachment');
               $attachmentData = $attachmentRepo->getEditorData('siropu_ads_manager_ad', $ad);
               $attachmentData['context']['node_id'] = 0;
               $viewParams['attachmentData'] = $attachmentData;
          }

          return $this->view('Siropu\AdsManager:Ad\Edit', 'siropu_ads_manager_ad_edit', $viewParams);
     }
     protected function adSaveProcess(\Siropu\AdsManager\Entity\Ad $ad)
	{
          $input = $this->filter([
               'package_id'        => 'uint',
               'inherit_package'   => 'bool',
               'name'              => 'str',
               'position'          => 'array',
               'content_1'         => 'str',
               'content_2'         => 'str',
               'content_3'         => 'str',
               'content_4'         => 'str',
               'item_array'        => 'array',
               'banner_url'        => 'array',
               'title'             => 'str',
               'target_url'        => 'str',
               'item_id'           => 'uint',
               'start_date'        => 'str',
               'end_date'          => 'str',
               'view_limit'        => 'uint',
               'view_count'        => 'uint',
               'click_limit'       => 'uint',
               'click_count'       => 'uint',
               'settings'          => 'array',
               'position_criteria' => 'array',
               'user_criteria'     => 'array',
               'page_criteria'     => 'array',
               'device_criteria'   => 'array',
               'geo_criteria'      => 'array',
               'display_order'     => 'uint',
               'display_priority'  => 'uint',
               'status'            => 'str'
          ]);

          $ad->package_id = $input['package_id'];

          if ($ad->isInsert())
          {
               $ad->type = $this->getType();
          }

          if ($ad->isThread())
          {
               $input['content_3'] = $this->plugin('XF:Editor')->convertToBbCode($this->filter('content_html', 'str,no-clean'));

               unset($input['item_id']);
          }

          if ($ad->isAffiliate() && $input['content_2'] == 'params')
          {
               $arr    = $this->filter('params', 'array');
               $params = array_filter(array_combine(array_map(function($n) { return rtrim($n, '='); }, $arr['name']), $arr['value']));

               if (!empty($params))
               {
                    $input['content_4'] = json_encode($params);
               }
          }

          $startHour   = $this->filter('start_date_hour', 'str');
          $startMinute = $this->filter('start_date_minute', 'str');

          if ($startDate = $input['start_date'])
          {
               $date = new \DateTime($startDate, new \DateTimeZone(\XF::options()->guestTimeZone));
               $date->setTime($startHour, $startMinute);

               $input['start_date'] = $date->format('U');
          }

          $endHour   = $this->filter('end_date_hour', 'str');
          $endMinute = $this->filter('end_date_minute', 'str');

          if ($endDate = $input['end_date'])
          {
               $date = new \DateTime($endDate, new \DateTimeZone(\XF::options()->guestTimeZone));
               $date->setTime($endHour, $endMinute);
               $input['end_date'] = $date->format('U');
          }

          $form = $this->formAction();
          $form->basicEntitySave($ad, $input);

          $preparer = $this->service('Siropu\AdsManager:Ad\Preparer', $ad, $input);
          $preparer->runValidation();

          $template = $ad->getMasterTemplate();

          $form->validate(function(FormAction $form) use ($ad, $template, $preparer, $input)
          {
               $content = $ad->applyLinkAttributes($input['content_1'] ?: $input['content_2']);

               if (!$preparer->isValid())
               {
                    $form->logErrors($preparer->getErrors());
                    $preparer->deleteFiles();
               }
               else if ($ad->canUseXfSyntax() && $ad->hasXfSyntax($content))
               {
                    if ($ad->isPopup())
                    {
                         $content = json_encode(nl2br($content));
                    }

                    if (!$template->set('template', $content))
     			{
     				$form->logErrors($template->getErrors());
     			}
               }
          });

          $form->setup(function() use ($ad, $preparer)
          {
               if ($ad->start_date && $ad->start_date > \XF::$time)
               {
                    $ad->status = 'inactive';
               }

               if ($this->filter('inherit_package', 'bool'))
               {
                    $ad->inheritPackage($ad->Extra && $ad->Extra->purchase != 0);
               }

               $preparer->saveFiles();
          });

          $form->setup(function(FormAction $form) use ($ad)
          {
               $extraData = [
                    'count_exclude'   => $this->filter('count_exclude', 'bool'),
                    'advertiser_list' => $this->filter('advertiser_list', 'bool'),
                    'is_sticky'       => $this->filter('sticky', 'bool'),
                    'prefix_id'       => $this->filter('prefix_id', 'uint'),
                    'custom_fields'   => $this->filter('custom_fields', 'array')
               ];

               $ad->updateExtraData($extraData);

               if ($ad->isThread())
               {
                    $extra = $this->em()->create('Siropu\AdsManager:AdExtra');
                    $extra->bulkSet($extraData);
                    $extra->hydrateRelation('Ad', $ad);

                    if (!$extra->validatePromoThread($errors))
                    {
                         $form->logErrors($errors);
                    }
               }
          });

          $form->apply(function() use ($template)
		{
			if ($template->template)
			{
				$template->saveIfChanged();
			}
		});

          $form->complete(function() use ($ad)
          {
               if (!$ad->Extra)
               {
                    $ad->hydrateExtraRelation();
                    $toggler = \XF::service('Siropu\AdsManager:Ad\Toggler', $ad, $ad->item_id);

                    if ($ad->isSticky())
                    {
                         $toggler->toggleSticky($ad->isActive());
                    }
                    else if ($ad->isResource())
                    {
                         $toggler->toggleFeatured($ad->isActive());
                    }
               }

               if ($ad->canUseXfSyntax() && !$ad->hasXfSyntax($ad->content_1 ?: $ad->content_2) && $ad->MasterTemplate)
               {
                    $ad->MasterTemplate->delete();
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
}
