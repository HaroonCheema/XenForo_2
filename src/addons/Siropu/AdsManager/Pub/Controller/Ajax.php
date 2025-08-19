<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\ParameterBag;

class Ajax extends AbstractController
{
     public function actionVerifyExclusiveKeywords()
     {
          $this->assertPostOnly();

          $keywords = $this->filter('keywords', 'str');
          $adId     = $this->filter('ad_id', 'uint');

          if (empty($keywords))
          {
               return;
          }

          $approver = $this->service('Siropu\AdsManager:Ad\Approver');
          if ($adId && ($ad = $this->em()->find('Siropu\AdsManager:Ad', $adId)))
          {
               $approver->setAd($ad);
          }
          $approver->setKeywords($keywords);
          $approver->verifyExclusiveKeywords($error);

          if ($error)
          {
               return $this->message($error);
          }

          $reply = $this->view('Siropu\AdsManager:Ajax\VerifyExclusiveKeywords');
          $reply->setJsonParams(['ok' => true]);

          return $reply;
     }
     public function actionGetForumThreadOptions()
     {
          $options    = \XF::options();
          $visitor    = \XF::visitor();
          $forumId    = $this->filter('forum_id', 'uint');
          $packageId  = $this->filter('package_id', 'uint');
          $jsonParams = [];

          $approver = $this->service('Siropu\AdsManager:Ad\Approver');
          $approver->setNodeId($forumId);
          $approver->setPackageId($packageId);
          $approver->verifyPromoThreadForumLimit($error1);

          if ($error1)
          {
               $jsonParams['noSlotsError'] = $error1;
          }

          $approver->verifyPromoThreadUserForumLimit($error2);

          if ($error2)
          {
               return $this->message($error2);
          }

          $promoThreadForums  = $options->siropuAdsManagerPromoThreadForums;
          $stickyThreadPrefix = $options->siropuAdsManagerStickyThreadPrefix;

          $reply = $this->view('Siropu\AdsManager:Ajax\GetForumPrefixList');

          if (!in_array($forumId, $promoThreadForums))
          {
               return;
          }

          $forum = $this->em()->find('XF:Forum', $forumId);

          if ($forum)
          {
               if ($options->siropuAdsManagerEnableCustomThreadPrefix)
               {
                    $prefixList = [];

                    foreach ($forum->getPrefixes() as $prefix)
                    {
                         if ($stickyThreadPrefix == $prefix->prefix_id)
                         {
                              continue;
                         }

                         $prefixList[$prefix->prefix_id] = $prefix->title;
                    }

                    if (count($prefixList))
                    {
                         $prefixList[0] = \XF::phrase('(none)');
                    }

                    $jsonParams['prefixList'] = $prefixList;
               }

               if ($options->siropuAdsManagerEnableCustomThreadFields)
               {
                    $thread    = $this->em()->create('XF:Thread');
                    $templater = $this->app->templater();

                    $templater->addDefaultParam('xf', \XF::app()->getGlobalTemplateData());

                    $customFields = $templater->renderMacro('public:custom_fields_macros', 'custom_fields_edit', [
                         'type'        => 'threads',
                         'set'         => $thread->custom_fields,
                         'onlyInclude' => $forum->field_cache
                    ]);

                    $jsonParams['customFields'] = $customFields;
               }

               $reply->setJsonParams($jsonParams);
               return $reply;
          }
     }
     public function actionVerifyEmptyPromoThreadStickySlots()
     {
          $approver = $this->service('Siropu\AdsManager:Ad\Approver');
          $approver->setNodeId($this->filter('forum_id', 'uint'));
          $approver->verifyEmptyPromoThreadStickySlots($error);

          if ($error)
          {
               return $this->message($error);
          }

          return $this->view();
     }
     public function actionGetUserThreads()
     {
          $this->assertPostOnly();

          $itemId     = $this->filter('item_id', 'uint');
          $userId     = \XF::visitor()->user_id;
          $jsonParams = [];

          $userStickies = $this->finder('Siropu\AdsManager:Ad')
               ->ofType('sticky')
               ->forUser($userId)
               ->fetch()
               ->pluckNamed('item_id');

          $threads = $this->finder('XF:Thread')
               ->where('node_id', $itemId)
               ->where('user_id', $userId)
               ->where('thread_id', '<>', $userStickies)
               ->where('discussion_state', 'visible')
               ->where('discussion_type', '<>', 'redirect')
               ->where('sticky', 0)
               ->order('last_post_date', 'DESC')
               ->fetch();

          if (!$threads->count())
          {
               return $this->message(\XF::phrase('siropu_ads_manager_no_threads_found'));
          }

          $approver = $this->service('Siropu\AdsManager:Ad\Approver');
          $approver->setNodeId($itemId);
          $approver->verifyEmptyStickySlots($error);

          if ($error)
          {
               $jsonParams['noSlotsError'] = $error;
          }

          $options = '';

          foreach ($threads as $thread)
          {
               $options .= '<option value="' . $thread->thread_id  . '">' . $thread->title . '</option>';
          }

          $reply = $this->view('Siropu\AdsManager:Ajax\GetUserThreads');
          $reply->setJsonParams($jsonParams + ['options' => $options]);

          return $reply;
     }
     public function actionGetUserResources()
     {
          $this->assertPostOnly();

          $packageId  = $this->filter('package_id', 'uint');
          $itemId     = $this->filter('item_id', 'uint');
          $userId     = \XF::visitor()->user_id;
          $jsonParams = [];

          $userFeatured = $this->finder('Siropu\AdsManager:Ad')
               ->ofType('resource')
               ->forUser($userId)
               ->fetch()
               ->pluckNamed('item_id');

          $resources = $this->finder('XFRM:ResourceItem')
               ->where('resource_category_id', $itemId)
               ->where('user_id', $userId)
               ->where('resource_id', '<>', $userFeatured)
               ->where('resource_state', 'visible')
               ->order('resource_date', 'DESC')
               ->fetch();

          if (!$resources->count())
          {
               return $this->message(\XF::phrase('siropu_ads_manager_no_resources_found'));
          }

          $approver = $this->service('Siropu\AdsManager:Ad\Approver');
          $approver->setPackageId($packageId);
          $approver->setCategoryId($itemId);
          $approver->verifyEmptyFeaturedSlots($error);

          if ($error)
          {
               $jsonParams['noSlotsError'] = $error;
          }

          $options = '';

          foreach ($resources as $resource)
          {
               $options .= '<option value="' . $resource->resource_id  . '">' . $resource->title . '</option>';
          }

          $reply = $this->view('Siropu\AdsManager:Ajax\GetUserResources');
          $reply->setJsonParams($jsonParams + ['options' => $options]);

          return $reply;
     }
     public function actionVerifyPromoCode()
     {
          $this->assertPostOnly();

          $promoCode = $this->em()->find('Siropu\AdsManager:PromoCode', $this->filter('promo_code', 'str'));

          if (!$promoCode)
		{
               return $this->message(\XF::phrase('siropu_ads_manager_promo_code_not_valid'));
		}

          if (!$promoCode->canApply($this->filter('package_id', 'uint'), $this->filter('cost_amount', 'float'), $error))
          {
               return $this->message($error);
          }

          $reply = $this->view('Siropu\AdsManager:Ajax\VerifyPromoCode');
          $reply->setJsonParams([
               'message'       => \XF::phrase('siropu_ads_manager_promo_code_successfully_applied'),
               'discountType'  => $promoCode->type,
               'discountValue' => $promoCode->value,
               'applied'       => true,
          ]);

          return $reply;
     }
     public function actionMarkAsPaid()
     {
          $id      = $this->filter('id', 'uint');
          $type    = $this->filter('type', 'str');
          $visitor = \XF::visitor();

          if (!$this->isLoggedIn())
          {
               return $this->noPermission();
          }

          foreach ($this->finder('XF:User')->where('is_admin', 1)->fetch() as $admin)
          {
               if ($admin->hasAdminPermission('siropuAdsManager') || $admin->is_super_admin)
               {
                    $this->repository('XF:UserAlert')->alert(
                         $admin,
                         $visitor->user_id,
                         $visitor->username,
                         'user',
                         $visitor->user_id,
                         'sam_marked_as_paid',
                         [
                              'id'   => $id,
                              'type' => $type
                         ]
                    );
               }
          }

          if ($type == 'invoice')
          {
               $invoice = $this->assertInvoiceExists($id);
               $invoice->marked_as_paid = \XF::$time;
               $invoice->save();

               return $this->message(\XF::phrase('siropu_ads_manager_invoice_x_marked_as_paid', ['id' => $id]));
          }
          else
          {
               return $this->message(\XF::phrase('siropu_ads_manager_payment_marked_as_paid'));
          }
     }
}
