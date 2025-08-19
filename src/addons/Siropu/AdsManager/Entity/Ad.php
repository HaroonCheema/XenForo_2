<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Ad extends AbstractEntity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_ad';
          $structure->shortName  = 'AdsManager:Ad';
          $structure->primaryKey = 'ad_id';

          $structure->columns = [
               'ad_id'             => ['type' => self::UINT, 'autoIncrement' => true],
               'package_id'        => ['type' => self::UINT, 'default' => 0],
               'inherit_package'   => ['type' => self::UINT, 'default' => 0],
               'type'              => ['type' => self::STR, 'default' => 'code'],
               'user_id'           => ['type' => self::UINT, 'default' => \XF::visitor()->user_id],
               'username'          => ['type' => self::STR, 'default' => \XF::visitor()->username],
               'name'              => ['type' => self::STR, 'maxLength' => 255, 'required' => 'siropu_ads_manager_please_enter_valid_name'],
               'position'          => ['type' => self::JSON_ARRAY, 'default' => []],
               'content_1'         => ['type' => self::STR, 'default' => ''],
               'content_2'         => ['type' => self::STR, 'default' => ''],
               'content_3'         => ['type' => self::STR, 'default' => ''],
               'content_4'         => ['type' => self::STR, 'default' => ''],
               'title'             => ['type' => self::STR, 'maxLength' => 255, 'default' => ''],
               'item_array'        => ['type' => self::JSON_ARRAY, 'default' => []],
               'banner_file'       => ['type' => self::JSON_ARRAY, 'default' => []],
               'banner_url'        => ['type' => self::JSON_ARRAY, 'default' => []],
               'target_url'        => ['type' => self::STR, 'maxLength' => 255, 'match' => 'url_empty', 'default' => ''],
               'item_id'           => ['type' => self::UINT, 'default' => 0],
               'create_date'       => ['type' => self::UINT, 'default' => \XF::$time],
               'start_date'        => ['type' => self::UINT, 'default' => 0],
               'end_date'          => ['type' => self::UINT, 'default' => 0],
               'view_limit'        => ['type' => self::UINT, 'default' => 0],
               'daily_view_limit'  => ['type' => self::UINT, 'default' => 0],
               'click_limit'       => ['type' => self::UINT, 'default' => 0],
               'display_order'     => ['type' => self::UINT, 'default' => 0],
               'display_priority'  => ['type' => self::UINT, 'default' => 0],
               'settings'          => ['type' => self::JSON_ARRAY, 'default' => []],
               'position_criteria' => ['type' => self::JSON_ARRAY, 'default' => []],
               'user_criteria'     => ['type' => self::JSON_ARRAY, 'default' => []],
               'page_criteria'     => ['type' => self::JSON_ARRAY, 'default' => []],
               'device_criteria'   => ['type' => self::JSON_ARRAY, 'default' => []],
               'geo_criteria'      => ['type' => self::JSON_ARRAY, 'default' => []],
               'view_count'        => ['type' => self::UINT, 'default' => 0],
               'click_count'       => ['type' => self::UINT, 'default' => 0],
               'ctr'               => ['type' => self::FLOAT, 'default' => 0],
               'status'            => ['type' => self::STR, 'default' => 'active']
          ];

          $structure->getters   = [
               'attributes'         => false,
               'email_inline_style' => false,
               'link_attributes'    => false,
               'popup_content'      => false,
               'background_data'    => false,
               'width_height'       => false,
               'banner'             => false,
               'banners'            => false,
               'code'               => false,
               'description'        => false,
               'callback'           => false
          ];

          $structure->relations = [
               'Extra' => [
                    'entity'     => 'Siropu\AdsManager:AdExtra',
                    'type'       => self::TO_ONE,
                    'conditions' => 'ad_id',
                    'primary'    => true
               ],
               'Package' => [
                    'entity'     => 'Siropu\AdsManager:Package',
                    'type'       => self::TO_ONE,
                    'conditions' => 'package_id',
                    'primary'    => true
               ],
               'Invoices' => [
                    'entity'     => 'Siropu\AdsManager:Invoice',
                    'type'       => self::TO_MANY,
                    'conditions' => 'ad_id'
               ],
               'User' => [
                    'entity'     => 'XF:User',
                    'type'       => self::TO_ONE,
                    'conditions' => 'user_id',
                    'primary'    => true
               ],
               'Thread' => [
                    'entity'     => 'XF:Thread',
                    'type'       => self::TO_ONE,
                    'conditions' => [['thread_id', '=', '$item_id']],
               ],
               'Resource' => [
                    'entity'     => 'XFRM:ResourceItem',
                    'type'       => self::TO_ONE,
                    'conditions' => [['resource_id', '=', '$item_id']],
               ],
               'Forum' => [
                    'entity'     => 'XF:Forum',
                    'type'       => self::TO_ONE,
                    'conditions' => [['node_id', '=', '$content_1']],
               ],
               'MasterTemplate' => [
				'entity' => 'XF:Template',
				'type' => self::TO_ONE,
				'conditions' => [
					['style_id', '=', 0],
					['type', '=', 'public'],
					['title', '=', '_siropu_ads_manager_ad_code.', '$ad_id']
				]
			],
               'ClickFraud' => [
                    'entity'     => 'Siropu\AdsManager:ClickFraud',
                    'type'       => self::TO_MANY,
                    'conditions' => 'ad_id'
               ]
          ];

          $structure->behaviors = [
               'Siropu\AdsManager:ExtraUpdatable' => []
          ];

          $structure->options = [
               'admin_edit'    => true,
               'process_queue' => false
          ];

          $structure->defaultWith = ['Package'];

          return $structure;
     }
     public function canView()
     {
          $visitor = \XF::visitor();

          return $visitor->canViewAdsSiropuAdsManager();
     }
     public function canEdit()
     {
          return $this->user_id == \XF::visitor()->user_id;
     }
     public function canDelete()
     {
          return $this->canEdit() && \XF::visitor()->hasPermission('siropuAdsManager', 'delete');
     }
     public function canPause()
     {
          return $this->isActive() && \XF::visitor()->canPauseAdsSiropuAdsManager() != 0;
     }
     public function canExtend()
     {
          return $this->isOfStatus(['active', 'inactive', 'archived'])
               && $this->Package
               && !$this->Package->isFree()
               && !$this->getInvoiceCount('pending');
     }
     public function canEditEssentialData()
     {
          if ($this->Extra && $this->Extra->isOfPrevStatus(['active', 'approved', 'queued', 'queued_invoice', 'paused']))
          {
               return false;
          }

          return $this->isOfStatus(['', 'pending', 'inactive', 'archived', 'rejected']);
     }
     public function canEditKeywords()
     {
          return $this->isKeyword() && $this->canEditEssentialData();
     }
     public function canEditPromoThread()
     {
          return $this->isThread() && $this->canEditEssentialData() && !$this->Thread;
     }
     public function canUseDeviceCriteria()
     {
          return \XF::visitor()->canUseDeviceCriteriaSiropuAdsManager();
     }
     public function canUseGeoCriteria()
     {
          return \XF::visitor()->canUseGeoCriteriaSiropuAdsManager();
     }
     public function canUseMultipleBanners()
     {
          return \XF::visitor()->canUseMultipleBannersSiropuAdsManager();
     }
     public function canUseExternalBanners()
     {
          return \XF::visitor()->canUseExternalBannersSiropuAdsManager();
     }
     public function canUseCustomBannerCode()
     {
          return \XF::visitor()->canUseCustomBannerCodeSiropuAdsManager();
     }
     public function canViewGeneralStats()
     {
          return \XF::visitor()->canViewGeneralStatsSiropuAdsManager();
     }
     public function canViewDailyStats()
     {
          return \XF::visitor()->canViewDailyStatsSiropuAdsManager();
     }
     public function canViewClickStats()
     {
          return \XF::visitor()->canViewClickStatsSiropuAdsManager();
     }
     public function canViewBackup()
     {
          return !\XF::visitor()->isMemberOf(\XF::options()->siropuAdsManagerAdBlockExcludeUserGroup);
     }
     public function canCountViews()
     {
          return !empty($this->settings['count_views']);
     }
     public function canCountClicks()
     {
          return !empty($this->settings['count_clicks']);
     }
     public function getEmailImageUrl($position)
     {
          if ($this->canCountViews())
          {
               $params = [];

               if ($this->settings['daily_stats'])
               {
                    $params = $this->getEmailPositionParam($position);
               }

               return $this->app()->router('public')->buildLink('canonical:sam-item/image', $this, $params);
          }

          return $this->banner;
     }
     public function getEmailTargetUrl($position)
     {
          if ($this->canCountClicks())
          {
               $params = [];

               if ($this->settings['daily_stats'])
               {
                    $params = $this->getEmailPositionParam($position);
               }

               return $this->app()->router('public')->buildLink('canonical:sam-item/click', $this, $params);
          }

          return $this->target_url;
     }
     public function getEmailPositionParam($position)
     {
          return ['p' => $position == 'mail_above_content' ? 1 : 2];
     }
     public function countView()
     {
          $this->view_count++;

          if ($this->daily_view_limit)
          {
               $this->daily_view_limit--;
          }
     }
     public function countClick()
     {
          $this->click_count++;
     }
     public function inheritPackage($isPurchase = false)
     {
          $package = $this->Package;

          if (!$package)
          {
               $this->inherit_package = 0;

               return;
          }

          $settings = [
               'no_wrapper'         => $package->getSetting('no_wrapper'),
               'lazyload_image'     => $package->getSetting('lazyload_image'),
               'lazyload'           => $package->getSetting('lazyload'),
               'refresh'            => $package->getSetting('refresh'),
               'count_views'        => $package->getSetting('count_views'),
               'count_clicks'       => $package->getSetting('count_clicks'),
               'daily_stats'        => $package->getSetting('daily_stats'),
               'click_stats'        => $package->getSetting('click_stats'),
               'ga_stats'           => $package->getSetting('ga_stats'),
               'nofollow'           => $package->getSetting('nofollow'),
               'rel'                => $package->getSetting('rel'),
               'rel_custom'         => $package->getSetting('rel_custom'),
               'target_blank'       => $package->getSetting('target_blank'),
               'hide_from_robots'   => $package->getSetting('hide_from_robots'),
               'hide_close_button'  => $package->getSetting('hide_close_button'),
               'post_type'          => $package->getSetting('post_type'),
               'keyword_limit'      => $package->getSetting('keyword_limit'),
               'keyword_page_limit' => $package->getSetting('keyword_page_limit'),
               'display_after'      => $package->getSetting('display_after'),
               'hide_after'         => $package->getSetting('hide_after'),
               'display_frequency'  => $package->getSetting('display_frequency'),
               'randomize_display'  => $package->getSetting('randomize_display')
          ];

          $this->settings          = array_replace_recursive($this->settings, $settings);
          $this->position          = $package->position;
          $this->user_criteria     = $package->user_criteria;
          $this->page_criteria     = $package->page_criteria;
          $this->position_criteria = $package->position_criteria;
          $this->inherit_package   = true;

          if (!$isPurchase)
          {
               if (!empty($package->settings['view_limit']))
               {
                    $this->view_limit = $package->settings['view_limit'];
               }

               if (!empty($package->settings['click_limit']))
               {
                    $this->click_limit = $package->settings['click_limit'];
               }

               $this->device_criteria = $package->device_criteria;
               $this->geo_criteria    = $package->geo_criteria;
          }
     }
     public function isInCarousel($adCount = 1)
     {
          return $this->Package && $this->Package->isCarousel($adCount);
     }
     public function isPurchase()
     {
          return $this->Extra && $this->Extra->purchase > 0;
     }
     public function matchesUserCriteria(\XF\Entity\User $visitor = null)
     {
          $visitor = $visitor ?: \XF::visitor();

          if ($this->settings['hide_from_robots'] && $this->app()->request()->getRobotName())
          {
               return false;
          }

          if ($this->app()->criteria('XF:User', $this->user_criteria)->isMatched($visitor))
          {
               return true;
          }
     }
     public function matchesPageCriteria(array $pageState)
     {
          $visitor = \XF::visitor();

          if ($this->app()->criteria('XF:Page', $this->page_criteria, $pageState)->isMatched($visitor))
          {
               return true;
          }
     }
     public function matchesPositionCriteria(array $positionParams, $isFilterAd = false)
     {
          $visitor = \XF::visitor();
          $options = \XF::options();

          $nodeIdNot       = $options->siropuAdsManagerNodeIdNot;
          $threadIdNot     = $options->siropuAdsManagerThreadIdNot;
          $threadPrefixNot = $options->siropuAdsManagerThreadPrefixNot;

          if ($nodeIdNot)
          {
               if (isset($positionParams['forum']['node_id']))
               {
                    $nodeId = $positionParams['forum']['node_id'];
               }
               else if (isset($positionParams['page']['node_id']))
               {
                    $nodeId = $positionParams['page']['node_id'];
               }
               else if (isset($positionParams['thread']['node_id']))
               {
                    $nodeId = $positionParams['thread']['node_id'];
               }
               else
               {
                    $nodeId = null;
               }

               if ($nodeId && in_array($nodeId, \Siropu\AdsManager\Util\Arr::getItemArray($nodeIdNot)))
               {
                    return false;
               }
          }

          if ($threadIdNot
               && isset($positionParams['thread']['thread_id'])
               && in_array($positionParams['thread']['thread_id'], \Siropu\AdsManager\Util\Arr::getItemArray($threadIdNot)))
          {
               return false;
          }

          if ($threadPrefixNot
               && isset($positionParams['thread']['prefix_id'])
               && in_array($positionParams['thread']['prefix_id'], $threadPrefixNot))
          {
               return false;
          }

          $positionParams['ad'] = $this;

          if ($isFilterAd)
          {
               unset($positionParams['post']);
          }

          if (empty($this->position_criteria))
          {
               return true;
          }

          return $this->app()->criteria('Siropu\AdsManager:Position', $this->position_criteria, $positionParams)->isMatched($visitor);
     }
     public function matchesDeviceCriteria()
     {
          $visitor = \XF::visitor();

          if (empty($this->device_criteria))
          {
               return true;
          }

          return $this->app()->criteria('Siropu\AdsManager:Device', $this->device_criteria)->isMatched($visitor);
     }
     public function matchesGeoCriteria()
     {
          $visitor = \XF::visitor();

          if (empty($this->geo_criteria))
          {
               return true;
          }

          return $this->app()->criteria('Siropu\AdsManager:Geo', $this->geo_criteria)->isMatched($visitor);
     }
     public function canDisplay()
     {
          if ($this->isIpBlocked())
          {
               return false;
          }

          $displayFrequency = !empty($this->settings['display_frequency']) ? $this->settings['display_frequency'] : false;

          if ($displayFrequency)
          {
               $viewdAds = json_decode($this->app()->request()->getCookie('sam_viewed'), true);

               if (isset($viewdAds[$this->ad_id]) && $viewdAds[$this->ad_id] >= \XF::$time - $displayFrequency * 60)
               {
                    return false;
               }
          }

          if ($this->Package
               && $this->Package->placeholder_id == $this->ad_id
               && !$this->Package->isValidAdvertiser()
               && !$this->Package->settings['use_backup_ad'])
          {
               return false;
          }

          if ($this->getDailyImpressionDistribution()
               && $this->daily_view_limit == 0
               && $this->user_id != \XF::visitor()->user_id)
          {
               return false;
          }

          return true;
     }
     public function isIpBlocked()
     {
          if (!$this->isOfType(['code', 'banner']))
          {
               return;
          }

          $clickFraud = $this->getSetting('click_fraud', []);
          $blockTime  = $clickFraud['block_time'];

          if (!($this->isClickFraudEnabled() && $blockTime))
          {
               return;
          }

          $clickFraudRepo = $this->repository('Siropu\AdsManager:ClickFraud');
          $ip             = $clickFraudRepo->getBinaryIp();

          if (\XF::options()->siropuAdsManagerClickFraudGlobalBlock && $clickFraudRepo->isIpBlocked($ip))
          {
               return true;
          }

          $blockedIp = $this->em()->findOne('Siropu\AdsManager:ClickFraud', ['ad_id' => $this->ad_id, 'ip' => $ip]);

          if ($blockedIp
               && $blockedIp->click_count >= $clickFraud['click_limit']
               && $blockedIp->log_date >= \XF::$time - $blockTime * 3600)
          {
               return true;
          }
     }
     public function isClickFraudEnabled()
     {
          return !empty($this->settings['click_fraud']['enabled']);
     }
     public function isAboutToExpire()
     {
          if ($this->Package)
          {
               $purchase = $this->Extra->purchase;
               $daysLeft = $this->end_date ? ceil(($this->end_date - \XF::$time) / 86400) : 0;

               switch ($this->Package->cost_per)
               {
                    case '':
                         return;
                         break;
                    case 'day':
                         $days = $purchase * 1;
                    case 'week':
                         $days = $purchase * 7;
                         break;
                    case 'month':
                         $days = $purchase * 30;
                         break;
                    case 'year':
                         $days = $purchase * 365;
                         break;
                    case 'cpm':
                         if ($this->view_limit && ($this->view_count * 100 / $this->view_limit) >= 70)
                         {
                              return true;
                         }
                         break;
                    case 'cpc':
                         if ($this->click_limit && ($this->click_count * 100 / $this->click_limit) >= 70)
                         {
                              return true;
                         }
                         break;
               }

               if ($daysLeft == 3 && $days > 1)
               {
                    return true;
               }
          }
     }
     public function hasExpired()
     {
          if ($this->view_limit && $this->view_count >= $this->view_limit)
          {
               return true;
          }

          if ($this->click_limit && $this->click_count >= $this->click_limit)
          {
               return true;
          }

          if ($this->end_date && $this->end_date <= \XF::$time)
          {
               return true;
          }
     }
     public function isActive()
     {
          return $this->status == 'active';
     }
     public function isInactive()
     {
          return $this->status == 'inactive';
     }
     public function isPaused()
     {
          return $this->status == 'paused';
     }
     public function isPending()
     {
          return $this->status == 'pending';
     }
     public function isApproved()
     {
          return $this->status == 'approved';
     }
     public function isQueued()
     {
          return $this->status == 'queued';
     }
     public function isRejected()
     {
          return $this->status == 'rejected';
     }
     public function isArchived()
     {
          return $this->status == 'archived';
     }
     public function isQueuedInvoice()
     {
          return $this->status == 'queued_invoice';
     }
     public function isOfStatus(array $status)
     {
          return in_array($this->status, $status);
     }
     public function isPlaceholder()
     {
          return $this->Extra->is_placeholder == 1;
     }
     public function isPendingApproval()
     {
          return $this->isPending() && $this->Extra->purchase > 0;
     }
     public function isFlash($file)
     {
          return stripos($file, '.swf') !== false;
     }
     public function isMp4($file)
     {
          return stripos($file, '.mp4') !== false;
     }
     public function hasBanner()
     {
          return ($this->banner_file || $this->banner_url || $this->content_2);
     }
     public function hasMultipleImages()
     {
          $files = $this->banner_file ?: $this->banner_url;
          return count($files) > 1;
     }
     public function hasXfSyntax($content)
     {
          return preg_match('/<xf:|{\$.+?}|{{ [a-zA-Z0-9_]+\(.*?\) }}/', $content);
     }
     public function requiresJs()
     {
          return $this->settings['count_views']
               || $this->settings['count_clicks']
               || $this->settings['hide_after']
               || $this->settings['display_after']
               || $this->settings['display_frequency']
               || $this->settings['hide_affiliate']
               || $this->getSetting('lazyload')
               || $this->isClickFraudEnabled();
     }
     public function canUseXfSyntax()
     {
          return $this->isOfType(['code', 'banner', 'text', 'popup']);
     }
     public function canViewStats()
     {
          $visitor = \XF::visitor();

          return ($this->settings['count_views'] || $this->settings['count_clicks'])
               && ($visitor->canViewGeneralStatsSiropuAdsManager()
                    || $this->canViewDailyStatsSiropuAdsManager()
                    || $this->canViewClickStatsSiropuAdsManager());
     }
     public function getSetting($key, $default = 0)
     {
          return $this->settings[$key] ?? $default;
     }
     public function getAttributes($position = '', $carousel = false)
     {
          $attr = '';

          $options = \XF::options();

          if ($this->isOfType(['keyword', 'affiliate', 'background']))
          {
               $attr .= $this->getLinkAttributes();
          }

          $cssClass = $options->siropuAdsManagerSamItemCssClass;

          if ($carousel)
          {
                $cssClass .= ' swiper-slide';
          }

          if ($this->isOfType(['keyword', 'affiliate']))
          {
               $cssClass .= ' link link--external';
          }

          if ($this->isText() && $this->hasBanner())
          {
               $cssClass .= ' samItemBanner';
          }

          if ($this->isBackground())
          {
               $cssClass .= ' samBackgroundItem';
          }

          if ($this->getSetting('css_class'))
          {
               $cssClass .= " {$this->settings['css_class']}";
          }

          if ($this->getSetting('lazyload'))
          {
               $cssClass .= ' samLazyLoading';
          }

          $attr .= ($attr ? ' ' : '') . 'class="' . $cssClass . '"';

          if ($this->requiresJs())
          {
               $attr .= ' data-xf-init="sam-item"';
               $attr .= ' data-id="' . $this->ad_id . '"';
          }

          if ($this->isClickFraudEnabled())
          {
               if (strpos($attr, 'data-xf-init') === false)
               {
                    $attr .= ' data-xf-init="sam-monitor"';
               }
               else
               {
                    $attr = preg_replace('/sam-[^\s"]+/', "$0 sam-monitor", $attr, 1);
               }

               $attr .= ' data-cl="' . $this->settings['click_fraud']['click_limit'] . '"';
          }

          $statsTracker = \XF::service('Siropu\AdsManager:Stats\Tracker', $this);

          if ($this->settings['count_views'] && !$statsTracker->isViewed())
          {
               $attr .= ' data-cv="true"';
          }

          if ($this->settings['count_clicks'] && !$statsTracker->isClicked())
          {
               $attr .= ' data-cc="true"';
          }

          if ($position != 'advertisers')
          {
               if (!$this->isPopup())
               {
                    if ($this->settings['hide_after'])
                    {
                         $attr .= ' data-ha="' . $this->settings['hide_after'] . '"';
                    }

                    if ($this->settings['display_after'])
                    {
                         $attr .= ' data-da="' . $this->settings['display_after'] . '"';

                         if (!$this->isOfType(['popup', 'background']))
                         {
                              $attr .= ' style="display: none;"';
                         }
                    }
               }

               if ($this->settings['display_frequency'])
               {
                    $attr .= ' data-df="true"';
               }
          }

          if ($this->isKeyword())
          {
               if ($this->title)
               {
                    if ($this->getSetting('tooltip_title'))
                    {
                         if (strpos($attr, 'data-xf-init') === false)
                         {
                              $attr .= ' data-xf-init="tooltip"';
                         }
                         else
                         {
                              $attr = preg_replace('/sam-[^\s"]+/', "$0 tooltip", $attr, 1);
                         }
                    }

                    $attr .= ' title="' . $this->forAttr($this->title) . '"';
               }
          }

          if ($this->settings['ga_stats'] && !($this->settings['count_views'] || $this->settings['count_clicks']))
          {
               if (strpos($attr, 'data-xf-init') === false)
               {
                    $attr .= ' data-xf-init="sam-ga"';
               }
               else
               {
                    $attr = preg_replace('/tooltip|sam-[^\s"]+/', "$0 sam-ga", $attr, 1);
               }

               $gaParams = [
                    'name'     => $this->name,
                    'type'     => $this->getTypePhrase()->render(),
                    'position' => $this->getPositionRepo()->getDynamicPosition($position)['title']
               ];

               $attr .= " data-ga='" . json_encode($gaParams) . "'";
          }

          if ($this->isOfType(['affiliate', 'keyword']))
          {
               $attr .= ' data-position="' . $position . '"';
          }
          else if ($this->isJavaScript())
          {
               $attr .= ' data-position="javascript"';
          }

          if ($this->settings['inline_style'])
          {
               if (strpos($attr, 'style=') !== false)
               {
                    $attr = preg_replace('/style="([^"]+)"/', "style=\"$1 {$this->settings['inline_style']}\"", $attr);
               }
               else
               {
                    $attr .= ' style="' . $this->settings['inline_style'] . '"';
               }
          }

          if ($this->settings['overlay'])
          {
               $attr .= ' data-xf-click="overlay"';
          }

          if ($this->getSetting('lazyload'))
          {
               $attr .= ' data-ll="true"';

               if ($refresh = $this->getSetting('refresh'))
               {
                    $attr .= ' data-rf="' . ($refresh * 1000) . '"';
               }
          }

          if ($this->hasBackup())
          {
               $attr .= ' data-ba="' . $this->ad_id . '"';
          }

          return $attr;
     }
     public function hasBackup()
     {
          $code = $this->content_1 ?: $this->content_2;
          return $this->isOfType(['code', 'banner']) && $this->content_3 && strpos($code, 'adsbygoogle') !== false;
     }
     public function getLinkAttributes()
     {
          $attr = '';

          if ($this->target_url || $this->isAffiliate())
          {
               if (!$this->isAffiliate())
               {
                    $attr = ' href="' . $this->target_url . '"';
               }

               if ($this->settings['target_blank'])
               {
                    $attr .= ' target="_blank"';
               }

               $relAttribute = $this->getSetting('rel');

               if (empty($relAttribute) && $this->settings['nofollow'])
               {
                    $relAttribute = 'nofollow';
               }

               switch ($relAttribute)
               {
                    case 'nofollow':
                         $attr .= ' rel="nofollow"';
                         break;
                    case 'sponsored':
                         $attr .= ' rel="sponsored"';
                         break;
                    case 'ugc':
                         $attr .= ' rel="ugc"';
                         break;
                    default:
                         if (!empty($this->settings['rel_custom']))
                         {
                              $attr .= ' rel="' . $this->settings['rel_custom'] . '"';
                         }
                         break;
               }
          }

          if ($this->settings['click_stats'] && $this->isOfType(['banner', 'text', 'background']) && $this->hasMultipleImages())
          {
               $attr .= ' data-multiple="true"';
          }

          return $attr;
     }
     public function getPopupContent()
     {
          if ($this->MasterTemplate)
          {
               return $this->renderTemplate();
          }

          return json_encode(nl2br($this->applyLinkAttributes($this->content_1)));
     }
     public function getBackgroundData()
     {
          return json_encode([
               'id'  => $this->ad_id,
               'bg'  => $this->banner,
               'url' => $this->target_url,
               'cv'  => $this->settings['count_views'],
               'cc'  => $this->settings['count_clicks'],
               'da'  => $this->settings['display_after'],
               'ha'  => $this->settings['hide_after']
          ]);
     }
     public function getWidthHeight()
     {
          if ($this->Package && $this->Package->settings['unit_size'])
          {
               $size = $this->Package->getUnitSizeArray();
          }
          else
          {
               $size = $this->getUnitSizeArray();
          }

          if ($size)
          {
               return 'width="' . $size['width'] . '" height="' . $size['height'] . '"';
          }
     }
     public function getBanner()
     {
          $bannerList = $this->banner_file ?: $this->banner_url;
          shuffle($bannerList);
          $banner = (string) $bannerList[0];

          return (stripos($banner, 'http') === false ? $this->getAbsoluteFilePath($banner) : $banner);
     }
     public function getBanners()
     {
          $bannerList = $this->banner_file ?: $this->banner_url;
          $banners    = [];

          foreach ($bannerList as $banner)
          {
               $banners[] = (stripos($banner, 'http') === false ? $this->getAbsoluteFilePath($banner) : $banner);
          }

          return $banners;
     }
     public function getCode($position = '')
     {
          $code = $this->content_1 ?: $this->content_2;

          if (strpos($position, 'no_wrapper_') !== false && $this->canCountViews())
          {
               return str_ireplace('<script', '<script data-id="' . $this->ad_id . '" data-position="' . $position . '"', $code);
          }

          if ($this->MasterTemplate)
          {
               return $this->renderTemplate([
                    'positionId'     => $position,
                    'positionNumber' => preg_replace('/[^0-9]+/', '', $position)
               ]);
          }

          return $this->applyLinkAttributes($code);
     }
     public function getDescription()
     {
          if ($this->MasterTemplate)
          {
               return $this->renderTemplate();
          }

          return $this->content_1;
     }
     public function getBackup()
     {
          $backup = $this->applyLinkAttributes($this->content_3);

          if ($this->getSetting('lazyload'))
          {
               return $backup;
          }

          return preg_replace('/[^-]src="(.*?)"/ui', ' data-src="$1"', $backup);
     }
     public function getKeywordRegExp($keyword = '')
     {
          $keywords = $this->getKeywordsForRegex($keyword);

          if (preg_match('/[^\w\s]/us', ($keyword ?: $this->content_1)))
          {
               $regExp = '(?<!\w)(' . $keywords . ')(?!\w)';
          }
          else
          {
               $regExp = '\b(' . $keywords . ')\b(?!\.(com|net|org|us|co|ca|uk|au|fr|de|es|nl|se|ch|ro|ru|tv|info|edu|gov)(\s|$|<))';
          }

          $caseSensitive = $this->getSetting('case_sensitive');

          return '/(<(img|div|iframe|i|span|pre|abbr|amp|blockquote)[^>]*>|<a.*?a>|<code.*?code>)(*SKIP)(*FAIL)|' . $regExp . '/us' . ($caseSensitive ? '' : 'i');
     }
     public function getKeywordsForRegex($keyword = '')
     {
          return \Siropu\AdsManager\Util\Arr::getItemsForRegex($keyword ?: $this->content_1);
     }
     public function deleteFile($file)
     {
          $bannerFile = $this->banner_file;
          $arrayKey   = array_search($file, $bannerFile);

          if ($arrayKey !== false)
          {
               \XF\Util\File::deleteFromAbstractedPath("data://{$this->getBannerDirName()}/{$file}");

               unset($bannerFile[$arrayKey]);
          }

          $this->banner_file = $bannerFile;
     }
     public function getInvoiceCount($status = null)
     {
          return $this->getInvoiceRepo()->getAdInvoiceCount($this->ad_id, $status);
     }
     public function isPostType($type)
     {
          return !empty($this->settings['post_type'][$type]);
     }
     public function getKeywords()
     {
          return \Siropu\AdsManager\Util\Arr::getItemArray($this->content_1, false, "\n");
     }
     public function getCost($purchase = 0, $extend = false)
     {
          if (!$this->Package)
          {
               return;
          }

          $costAmount = $this->Package->cost_amount;
          $costCustom = $this->Package->cost_custom;
          $costExtra  = 0;

          switch ($this->type)
          {
               case 'thread':
                    $nodeId = $this->content_1;

                    if (isset($costCustom[$nodeId]))
                    {
                         $costAmount = $costCustom[$nodeId];
                    }

                    if ($this->Package->cost_sticky && $this->Extra && $this->Extra->is_sticky)
                    {
                         $costExtra += $this->Package->cost_sticky;
                    }
                    break;
               case 'sticky':
                    $nodeId = $this->Thread->node_id;

                    if (isset($costCustom[$nodeId]))
                    {
                         $costAmount = $costCustom[$nodeId];
                    }
                    break;
               case 'resource':
                    $resourceCategoryId = $this->Resource->resource_category_id;

                    if (isset($costCustom[$resourceCategoryId]))
                    {
                         $costAmount = $costCustom[$resourceCategoryId];
                    }
                    break;
               case 'keyword':
                    $keywords     = $this->getKeywords();
                    $keywordCount = count($keywords);

                    $isCpcOrCpm   = in_array($this->Package->cost_per, ['cpc', 'cpm']);

                    if (!empty($costCustom))
                    {
                         $customCost   = 0;
                         $premiumCount = 0;

                         foreach ($costCustom as $key => $val)
                         {
                              foreach ($keywords as $keyword)
                              {
                                   if (preg_match("/\b{$key}\b/i", $keyword))
                                   {
                                        $customCost += floatval($val);
                                        $premiumCount++;
                                   }
                              }
                         }

                         if ($default = ($keywordCount - $premiumCount))
                         {
                              $costAmount = $customCost + ($isCpcOrCpm ? $costAmount : ($default * $costAmount));
                         }
                         else
                         {
                              $costAmount = $customCost;
                         }
                    }
                    else
                    {
                         $costAmount = $isCpcOrCpm ? $costAmount : ($keywordCount * $costAmount);
                    }

                    if ($this->Package->cost_exclusive && $this->Extra && $this->Extra->exclusive_use)
                    {
                         $costExtra += $keywordCount * $this->Package->cost_exclusive;
                    }
                    break;
          }

          $purchase        = $purchase ?: ($this->Extra->purchase ?? $this->Package->min_purchase);
          $discountPercent = 0;

          if (!empty($this->Package->discount))
          {
               foreach ($this->Package->getDiscountSorted() as $key => $val)
               {
                    if ($purchase >= $key)
				{
					$discountPercent = intval($val);
				}
               }
          }

          $totalCost      = $costAmount * ($this->Package->isCpm() ? $purchase / 1000 : $purchase) + $costExtra;
          $discountAmount = $discountPercent ? ($totalCost * $discountPercent) / 100 : 0;
          $costDiscounted = max(0, $totalCost - $discountAmount);

          if ($extend == false && $this->Extra && $this->Extra->promo_code)
          {
               $promoCode = $this->Extra->PromoCode;

               if ($promoCode)
               {
                    switch ($promoCode->type)
                    {
                         case 'percent':
                              $discountPercent = $promoCode->value;
                              break;
                         case 'amount':
                              $discountPercent = ($promoCode->value / $costDiscounted) * 100;
                              break;
                    }

                    $discountAmount += ($costDiscounted * $discountPercent) / 100;
                    $costDiscounted = max(0, $totalCost - $discountAmount);
               }
          }

          return [
               'totalCost'       => $totalCost,
               'costDiscounted'  => $costDiscounted,
               'discountAmount'  => $discountAmount,
               'discountPercent' => $costDiscounted ? number_format(($discountAmount / $totalCost) * 100, 2) : 100
          ];
     }
     public function getCustomCost()
     {
          $costAmount = $this->Package->cost_amount;
          $costCustom = $this->Package->cost_custom;

          switch ($this->type)
          {
               case 'thread':
                    $key = $this->content_1;
                    break;
               case 'sticky':
                    $key = $this->Thread->node_id;
                    break;
               case 'resource':
                    $key = $this->Resource->resource_category_id;
                    break;
               default:
                    $key = 0;
                    break;
          }

          if ($this->isOfType(['thread', 'sticky', 'resource']) && isset($costCustom[$key]))
          {
               $costAmount = $costCustom[$key];
          }

          return $costAmount;
     }
     public function isFree()
     {
          $cost = $this->getCost();

          if ($cost['totalCost'] == 0 || $cost['costDiscounted'] == 0)
          {
               return true;
          }
     }
     public function approve()
     {
          $this->status = 'approved';
          $this->save();

          $this->generateInvoice();
     }
     public function queueAndInvoice()
     {
          $this->status = 'queued_invoice';
          $this->save();

          $this->generateInvoice();
     }
     public function queue()
     {
          $this->status = 'queued';
          $this->save();
     }
     public function activate()
     {
          if (!$this->Package)
          {
               return;
          }

          $costPer  = $this->Package->cost_per;
          $purchase = $this->Extra->purchase;

          switch ($costPer)
          {
               case '':
                    break;
               case 'cpm':
                    $this->view_limit += $purchase;
                    break;
               case 'cpc':
                    $this->click_limit += $purchase;
                    break;
               default:
                    $timeLeft = $this->end_date > \XF::$time ? $this->end_date - \XF::$time : 0;
                    $this->end_date = strtotime("+$purchase $costPer") + $timeLeft;
                    break;
          }

          $this->status = 'active';
          $this->save();
     }
     public function deactivate()
     {
          $this->start_date = 0;
          $this->end_date = 0;
          $this->view_limit = 0;
          $this->click_limit = 0;
          $this->daily_view_limit = 0;
          $this->status = 'inactive';
          $this->save();

          $this->setOption('process_queue', true);
     }
     public function generateInvoice()
     {
          $invoice = \XF::service('Siropu\AdsManager:Invoice\Manager', $this);
          $invoice->generate();

          return $invoice->getInvoice();
     }
     public function updateEndDate()
     {
          $lastActive   = $this->Extra->last_active;
          $inactiveTime = $lastActive ? \XF::$time - $lastActive : 0;

          $this->end_date = $this->end_date ? $this->end_date + $inactiveTime : 0;
     }
     public function updateExtraData(array $data = [])
     {
          $this->getBehavior('Siropu\AdsManager:ExtraUpdatable')->setOption('data', $data);
     }
     public function getBreadcrumbs($includeSelf = true)
	{
          $breadcrumbs = [
               [
                    'href'  => $this->app()->router()->buildLink('ads-manager/ads'),
                    'value' => \XF::phrase('siropu_ads_manager_ads')
               ]
          ];

          if ($includeSelf)
          {
               $breadcrumbs[] = [
				'href'  => $this->app()->router()->buildLink('ads-manager/ads/edit', $this),
				'value' => $this->name
			];
          }

          return $breadcrumbs;
     }
     public function isCallback()
     {
          return strpos($this->content_1, 'callback=') === 0;
     }
     public function getCallback()
     {
          if (preg_match('/^callback=(.+)/i', $this->content_1, $match))
          {
               return @call_user_func_array($match[1], [$this, $this->getCallbackArgs()]);
          }
     }
     public function getCallbackArgs()
     {
          $args = [];

          if (preg_match('/arguments=(.+)/', $this->content_1, $match) && json_decode($match[1]))
          {
               $args = json_decode($match[1], true);
          }

          return $args;
     }
     public function getTemplateName()
	{
		return '_siropu_ads_manager_ad_code.' . $this->ad_id;
	}
	public function getMasterTemplate()
	{
		$template = $this->MasterTemplate;

		if (!$template)
		{
			$template = $this->_em->create('XF:Template');
			$template->title = $this->_getDeferredValue(function() { return $this->getTemplateName(); }, 'save');
			$template->type = 'public';
			$template->style_id = 0;
		}

		return $template;
	}
     public function getEmailInlineStyle()
     {
          $inlineStyle = $this->settings['inline_style'];

          if (strpos($inlineStyle, 'width') === false)
          {
               $inlineStyle .= 'width:100%;';
          }

          switch ($this->settings['unit_alignment'])
          {
               case 'left':
                    $inlineStyle .= 'text-align:left;';
                    break;
               case 'right':
                    $inlineStyle .= 'text-align:right;margin:0 0 0 auto;';
                    break;
               case 'center':
                    $inlineStyle .= 'text-align:center;margin:0 auto;';
                    break;
          }

          return $inlineStyle;
     }
     public function renderTemplate($params = [])
     {
          return @$this->app()->templater()->renderTemplate('public:' . $this->getTemplateName(), $params);
     }
     public function applyLinkAttributes($code)
     {
          $relAttribute = $this->getSetting('rel');
          $targetBlank  = $this->settings['target_blank'];

          if (empty($relAttribute) && $this->settings['nofollow'])
          {
               $relAttribute = 'nofollow';
          }

          if (($relAttribute != 'none' || $targetBlank) && preg_match_all('#<a (.+?)>.+?</a>#is', $code, $matches, PREG_SET_ORDER))
          {
               foreach ($matches as $match)
               {
                    $attr = '';

                    if ($relAttribute == 'nofollow' && stripos($match[1], 'rel="') === false)
                    {
                         $attr .= ' rel="nofollow"';
                    }
                    else if ($relAttribute == 'sponsored' && stripos($match[1], 'rel="') === false)
                    {
                         $attr .= ' rel="sponsored"';
                    }
                    else if ($relAttribute == 'ugc' && stripos($match[1], 'rel="') === false)
                    {
                         $attr .= ' rel="sponsored"';
                    }
                    else if (!empty($this->settings['rel_custom']) && stripos($match[1], 'rel="') === false)
                    {
                         $attr .= ' rel="' . $this->settings['rel_custom'] . '"';
                    }

                    if ($targetBlank && stripos($match[1], 'target="_blank"') === false)
                    {
                         $attr .= ' target="_blank"';
                    }

                    if ($attr)
                    {
                         $code = preg_replace('/' . preg_quote($match[1], '/') . '/', "$0$attr", $code);
                    }
               }
          }

          if ($this->getSetting('lazyload_image') && strpos($code, '<img') !== false)
          {
               preg_match_all('#<img[^>]*>#is', $code, $matches, PREG_SET_ORDER);

               foreach ($matches as $match)
               {
                    $code = str_replace($match[0], str_ireplace('src', 'data-xf-init="sam-lazy" data-src', $match[0]), $code);
               }
          }

          return $code;
     }
     public function getItemId($string = false)
     {
          $posCriteria = \XF::app()->criteria('Siropu\AdsManager:Position', $this->position_criteria)->getCriteriaForTemplate();
          $itemId      = !empty($posCriteria['item_id']['id']) ? $posCriteria['item_id']['id'] : null;

          if ($string)
          {
               return $itemId;
          }
          else
          {
               return \Siropu\AdsManager\Util\Arr::getItemArray($itemId, true);
          }
     }
     public function getDailyImpressionDistribution()
     {
          if ($this->Package && ($impressionDistributionDays = $this->Package->getImpressionDistributionDays()))
          {
               return $this->view_limit ? round($this->view_limit / $impressionDistributionDays) : 0;
          }
     }
     public function setDailyViewLimit()
     {
          $dailyViewLimit = $this->getDailyImpressionDistribution();

          if ($dailyViewLimit && $this->daily_view_limit == 0)
          {
               $this->daily_view_limit = $dailyViewLimit;
          }
     }
     public function getPosition()
     {
          $randomize = $this->getSetting('randomize_display');

          if ($randomize)
          {
               $position = $this->position;
               shuffle($position);

               return array_slice($position, 0, $randomize);
          }

          return $this->position;
     }
     public function getAffiliateLinkFormPhrase()
     {
          switch ($this->content_2)
          {
               default:
               case 'to_aff':
                    $phrases = [
                         'description' => 'siropu_ads_manager_append_parameter_to_affiliate_website_explain',
                         'label'       => 'siropu_ads_manager_parameter'
                    ];
                    break;
               case 'aff_to':
                    $phrases = [
                         'description' => 'siropu_ads_manager_append_affiliate_website_to_url_explain',
                         'label'       => 'url'
                    ];
                    break;
               case 'replace':
                    $phrases = [
                         'description' => 'siropu_ads_manager_replace_affiliate_website_with_url_explain',
                         'label'       => 'url'
                    ];
                    break;
               case 'params':
                    $phrases = [
                         'description' => 'siropu_ads_manager_replace_params_in_affiliate_url_explain',
                         'label'       => 'siropu_ads_manager_parameters'
                    ];
                    break;
               case 'callback':
                    $phrases = [
                         'description' => 'siropu_ads_manager_use_callback_to_build_affiliate_url_explain',
                         'label'       => 'callback'
                    ];
                    break;
          }

          $data = [];

          foreach ($phrases as $key => $phrase)
          {
               $data[$key] = \XF::phrase($phrase)->render();
          }

          return $data;
     }
     public function getAffiliateLinkParams()
     {
          return (array) @json_decode($this->content_4, true);
     }
     public function hydrateExtraRelation($with = null)
     {
          $this->hydrateRelation('Extra', $this->em()->find('Siropu\AdsManager:AdExtra', $this->ad_id, $with));
     }
     public function getBannerDirName()
     {
          return \XF::options()->siropuAdsManagerBannerDirName ?: 'siropu/am/user';
     }
     public function getAbsoluteFilePath($file)
     {
          return $this->app()->applyExternalDataUrl("{$this->getBannerDirName()}/{$file}", true);
     }
     public function forAttr($value)
     {
          return htmlspecialchars(str_replace('$', '&#36;', $value), ENT_QUOTES, 'UTF-8', false);
     }
     protected function toggleSticky($sticky, $threadId = 0)
     {
          $toggler = \XF::service('Siropu\AdsManager:Ad\Toggler', $this, $threadId);
          $toggler->toggleSticky($sticky);
     }
     protected function toggleFeatured($featured, $resourceId = 0)
     {
          $toggler = \XF::service('Siropu\AdsManager:Ad\Toggler', $this, $resourceId);
          $toggler->toggleFeatured($featured);
     }
     protected function verifyBannerUrl(&$url)
     {
          $url = array_filter($url);
          return true;
     }
     protected function verifySettings(&$settings)
     {
          if (!empty($settings['daily_stats']))
          {
               $settings['count_views']  = 1;
               $settings['count_clicks'] = 1;
          }

          if (!empty($settings['click_stats']))
          {
               $settings['count_clicks'] = 1;
          }

          $settings = array_replace_recursive([
               'no_wrapper'         => 0,
               'count_views'        => 0,
               'count_clicks'       => 0,
               'daily_stats'        => 0,
               'click_stats'        => 0,
               'ga_stats'           => 0,
               'nofollow'           => 0,
               'rel'                => 'nofollow',
               'rel_custom'         => '',
               'target_blank'       => 0,
               'hide_from_robots'   => 0,
               'hide_close_button'  => 0,
               'case_sensitive'     => 0,
               'post_type'          => [
                    'thread'              => 0,
                    'thread_poll'         => 0,
                    'thread_article'      => 0,
                    'thread_question'     => 0,
                    'thread_suggestion'   => 0,
                    'conversation'        => 0,
                    'profile'             => 0,
                    'resource'            => 0,
                    'chat'                => 0,
                    'chat_conv'           => 0,
                    'ams_article'         => 0,
                    'showcase_item'       => 0,
                    'dbtech_product_desc' => 0,
                    'dbtech_product_spec' => 0
               ],
               'keyword_limit'      => 0,
               'keyword_page_limit' => 0,
               'display_after'      => 0,
               'hide_after'         => 0,
               'display_frequency'  => 0,
               'inline_style'       => '',
               'css_class'          => '',
               'unit_alignment'     => '',
               'unit_size'          => '',
               'tooltip_title'      => '',
               'overlay'            => '',
               'hide_affiliate'     => 0,
               'click_fraud'        => ['enabled' => 0, 'click_limit' => 2, 'block_time' => 0],
               'randomize_display'  => 0,
               'lazyload_image'     => 0,
               'lazyload'           => 0,
               'refresh'            => 0
          ], $settings);

          return true;
     }
     protected function verifyItemArray(&$itemArray)
     {
          if ($this->isKeyword())
          {
               foreach ($itemArray as $key => $item)
               {
                    if (empty(trim($item['keyword'])) || empty(trim($item['url'])))
                    {
                         unset($itemArray[$key]);
                    }
               }

               array_values($itemArray);
          }
          else
          {
               $itemArray = array_filter(array_map('trim', $itemArray));
          }

          return true;
     }
     protected function _preSave()
     {
          if ($this->isInsert() && $this->isThread() && !$this->Forum)
          {
               $this->error(\XF::phrase('siropu_ads_manager_please_select_forum'));
          }

          if ($this->isChanged(['view_count', 'click_count']))
          {
               if ($this->hasExpired())
               {
                    $this->end_date = 0;
                    $this->status = 'inactive';
                    $this->setOption('process_queue', true);
               }

               if ($this->view_count && $this->click_count)
               {
                    $this->ctr = min($this->click_count / $this->view_count * 100, 100);
               }
          }

          if ($this->isChanged('status') && $this->isActive())
          {
               $this->setDailyViewLimit();
          }
     }
     protected function _postSave()
     {
          if ($this->isInsert() && $this->isActive() || $this->isChanged(['item_id', 'status']))
          {
               $state      = $this->isActive() ? 1 : 0;
               $prevItemId = $this->getPreviousValue('item_id');

               if ($this->isSticky())
               {
                    $this->toggleSticky($state);

                    if ($this->isChanged('item_id') && $prevItemId)
                    {
                         $this->toggleSticky(0, $prevItemId);
                    }
               }
               else if ($this->isResource())
               {
                    $this->toggleFeatured($state);

                    if ($this->isChanged('item_id') && $prevItemId)
                    {
                         $this->toggleFeatured(0, $prevItemId);
                    }
               }
          }

          $prevPackageId = $this->getPreviousValue('package_id');

          if ($this->isChanged('package_id'))
          {
               if ($prevPackageId)
               {
                    $this->updatePackageCounters($prevPackageId);
               }

               if ($this->package_id)
               {
                    $this->updatePackageCounters($this->package_id);
               }
          }
          else if ($this->isChanged('status') && $this->package_id)
          {
               $this->updatePackageCounters($this->package_id);
          }

          $advertiserUserGroups = \XF::options()->siropuAdsManagerAdvertiserUserGroups;

          $userGroupKey = 'samAdvertiser';

          if ($this->Package && $this->Package->advertiser_user_groups)
          {
               $advertiserUserGroups = $this->Package->advertiser_user_groups;

               $userGroupKey = "{$userGroupKey}_{$this->package_id}";
          }

          if ($this->isChanged('status')
               && $this->isOfStatus(['active', 'inactive'])
               && $advertiserUserGroups
               && $this->isPurchase())
          {
               $userGroupChange = \XF::service('XF:User\UserGroupChange');

               $activeAdsFinder = $this->repository('Siropu\AdsManager:Ad')
                    ->findAdsForUser($this->user_id)
                    ->isPurchase()
                    ->active();

               if (strpos($userGroupKey, '_') !== false)
               {
                    $activeAdsFinder->forPackage($this->package_id);
               }

               $activeAds = $activeAdsFinder->total();

               if ($activeAds && !$this->User->isMemberOf($advertiserUserGroups))
               {
                    $userGroupChange->addUserGroupChange($this->user_id, $userGroupKey, $advertiserUserGroups);
               }
               else if (!$activeAds)
               {
                    $userGroupChange->removeUserGroupChange($this->user_id, $userGroupKey);
               }
          }

          if ($this->isChanged(['status', 'position']) && $this->isOfType(['code', 'banner', 'text', 'link']))
          {
               $this->getAdRepo()->updateMailAdCache();
          }
     }
     protected function _preDelete()
     {
          $this->status = 'inactive';
     }
     protected function _postDelete()
     {
          if ($this->isOfType(['banner', 'text']))
          {
               foreach ($this->banner_file as $banner)
               {
                    \XF\Util\File::deleteFromAbstractedPath("data://{$this->getBannerDirName()}/{$banner}");
               }
          }
          else if ($this->isSticky())
          {
               $this->toggleSticky(0);
          }
          else if ($this->isResource())
          {
               $this->toggleFeatured(0);
          }

          if ($this->package_id)
          {
               $this->updatePackageCounters($this->package_id);
          }

          if ($this->MasterTemplate)
		{
			$this->MasterTemplate->delete();
		}

          $this->repository('Siropu\AdsManager:DailyStats')->deleteAdStats($this->ad_id);
          $this->repository('Siropu\AdsManager:ClickStats')->deleteAdStats($this->ad_id);
          $this->repository('Siropu\AdsManager:ClickFraud')->deleteAdEntries($this->ad_id);

          $this->Extra->delete();

          $alertRepo = $this->repository('XF:UserAlert');
          $alertRepo->fastDeleteAlertsForContent('siropu_ads_manager_ad', $this->ad_id);
     }
     protected function updatePackageCounters($packageId)
     {
          $packageRepo = $this->getPackageRepo();

          $packageRepo->updateAdCount($packageId);
          $packageRepo->updateEmptySlotCount($packageId);
     }
}
