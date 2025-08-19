<?php

namespace Siropu\AdsManager;

use XF\Mvc\Entity\Entity;

class Listener
{
     public static function appSetup(\XF\App $app)
     {
          $path = \XF::getAddOnDirectory() . '/Siropu/AdsManager/Vendor/MobileDetect';

          if (phpversion() >= 7.4)
          {
               $classMap = ['Detection\MobileDetect' => "$path/MobileDetect.php"];
          }
          else
          {
               $classMap = ['Mobile_Detect' => "$path/Mobile_Detect.php"];
          }

          \XF::$autoLoader->addClassMap($classMap);

          $container = $app->container();

		$container['samUserDevice'] = function()
		{
               if (phpversion() >= 7.4)
               {
                    $mobileDetect = new \Detection\MobileDetect();
               }
               else
               {
                    $mobileDetect = new \Mobile_Detect();
               }

               return $mobileDetect->isMobile() ? ($mobileDetect->isTablet() ? 'tablet' : 'mobile') : 'desktop';
		};

          $adBlockDisplayAfterXPageViews = $app->options()->siropuAdsManagerAdBlockDisplayAfterXPageViews ?? false;

          if ($adBlockDisplayAfterXPageViews)
          {
               $pageViewCount = (int) $app->session()->get('samPageViewCount');

               if ($pageViewCount <= $adBlockDisplayAfterXPageViews)
               {
                    $app->session()->set('samPageViewCount', $pageViewCount + 1);
               }
          }
     }
     public static function templaterGlobalData(\XF\App $app, array &$data, $reply)
     {
          if ($app->container('app.classType') == 'Admin')
          {
               $class = \XF::extendClass('Siropu\AdsManager\Template\Admin');
               $data['samAdmin'] = new $class();
          }
          else
          {
               $class = \XF::extendClass('Siropu\AdsManager\Template\Ad');
               $class = new $class($app, $reply);

               $data['samAds']            = $class;
               $data['samFilterAds']      = $class->getFilterAds();
               $data['samThreadAds']      = $class->getAdvertiseHereThreadAds();
               $data['samPositions']      = $class->getPositionsForPreview();
               $data['samLoadJsCarousel'] = $class->getLoadJsCarousel();
               $data['samParams']         = $class->getPositionParams();
          }
     }
     public static function templaterSetup(\XF\Container $container, \XF\Template\Templater &$templater)
     {
          $templater->addFilter('sam_keyword_ads', function(\XF\Template\Templater $templater, $value, &$escape, $type, $ads, $entity, $exclude = false, $postCount = 0, $customField = false)
          {
               $escape = false;
               $loadJs = false;

               if (empty($ads) || $exclude)
               {
                    return $value;
               }

               $options = \XF::options();
               $visitor = \XF::visitor();

               $threadTypes = [
                    'thread_poll',
                    'thread_article',
                    'thread_question',
                    'thread_suggestion',
                    'xfrm_thread_view_type_resource',
                    'xa_sc_thread_view_type_item'
               ];

               $typeContent = 'content_' . str_replace($threadTypes, 'thread', $type);

               $positionParams = [];

               if ($entity instanceof \XF\Entity\Post)
               {
                    $positionParams['post']   = $entity;
                    $positionParams['thread'] = $entity->Thread;
               }
               else if ($entity instanceof \XF\Entity\ConversationMessage || $entity instanceof \XF\Entity\ProfilePost)
               {
                    $positionParams['post'] = $entity;
               }
               else if ($entity instanceof \Siropu\Chat\Entity\Message)
               {
                    $positionParams['post'] = [
                         'username' => $entity->message_username,
                         'User'     => $entity->User,
                         'message'  => $entity->message_text
                    ];
               }
               else if ($entity instanceof \Siropu\Chat\Entity\ConversationMessage)
               {
                    $positionParams['post'] = [
                         'username' => $entity->message_username,
                         'User'     => $entity->User,
                         'message'  => $entity->message_text
                    ];
               }

               foreach ($ads as $ad)
               {
                    if ($customField && ($ad->isKeyword() && !$options->siropuAdsManagerKeywordThreadCustomFields
                         || $ad->isAffiliate() && !$options->siropuAdsManagerAffiliateLinkThreadCustomFields))
                    {
                         return $value;
                    }

                    if (!$ad->isPostType($type))
                    {
                         continue;
                    }

                    if (!\XF::app()->criteria('Siropu\AdsManager:Position', $ad->position_criteria, $positionParams)->isMatched($visitor))
                    {
                         continue;
                    }

                    if ($ad->isKeyword())
                    {
                         $postLimit = $ad->getSetting('keyword_limit') ?: -1;
                         $pageLimit = $ad->getSetting('keyword_page_limit');

                         if ($ad->content_1)
                         {
                              $gKey = "samCounter_{$ad->ad_id}";

                              if (!isset($GLOBALS[$gKey]))
                              {
                                   $GLOBALS[$gKey] = 0;
                              }

                              if ($pageLimit)
                              {
                                   if ($postCount && $postLimit == -1)
                                   {
                                        $routePath  = \XF::app()->request()->getRoutePath();
                                        $pageNumber = 1;

                                        if (preg_match('~/page-(\d+)~', $routePath, $match))
                                        {
                                            $pageNumber = $match[1];
                                        }

                                        $perPage     = $options->messagesPerPage;
                                        $pageCount   = ceil($postCount / $perPage);
                                        $pageResults = $pageCount * $perPage;
                                        $lastPage    = $pageResults - $postCount + 1;
                                        $postLimit   = max(1, ceil($pageLimit / ($pageCount == $pageNumber ? $lastPage : $perPage)));
                                   }

                                   if ($GLOBALS[$gKey] >= $pageLimit)
                                   {
                                        continue;
                                   }
                              }

                              $regExp = $ad->getKeywordRegExp();

                              if (preg_match($regExp, $value))
                              {
                                   $attributes  = $ad->getAttributes($typeContent);
                                   $replacement = '$0';

                                   if ($ad->content_2)
                                   {
                                        $replacement = $ad->content_2;
                                   }

                                   if ($ad->target_url)
                                   {
                                        $replace = "<a {$attributes}>{$replacement}</a>";
                                   }
                                   else
                                   {
                                        $replace = "<span {$attributes}>{$replacement}</span>";
                                   }

                                   if ($options->siropuAdsManagerAdActions && $visitor->is_admin)
                                   {
                                        $replace .= $templater->renderTemplate('public:siropu_ads_manager_ad_actions', ['ad' => $ad]);
                                   }

                                   $value = preg_replace($regExp, $replace, $value, $postLimit, $count);

                                   $GLOBALS[$gKey] += $count;

                                   if ($ad->requiresJs() || $ad->settings['ga_stats'])
                                   {
                                        $loadJs = true;
                                   }
                              }
                         }
                         else if (!empty($ad->item_array))
                         {
                              foreach ($ad->item_array as $key => $item)
                              {
                                   $gKey = "samCounter_{$ad->ad_id}_{$key}";

                                   if (!isset($GLOBALS[$gKey]))
                                   {
                                        $GLOBALS[$gKey] = 0;
                                   }

                                   if ($pageLimit)
                                   {
                                        if ($postCount && $postLimit == -1)
                                        {
                                             $routePath  = \XF::app()->request()->getRoutePath();
                                             $pageNumber = 1;

                                             if (preg_match('~/page-(\d+)~', $routePath, $match))
                                             {
                                                 $pageNumber = $match[1];
                                             }

                                             $perPage     = $options->messagesPerPage;
                                             $pageCount   = ceil($postCount / $perPage);
                                             $pageResults = $pageCount * $perPage;
                                             $lastPage    = $pageResults - $postCount + 1;
                                             $postLimit   = max(1, ceil($pageLimit / ($pageCount == $pageNumber ? $lastPage : $perPage)));
                                        }

                                        if ($GLOBALS[$gKey] >= $pageLimit)
                                        {
                                             continue;
                                        }
                                   }

                                   $regExp = $ad->getKeywordRegExp($item['keyword']);

                                   if (preg_match($regExp, $value))
                                   {
                                        $ad->target_url = $item['url'];

                                        if (trim($item['title']))
                                        {
                                             $ad->title = $item['title'];
                                        }

                                        $replacement = '$0';

                                        if (!empty($item['replacement']))
                                        {
                                             $replacement = $item['replacement'];
                                        }

                                        $replace = "<a " . $ad->getAttributes($typeContent) . ">{$replacement}</a>";

                                        if ($options->siropuAdsManagerAdActions && $visitor->is_admin)
                                        {
                                             $replace .= $templater->renderTemplate('public:siropu_ads_manager_ad_actions', ['ad' => $ad]);
                                        }

                                        $value = preg_replace($regExp, $replace, $value, $postLimit, $count);

                                        $GLOBALS[$gKey] += $count;

                                        if ($ad->requiresJs() || $ad->settings['ga_stats'])
                                        {
                                             $loadJs = true;
                                        }
                                   }
                              }
                         }
                    }
                    else if ($ad->isAffiliate())
                    {
                         $domain = rtrim(str_ireplace(['https', 'http', 'www.', '://'], '', $ad->content_1), '/');
                         $domain = ltrim($domain, '.');

                         $matchSub = strpos($ad->content_1, '.') === 0 ? '(?:[\w]+\.)?' : '';

                         $regExp = '#<a [^>]*href="(https?://(?:www\.)?' . $matchSub . preg_quote($domain, '#') . '[^"]*)"[^>]*>(.*?)</a>#usi';

                         if (preg_match_all($regExp, $value, $matches, PREG_SET_ORDER))
                         {
                              foreach ($matches as $match)
                              {
                                   $link = $match[0];
                                   $href = $match[1];
                                   $text = $match[2];

                                   if (strpos($link, 'samItem') !== false)
                                   {
                                        continue;
                                   }

                                   if (!empty($ad->item_array))
                                   {
                                        foreach ($ad->item_array as $item)
                                        {
                                             if (strpos($href, $item) !== false)
                                             {
                                                  continue 2;
                                             }
                                        }
                                   }

                                   switch ($ad->content_2)
                                   {
                                        case 'to_aff':
                                             if (strpos($ad->content_3, '/') === 0)
                                             {
                                                  $append = (strpos(strrev($href), '/') === 0) ? ltrim($ad->content_3, '/') : $ad->content_3;
                                             }
                                             else
                                             {
                                                  $append = (strpos($href, '?') === false ? '?' : '&') . ltrim($ad->content_3, '?');
                                             }

                                             if (strpos($href, ltrim($append, '/?&')) === false)
                                             {
                                                  $url = $href . $append;
                                             }
                                             else
                                             {
                                                  $url = $href;
                                             }
                                             break;
                                        case 'aff_to':
                                             $url = $ad->content_3 . urlencode($href);
                                             break;
                                        case 'replace':
                                             $urlPath  = (string) parse_url($href, PHP_URL_PATH);
                                             $urlQuery = (string) parse_url($href, PHP_URL_QUERY);

                                             $placeholderFind    = ['{match}', '{match_no_domain}', '{path}', '{query}'];
                                             $placeholderReplace = [urlencode($href), "$urlPath?$urlQuery", $urlPath, $urlQuery];

                                             $url = str_ireplace($placeholderFind, $placeholderReplace, $ad->content_3);
                                             break;
                                        case 'params':
                                             $paramFind    = [];
                                             $paramReplace = [];
                                             $paramAppend  = [];

                                             foreach ($ad->getAffiliateLinkParams() as $paramName => $paramValue)
                                             {
                                                  $paramFind[]    = '/' . preg_quote($paramName, '/') . '=[^&?]+/iu';
                                                  $paramReplace[] = "$paramName=$paramValue";

                                                  if (!empty($ad->settings['append_parameters'])
                                                       && strpos($href, "$paramName=") === false)
                                                  {
                                                       $paramAppend[] = "$paramName=$paramValue";
                                                  }
                                             }

                                             $url = preg_replace($paramFind, $paramReplace, $href);

                                             foreach ($paramAppend as $param)
                                             {
                                                  $url .= (strpos($url, '?') === false ? '?' : '&') . $param;
                                             }
                                             break;
                                        case 'callback':
                                             $url = call_user_func_array($ad->content_3, [$ad->content_1, $href]);
                                             break;
                                   }

                                   $attributes = $ad->getAttributes($typeContent);

                                   if ($ad->settings['hide_affiliate'] && \xf::app()->container()['samUserDevice'] == 'desktop')
                                   {
                                        $userAgent = $_SERVER['HTTP_USER_AGENT'];

                                        if (stripos($userAgent, 'Mac') !== false && stripos($userAgent, 'Safari') !== false)
                                        {
                                             $attributes .= ' onclick="window.open(\'' . $url . '\', \'_blank\'); return false;"';
                                        }
                                        else
                                        {
                                             $attributes .= ' data-affiliate-url="' . $url . '"';

                                             $loadJs = true;
                                        }

                                        $url = $href;
                                   }

                                   $anchorText = $ad->title && strpos($text, '<img') === false ? $ad->title : $text;
                                   $anchorText = str_replace('$', '&#36;', $anchorText);
                                   $replace    = '<a href="' . $url . '"' . $attributes . '>' . $anchorText . '</a>';

                                   if (\XF::options()->siropuAdsManagerAdActions && \XF::visitor()->is_admin)
                                   {
                                        $replace .= $templater->renderTemplate('public:siropu_ads_manager_ad_actions', ['ad' => $ad]);
                                   }

                                   $value = preg_replace('~' . preg_quote($match[0], '~') . '~', $replace, $value);
                              }

                              if ($ad->requiresJs() || $ad->settings['ga_stats'])
                              {
                                   $loadJs = true;
                              }
                         }
                    }
               }

               if ($loadJs)
               {
                    $jsFilePath = $options->siropuAdsManagerJsFilePath;

                    $templater->includeJs([
                         'src' => $jsFilePath ?: 'siropu/am/core.js',
                         'min' => $jsFilePath ? false : true
                    ]);
               }

               return $value;
          });

          $templater->addFunction('sam_unit_attributes', function(\XF\Template\Templater $templater, &$escape, $ads, $position)
		{
               $count = count($ads);
               $ad    = reset($ads);

               if (empty($ad))
               {
                    return;
               }

               if ($ad->Package)
               {
                    $attr = $ad->Package->getAttributes($count);
               }
               else
               {
                    $attr = 'class="' . $ad->getUnitCssClass() . '"';

                    if ($count == 1 && !empty($ad->settings['unit_size']))
                    {
                         $attr .= $ad->getUnitSize();
                    }
               }

               $attr .= ' data-position="' . $position . '"';

               return $attr;
          });

          $templater->addFunction('sam_order_ads', function(\XF\Template\Templater $templater, &$escape, $ads)
		{
               if (self::getDisplayOrder() == 'random')
               {
                    shuffle($ads);
               }
               else
               {
                    usort($ads, [__CLASS__, 'sortAdsByOptionOrder']);
               }

               return $ads;
          });

          $templater->addFunction('sam_get_ctr', function(\XF\Template\Templater $templater, &$escape, $clicks, $views)
		{
               return $clicks && $views ? number_format($clicks / $views * 100, 2) : 0;
          });

          $templater->addFunction('sam_type_phrase', function(\XF\Template\Templater $templater, &$escape, $type)
		{
               return \XF::phrase('siropu_ads_manager_ad_type.' . $type);
          });

          $templater->addFunction('sam_status_phrase', function(\XF\Template\Templater $templater, &$escape, $status, $type = 'ad', $css = true)
		{
               $escape = false;
               $phrase = \XF::phrase("siropu_ads_manager_status.$status" . ($status == 'pending' && $type == 'ad' ? '_approval' : ''));

               if ($css)
               {
                    $templater->includeCss('public:siropu_ads_manager_status.less');
                    return '<span class="sam' . ucfirst(str_ireplace('_invoice', '', $status)) . 'Status">' . $phrase . '</span>';
               }

               return $phrase;
          });

          $templater->addFunction('sam_views_impressions_phrase', function(\XF\Template\Templater $templater, &$escape)
		{
               return \XF::options()->siropuAdsManagerViewCountMethod == 'view'
                    ? \XF::phrase('siropu_ads_manager_views')
                    : \XF::phrase('siropu_ads_manager_impressions');
          });

          $templater->addFunction('sam_total_views_impressions_phrase', function(\XF\Template\Templater $templater, &$escape)
		{
               return \XF::options()->siropuAdsManagerViewCountMethod == 'view'
                    ? \XF::phrase('siropu_ads_manager_total_views')
                    : \XF::phrase('siropu_ads_manager_total_impressions');
          });

          $templater->addFunction('sam_counter', function(\XF\Template\Templater $templater, &$escape, $position = '')
		{
               if (!isset($GLOBALS["sam_counter_$position"]))
               {
                    $GLOBALS["sam_counter_$position"] = 1;
               }
               else
               {
                    $GLOBALS["sam_counter_$position"]++;
               }

               return $GLOBALS["sam_counter_$position"];
          });

          $templater->addFunction('sam_mail_ads', function(\XF\Template\Templater $templater, &$escape, \XF\Entity\User $user = null)
		{
               $positionGroup = [
                    'mail_above_content' => [],
                    'mail_below_content' => []
               ];

               if ($user && !$user->hasPermission('siropuAdsManager', 'viewAds'))
               {
                    return $positionGroup;
               }

               $simpleCache = \XF::app()->simpleCache();
               $mailAdIds   = $simpleCache['Siropu/AdsManager']['mailAdIds'];

               if ($mailAdIds)
               {
                    $ads = \XF::finder('Siropu\AdsManager:Ad')
                         ->where('ad_id', $mailAdIds)
                         ->fetch()
                         ->filter(function(\Siropu\AdsManager\Entity\Ad $ad) use ($user)
                         {
                              return ($ad->matchesUserCriteria($user));
                         });

                    foreach ($ads as $ad)
                    {
                         foreach ($ad->position as $position)
                         {
                              if (in_array($position, ['mail_above_content', 'mail_below_content']))
                              {
                                   $positionGroup[$position][] = $ad;
                              }
                         }
                    }

                    foreach ($positionGroup as $position => $group)
                    {
                         $positionGroup[$position] = \XF::repository('Siropu\AdsManager:Package')->sortAds($group);
                    }

                    return $positionGroup;
               }

               return [];
          });

          $templater->addFunction('sam_mail_position_ads', function(\XF\Template\Templater $templater, &$escape, $ads, $position)
		{
               return $ads[$position];
          });
     }
     public static function templaterMacroPostRender(\XF\Template\Templater $templater, $type, $template, $name, &$output)
     {
          if (trim($output))
          {
               $output = preg_replace('/(?<=>)\s+|\s+(?=<)/', ' ', $output);
          }
     }
     public static function criteriaUser($rule, array $data, \XF\Entity\User $user, &$returnValue)
     {
          switch ($rule)
          {
               case 'is_guest_cookie':
                    if ($user['user_id'] == 0 && \XF::app()->request()->getCookie('notice_dismiss') == -1)
                    {
                    	$returnValue = true;
                    }
               break;
          }
     }
     public static function criteriaPage($rule, array $data, \XF\Entity\User $user, array $params, &$returnValue)
	{
          switch ($rule)
		{
               case 'nodes_not':
                    $breadcrumb = isset($params['breadcrumbs']) && is_array($params['breadcrumbs'])
                         ? current($params['breadcrumbs'])
                         : null;

                    if (!empty($data['display_outside']) && !isset($breadcrumb['attributes']['node_id']))
                    {
                         $returnValue = true;
                         return true;
                    }

                    if (empty($breadcrumb))
                    {
                         $returnValue = false;
                         return false;
                    }

                    if (empty($data['node_ids']))
                    {
                         $returnValue = false;
                         return false;
                    }

                    if (empty($data['node_only']))
                    {
                         foreach ($params['breadcrumbs'] AS $i => $navItem)
                         {
                              if (isset($navItem['attributes']['node_id'])
                                   && in_array($navItem['attributes']['node_id'], $data['node_ids']))
                              {
                                   $returnValue = false;
                                   return false;
                              }
                         }
                    }

                    if ($params['containerKey'])
                    {
                         list($type, $id) = explode('-', $params['containerKey'], 2);

                         if ($type == 'node' && $id && in_array($id, $data['node_ids']))
                         {
                              $returnValue = false;
                              return false;
                         }
                    }

                    $returnValue = true;

                    break;
               case 'template_not':
				if (!empty($params['template'])
                         && !in_array(strtolower($params['template']), \Siropu\AdsManager\Util\Arr::getItemArray($data['name'])))
				{
					$returnValue = true;
				}
				break;
               case 'style_not':
                    if (!empty($params['style_id']) && $user->style_id != $params['style_id'])
                    {
                         $returnValue = true;
                    }
                    break;
          }
	}
     public static function threadEntityPreSave(\XF\Mvc\Entity\Entity $entity)
	{
          $samPrefix = (int) \XF::options()->siropuAdsManagerStickyThreadPrefix;

          if ($entity->prefix_id && $entity->prefix_id == $samPrefix && !$entity->sticky)
          {
               $entity->error(\XF::phrase('siropu_ads_manager_thread_prefix_reserved'), 'prefix_id');
          }
     }
     public static function resourceItemEntityPreSave(\XF\Mvc\Entity\Entity $entity)
	{
          $samPrefix = \XF::options()->siropuAdsManagerFeaturedResourcePrefix;

          if ($entity->prefix_id && $entity->prefix_id == $samPrefix && !$entity->Featured)
          {
               $entity->error(\XF::phrase('siropu_ads_manager_resource_prefix_reserved'), 'prefix_id');
          }
     }
     public static function userOptionEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
     {
          $structure->columns['siropu_ads_manager_view_ads'] = ['type' => Entity::BOOL, 'default' => 1, 'changeLog' => false];
     }
     protected static function sortAdsByOptionOrder($a, $b)
     {
          $order = self::getDisplayOrder();

          switch ($order)
          {
               case 'dateAsc':
               case 'dateDesc':
                    $f = 'create_date';
                    break;
               case 'orderAsc':
               case 'orderDesc':
                    $f = 'display_order';
                    break;
               case 'viewAsc':
               case 'viewDesc':
                    $f = 'view_count';
                    break;
               case 'clickAsc':
               case 'clickDesc':
                    $f = 'click_count';
                    break;
               case 'ctrAsc':
               case 'ctrDesc':
                    $f = 'ctr';
                    break;
          }

          if ($a->{$f} == $b->{$f})
          {
               return 0;
          }

          return strpos($order, 'Desc') ? (($a->{$f} > $b->{$f}) ? -1 : 1) : (($a->{$f} < $b->{$f}) ? -1 : 1);
     }
     protected static function getDisplayOrder()
     {
          return \XF::options()->siropuAdsManagerAdvertisersPage['order'];
     }
}
