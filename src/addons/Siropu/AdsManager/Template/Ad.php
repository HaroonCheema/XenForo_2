<?php

namespace Siropu\AdsManager\Template;

class Ad
{
     protected $pageState = [];
     protected $positionParams = [];
     protected $dynamicPositions = [];
     protected $randomPositionId = [];

     protected $itemCount = 0;
     protected $firstUnread = 0;

     protected $searchQuery = '';

     protected $ads = [];
     protected $placeholders = [];

     protected $filterAds;
     protected $loadFilterAds = false;
     protected $loadAdvertisereHereForumAds = false;

     protected $priorityValues = [];

     protected $loadJsCarousel = 0;

     public function __construct(\XF\App $app, $reply)
     {
          $options = \XF::options();
          $visitor = \XF::visitor();

          if (!method_exists($visitor, 'canViewAdsSiropuAdsManager'))
		{
			return;
		}

          if (!($visitor->canViewAdsSiropuAdsManager() && $reply))
          {
               return;
          }

          $classes     = [];
          $actions     = [];
          $postParsing = $options->siropuAdsManagerAdParsingWhenPosting;

          if (!empty($postParsing['thread']))
          {
               $classes[] = 'XF:Thread';
               $actions[] = 'AddReply';
               $actions[] = 'add-reply';
          }

          if (!empty($postParsing['conversation']))
          {
               $classes[] = 'XF:Conversation';
               $actions[] = 'AddReply';
               $actions[] = 'add-reply';
          }

          if (!empty($postParsing['profile']))
          {
               $classes[] = 'XF:Member';
               $actions[] = 'Post';
          }

          if (!empty($postParsing['chat']))
          {
               $classes[] = 'Siropu\Chat:Chat';
               $actions[] = 'Submit';
               $actions[] = 'Update';
          }

          $controllerClass  = $reply->getControllerClass();
          $controllerAction = $reply->getAction();

          if (($app->request()->isXhr() && !(in_array($controllerClass, $classes) && in_array($controllerAction, $actions)))
               || strpos($controllerClass, 'Siropu\AdsManager') !== false)
          {
               return;
          }

          $this->pageState = [
               'pageSection'  => $reply->getSectionContext(),
               'controller'   => $controllerClass,
               'action'       => $controllerAction,
               'containerKey' => $reply->getContainerKey(),
               'fromSearch'   => $app->request()->getFromSearch(),
               'pageStyleId'  => $app->templater()->getStyleId(),
               'classType'    => $app->container('app.classType'),
               'breadcrumbs'  => []
          ];

          if ($reply instanceof \XF\Mvc\Reply\View)
		{
			$this->pageState['view']     = $reply->getViewClass();
			$this->pageState['template'] = $reply->getTemplateName();
		}
		else if ($reply instanceof \XF\Mvc\Reply\Error || $reply->getResponseCode() >= 400)
		{
			$this->pageState['template'] = 'error';
		}
		else if ($reply instanceof \XF\Mvc\Reply\Message)
		{
			$this->pageState['template'] = 'message_page';
		}

          $disallowedTemplates = $options->siropuAdsManagerDisallowedTemplates;

          if (!empty($disallowedTemplates)
               && isset($this->pageState['template'])
               && in_array($this->pageState['template'], \Siropu\AdsManager\Util\Arr::getItemArray($disallowedTemplates, false, "\n")))
          {
               return;
          }

          if ($reply instanceof \XF\Mvc\Reply\View)
          {
               $params = $reply->getParams();

               switch ($this->pageState['template'])
               {
                    case 'forum_view':
                    case 'forum_view_type_article':
                    case 'forum_view_type_question':
                    case 'forum_view_type_suggestion':
                    case 'thread_view':
                    case 'thread_view_type_poll':
                    case 'thread_view_type_article':
                    case 'thread_view_type_question':
                    case 'thread_view_type_suggestion':
                    case 'amp_thread_view':
                    case 'amp_thread_view_type_poll':
                    case 'amp_thread_view_type_article':
                    case 'amp_thread_view_type_question':
                    case 'amp_thread_view_type_suggestion':
                    case 'xfrm_thread_view_type_resource':
                    case 'xa_sc_thread_view_type_item':
                         $entity = $params['forum'];
                         break;
                    case 'page_view':
                         $entity = $params['page'];
                         break;
                    case 'xfrm_category_view':
                    case 'xfrm_resource_view':
                         $entity = $params['category'];
                         break;
                    case 'xfrm_resource_updates':
                    case 'xfrm_resource_reviews':
                         $entity = $params['resource']['Category'];
                         break;
                    case 'xfmg_category_view':
                         $entity = $params['category'];
                         break;
                    case 'xfmg_media_view':
                         $entity = $params['mediaItem']['Category'];
                         break;
                    case 'xa_ams_category_view':
                         $entity = $params['category'];
                         break;
                    case 'xa_ams_article_view':
                         $entity = $params['article']['Category'];
                         break;
                    case 'xa_sc_item_view':
                         $entity = $params['item']['Category'];
                         break;
                    case 'dbtech_ecommerce_product_view':
                    case 'dbtech_ecommerce_product_specifications':
                         $entity = $params['product'];
                         break;
                    default:
                         $entity = null;
                         break;
               }

               if (!empty($entity))
               {
                    if (strpos($this->pageState['template'], 'forum_view') !== false)
                    {
                         $ids = array_merge(
                              $options->siropuAdsManagerPromoThreadForums, $options->siropuAdsManagerAllowedStickyForums);

                         if (in_array($entity->node_id, $ids))
                         {
                              $this->loadAdvertisereHereForumAds = true;
                         }
                    }

                    foreach ($entity->getBreadcrumbs() as $breadcrumb)
                    {
                         $attributes = array_filter($breadcrumb, function($key)
                         {
                              return in_array($key, ['node_id', 'category_id', 'resource_category_id']);
                         }, ARRAY_FILTER_USE_KEY);

                         $this->pageState['breadcrumbs'][] = ['attributes' => $attributes];
                    }
               }

               switch ($this->pageState['controller'])
               {
                    case 'XF:Page':
                         if (!empty($params['page']))
                         {
                              $this->positionParams['page'] = $params['page'];
                         }
                         break;
                    case 'XF:Forum':
                    case 'XF:WhatsNewPost':
                         if (!empty($params['forum']))
                         {
                              $this->positionParams['forum'] = $params['forum'];
                         }
                         if (!empty($params['threads']))
                         {
                              $this->itemCount = count($params['threads']);
                         }
                         break;
                    case 'XF:Thread':
                         if (isset($params['posts'], $params['thread']))
                         {
                              $this->positionParams['thread'] = $params['thread'];
                              $this->itemCount = count($params['posts']);

                              $i = 0;

                              foreach ($params['posts'] as $post)
                              {
                                   $i++;

                                   if (!$this->firstUnread && $post->isUnread())
                                   {
                                        $this->firstUnread = $i;
                                   }

                                   $this->positionParams['posts'][$i] = $post;
                              }

                              $this->loadFilterAds = true;
                         }
                         break;
                    case 'XF:Conversation':
                         if (!empty($params['userConvs']))
                         {
                              $this->itemCount = count($params['userConvs']);
                         }
                         break;
                    case 'XF\Pub\Controller\Conversation':
                         if (isset($params['messages'], $params['lastRead']))
                         {
                              $this->positionParams['conversation'] = $params['conversation'];
                              $this->itemCount = count($params['messages']);

                              $i = 0;

                              foreach ($params['messages'] as $message)
                              {
                                   $i++;

                                   if (!$this->firstUnread && $message->isUnread($params['lastRead']))
                                   {
                                        $this->firstUnread = $i;
                                   }

                                   $this->positionParams['posts'][$i] = $message;
                              }

                              $this->loadFilterAds = true;
                         }
                         break;
                    case 'XF:Member':
                    case 'XF\Pub\Controller\Member':
                         if (!empty($params['profilePosts']))
                         {
                              $this->itemCount = count($params['profilePosts']);

                              $i = 0;

                              foreach ($params['profilePosts'] as $post)
                              {
                                   $this->positionParams['posts'][$i++] = $post;
                              }

                              $this->loadFilterAds = true;
                         }
                         break;
                    case 'XF\Pub\Controller\Search':
                    case 'XF:Tag':
                         if (!empty($params['results']))
                         {
                              $this->itemCount = count($params['results']);
                         }
                         if (!empty($params['search']))
                         {
                              $this->positionParams['searchQuery'] = $params['search']['search_query'];
                         }
                         break;
                    case 'XF:WhatsNew':
                         if (!empty($params['newsFeedItems']))
                         {
                              $this->itemCount = count($params['newsFeedItems']);
                         }
                         break;
                    case 'XFMG:Media':
                    case 'XFMG\Pub\Controller\Category':
                    case 'XFMG\Pub\Controller\Album':
                         if (!empty($params['mediaItems']))
                         {
                              $this->itemCount = count($params['mediaItems']);
                         }
                         break;
                    case 'XFMG\Pub\Controller\Media':
                         if (!empty($params['comments']))
                         {
                              $this->itemCount = count($params['comments']);
                         }
                         break;
                    case 'XFRM:ResourceItem':
                    case 'XFRM:Category':
                    case 'XFRM\Pub\Controller\ResourceItem':
                         if (!empty($params['resources']))
                         {
                              $this->itemCount = count($params['resources']);
                         }
                         if (!empty($params['resource']))
                         {
                              $this->positionParams['resource'] = $params['resource'];
                         }
                         break;
                    case 'XenAddons\AMS:Category':
                    case 'XenAddons\AMS:ArticleItem':
                    case 'XenAddons\AMS\Pub\Controller\ArticleItem':
                         if (!empty($params['articles']))
                         {
                              $this->itemCount = count($params['articles']);
                         }
                         if (!empty($params['article']))
                         {
                              $this->positionParams['article'] = $params['article'];
                         }
                         break;
                    case 'XenAddons\Showcase:Category':
                         if (!empty($params['items']))
                         {
                              $this->itemCount = count($params['items']);
                         }
                         break;
                    case 'XenAddons\Showcase\Pub\Controller\Item':
                         if (!empty($params['item']))
                         {
                              $this->positionParams['showcase'] = $params['item'];
                         }
                         break;
                    case 'XF:Account':
                         if (!empty($params['alerts']))
                         {
                              $this->itemCount = count($params['alerts']);
                         }
                         break;
                    case 'XFRM\Pub\Controller\ResourceItem':
                    case 'XenAddons\AMS\Pub\Controller\ArticleItem':
                    case 'XenAddons\Showcase\Pub\Controller\Item':
                    case 'DBTech\eCommerce\Pub\Controller\Product':
                    case 'DBTech\eCommerce:Product':
                    case 'Siropu\Chat:Chat':
                    case 'Siropu\Chat:Archive':
                         $this->loadFilterAds = true;
                         break;
                    case 'XF:Forum\Listing':
                         if (!empty($postParsing['chat']))
                         {
                              $this->loadFilterAds = true;
                         }
                         break;
               }

               if ($this->itemCount)
               {
                    $this->positionParams['itemCount'] = $this->itemCount;
               }
          }

          $this->setAds();

          if ($this->loadFilterAds)
          {
               $this->setFilterAds();
          }
     }
     public function setAds()
     {
          $this->ads = $this->prepareAdsForDisplay();
     }
     public function setFilterAds()
     {
          $this->filterAds = $this->loadFilterAds();
     }
     public function getAds($position)
     {
          $ads = isset($this->ads[$position]) ? $this->ads[$position] : [];

          foreach ($ads as $type => &$packageAds)
          {
               foreach ($packageAds as $packageId => &$adList)
               {
                    foreach ($adList as $id => $ad)
                    {
                         if (!empty($this->positionParams) && !$this->matchesPositionCriteria($ad, $position))
                         {
                              unset($adList[$id], $this->priorityValues[$packageId][$position][$id]);

                              if (empty($packageAds[$packageId]))
                              {
                                   unset($packageAds[$packageId]);
                              }
                         }
                    }

                    if ($packageId && count($adList) > 1)
                    {
                         $placeholderId = $this->placeholders[$packageId];

                         if ($placeholderId)
                         {
                              unset($adList[$placeholderId], $this->priorityValues[$packageId][$position][$placeholderId]);
                         }

                         $displayLimit = $ad->Package->ad_display_limit ?: 1;
                         $displayOrder = $ad->Package->ad_display_order ?: 'random';

                         if ($displayOrder == 'random')
                         {
                              if (array_sum($this->priorityValues[$packageId][$position]) > 0)
                              {
                                   $this->sortAdsByPriority($adList, $packageId, $position);
                              }
                              else
                              {
                                   shuffle($adList);
                              }
                         }
                         else
                         {
                              usort($adList, '\Siropu\AdsManager\Util\Package::sortAdsByPackageOrder');
                         }

                         if (count($adList) > $displayLimit)
                         {
                              $adList = array_slice($adList, 0, $displayLimit);
                         }
                    }
               }

               unset($adList);
          }

          unset($packageAds);

          return $ads;
     }
     public function getFilterAds()
     {
          return $this->filterAds;
     }
     public function getAdvertiseHereThreadAds()
     {
          if ($this->loadAdvertisereHereForumAds)
          {
               $advertiseHerePackageIds = $this->getAdvertiseHerePackageIds();

               if (empty($advertiseHerePackageIds))
               {
                    return [];
               }

               $packages = \XF::finder('Siropu\AdsManager:Package')
                    ->where('package_id', $advertiseHerePackageIds)
                    ->fetch()
                    ->filter(function(\Siropu\AdsManager\Entity\Package $package)
                    {
                         return ($package->isValidAdvertiser());
                    });

               $data = [];

               foreach ($packages as $package)
               {
                    $data[$package->type] = [
                         'package_id'    => $package->package_id,
                         'cost_amount'   => $package->cost_amount,
                         'cost_currency' => $package->cost_currency,
                         'cost_custom'   => $package->cost_custom,
                         'cost_per'      => $package->getCostPerPhrase()->render()
                    ];
               }

               return $data;
          }
     }
     public function getPositionsForPreview()
     {
          if (\XF::options()->siropuAdsManagerPositionVisualization && \XF::visitor()->is_admin)
          {
               $finder = $this->getPositionRepo()
                    ->findPositionsForList()
                    ->where('position_id', '<>', ['no_wrapper_head', 'no_wrapper_after_body', 'no_wrapper_before_body']);

               $positions = [];

               foreach ($finder->fetch() as $pos)
               {
                    $value = ($pos->Category ? "<b>[{$pos->Category->title}]</b> " : '') . $pos->title;

                    if (preg_match('/x([0-9]+)/', $pos->position_id, $match))
                    {
                         for ($i = 1; $i <= $this->itemCount; $i++)
                         {
                              if ($i % $match[1] == 0)
                              {
                                   $positions[preg_replace('/x([0-9]+)/', '', $pos->position_id) . $i] = $value;
                              }
                         }
                    }
                    else
                    {
                         $positions[$pos->position_id] = $value;
                    }
               }

               return $positions;
          }

          return [];
     }
     public function getLoadJsCarousel()
     {
          return $this->loadJsCarousel > 1;
     }
     public function getPositionParams()
     {
          return $this->positionParams;
     }
     protected function matchesPositionCriteria(\Siropu\AdsManager\Entity\Ad $ad, $position)
     {
          if (!empty($this->dynamicPositions) && !empty($this->positionParams['posts']) && preg_match('/_([0-9]+)$/', $position, $match))
          {
               $this->positionParams['post'] = $this->positionParams['posts'][$match[1]];
          }

          return $ad->matchesPositionCriteria($this->positionParams);
     }
     protected function prepareAdsForDisplay()
     {
          $ads = $this->getAdRepo()
               ->findActiveAdsForDisplay()
               ->with('MasterTemplate')
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\Ad $ad)
               {
                    return ($ad->canDisplay()
                         && $ad->matchesUserCriteria()
                         && $ad->matchesPageCriteria($this->pageState)
                         && $ad->matchesDeviceCriteria()
                         && $ad->matchesGeoCriteria());
               });

          $list = [];

          foreach ($ads as $ad)
          {
               $itemId = $ad->getItemId();

               foreach ($ad->getPosition() as $position)
               {
                    $this->dynamicPositions = [];

                    if (!empty($itemId) && preg_match('/_$/', $position))
                    {
                         foreach ($itemId as $id)
                         {
                              if ($this->firstUnread && in_array('u', $itemId) && $id != 'u')
                              {
                                   continue;
                              }

                              $this->generateDynamicPosition($id, rtrim($position, '_'), $ad);
                         }
                    }
                    else if (preg_match('/_([lru]|x[0-9]+)$/', $position, $match))
                    {
                         $this->generateDynamicPosition($match[1], preg_replace("/$match[0]$/", '', $position), $ad);
                    }

                    $positions = $this->dynamicPositions ?: [$position];

                    foreach ($positions as $positionId)
                    {
                         $list[$positionId][$ad->type][$ad->package_id][$ad->ad_id] = $ad;

                         if ($ad->Package)
                         {
                              $this->priorityValues[$ad->package_id][$positionId][$ad->ad_id] = $ad->display_priority;
                              $this->placeholders[$ad->package_id] = $ad->Package->placeholder_id;

                              if ($ad->Package->isCarousel(2))
                              {
                                   $this->loadJsCarousel += 1;
                              }
                         }
                    }
               }
          }

          return $list;
     }
     protected function generateDynamicPosition($id, $position, $ad)
     {
          switch ($id)
          {
               case 'l':
                    $this->dynamicPositions[] = $position . '_' . $this->itemCount;
                    break;
               case 'r':
                    $randomId = rand(1, $this->itemCount);

                    if (isset($this->randomPositionId[$ad->package_id][$position]))
                    {
                         $randomId = $this->randomPositionId[$ad->package_id][$position];
                    }
                    else
                    {
                         $this->randomPositionId[$ad->package_id][$position] = $randomId;
                    }

                    $this->dynamicPositions[] = $position . '_' . $randomId;
                    break;
               case 'u':
                    $this->dynamicPositions[] = $position . '_' . $this->firstUnread;
                    break;
               default:
                    if (preg_match('/x([0-9]+)/', $id, $match))
                    {
                         for ($i = 1; $i <= $this->itemCount; $i++)
                         {
                              if ($i % $match[1] == 0)
                              {
                                   $this->dynamicPositions[] = $position . '_' . $i;
                              }
                         }
                    }
                    else
                    {
                         $this->dynamicPositions[] = $position . '_' . $id;
                    }
                    break;
          }
     }
     protected function loadFilterAds()
     {
          $ads = $this->getAdRepo()
               ->findActiveFilterAds()
               ->fetch()
               ->filter(function(\Siropu\AdsManager\Entity\Ad $ad)
               {
                    return ($ad->matchesUserCriteria()
                         && $ad->matchesPageCriteria($this->pageState)
                         && $ad->matchesDeviceCriteria()
                         && $ad->matchesGeoCriteria()
                         && $ad->matchesPositionCriteria($this->positionParams, true));
               })->toArray();

          shuffle($ads);

          return $ads;
     }
     protected function sortAdsByPriority(&$adList, $packageId, $positionId)
     {
          $adCount      = count($adList);
          $adListSorted = [];

          for ($i = 0; $i < $adCount; $i++)
          {
               $id = \Siropu\AdsManager\Util\Package::getRandomWeightedElement($this->priorityValues[$packageId][$positionId]);
               $adListSorted[] = $adList[$id];

               unset($this->priorityValues[$packageId][$positionId][$id]);
          }

          $adList = $adListSorted;
     }
     public function getUserDevice()
     {
          return \XF::app()->container()['samUserDevice'];
     }
     public function getAdvertiseHerePackageIds()
     {
          $simpleCache = \XF::app()->simpleCache();
          return $simpleCache['Siropu/AdsManager']['advertiseHerePackageIds'] ?: [];
     }
     /**
      * @return \Siropu\AdsManager\Repository\Ad
      */
     public function getAdRepo()
     {
          return \XF::repository('Siropu\AdsManager:Ad');
     }
     /**
      * @return \Siropu\AdsManager\Repository\Position
      */
     public function getPositionRepo()
     {
          return \XF::repository('Siropu\AdsManager:Position');
     }
}
