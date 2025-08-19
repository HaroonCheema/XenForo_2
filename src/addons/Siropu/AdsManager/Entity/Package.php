<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Package extends AbstractEntity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_package';
          $structure->shortName  = 'AdsManager:Package';
          $structure->primaryKey = 'package_id';

          $structure->columns = [
               'package_id'                => ['type' => self::UINT, 'autoIncrement' => true],
               'type'                      => ['type' => self::STR, 'default' => 'code'],
               'title'                     => ['type' => self::STR, 'maxLength' => 255, 'required' => 'please_enter_valid_title'],
               'description'               => ['type' => self::STR, 'default' => ''],
               'guidelines'                => ['type' => self::STR, 'default' => ''],
               'position'                  => ['type' => self::JSON_ARRAY, 'default' => []],
               'cost_amount'               => ['type' => self::FLOAT, 'default' => 0],
               'cost_custom'               => ['type' => self::JSON_ARRAY, 'default' => []],
               'cost_currency'             => ['type' => self::STR, 'default' => 'USD'],
               'cost_per'                  => ['type' => self::STR, 'default' => 'month', 'allowedValues' => ['', 'day', 'week', 'month', 'year', 'cpm', 'cpc']],
               'cost_exclusive'            => ['type' => self::FLOAT, 'default' => 0],
               'cost_sticky'               => ['type' => self::FLOAT, 'default' => 0],
               'min_purchase'              => ['type' => self::UINT, 'default' => 1],
               'max_purchase'              => ['type' => self::UINT, 'default' => 1],
               'discount'                  => ['type' => self::JSON_ARRAY, 'default' => []],
               'ad_allowed_limit'          => ['type' => self::UINT, 'default' => 1],
               'ad_display_limit'          => ['type' => self::UINT, 'default' => 1],
               'ad_display_order'          => ['type' => self::STR, 'default' => '', 'allowedValues' => ['', 'random', 'dateAsc', 'dateDesc', 'orderAsc', 'orderDesc',  'viewAsc', 'viewDesc', 'clickAsc', 'clickDesc', 'ctrAsc', 'ctrDesc']],
               'content'                   => ['type' => self::STR, 'default' => ''],
               'settings'                  => ['type' => self::JSON_ARRAY, 'default' => []],
               'position_criteria'         => ['type' => self::JSON_ARRAY, 'default' => []],
               'user_criteria'             => ['type' => self::JSON_ARRAY, 'default' => []],
               'page_criteria'             => ['type' => self::JSON_ARRAY, 'default' => []],
               'device_criteria'           => ['type' => self::JSON_ARRAY, 'default' => []],
               'geo_criteria'              => ['type' => self::JSON_ARRAY, 'default' => []],
               'advertiser_user_groups'    => ['type' => self::JSON_ARRAY, 'default' => []],
               'advertiser_criteria'       => ['type' => self::JSON_ARRAY, 'default' => []],
               'advertiser_purchase_limit' => ['type' => self::UINT, 'default' => 0],
               'preview'                   => ['type' => self::STR, 'maxLength' => 50, 'default' => ''],
               'advertise_here'            => ['type' => self::UINT, 'default' => 0],
               'display_order'             => ['type' => self::UINT, 'default' => 0],
               'placeholder_id'            => ['type' => self::UINT, 'default' => 0],
               'ad_count'                  => ['type' => self::UINT, 'default' => 0],
               'empty_slot_count'          => ['type' => self::UINT, 'default' => 0]
          ];

          $structure->getters   = [
               'carousel_settings' => false,
               'cost'              => false,
               'cost_per_phrase'   => false
          ];

          $structure->relations = [
               'Placeholder' => [
				'entity'     => 'Siropu\AdsManager:Ad',
				'type'       => self::TO_ONE,
                    'conditions' => [['ad_id', '=', '$placeholder_id']],
			],
               'Ads' => [
				'entity'     => 'Siropu\AdsManager:Ad',
				'type'       => self::TO_MANY,
				'conditions' => 'package_id',
				'key'        => 'ad_id'
			],
          ];

          return $structure;
     }
     public function getDiscountSorted()
     {
          $discount = $this->discount;
          ksort($discount);

          return $discount;
     }
     public function getSetting($key, $default = 0)
     {
          return isset($this->settings[$key]) ? $this->settings[$key] : $default;
     }
     public function getCarouselSetting($key, $default = 0)
     {
          return isset($this->settings['carousel'][$key]) ? $this->settings['carousel'][$key] : $default;
     }
     public function getPostLayoutSetting($key, $default = false)
     {
          return isset($this->settings['xf_post_layout'][$key]) ? $this->settings['xf_post_layout'][$key] : $default;
     }
     public function getAttributes($adCount = 1)
     {
          $cssClass = $this->getUnitCssClass();
          $carousel = $this->isCarousel($adCount);

          if ($carousel)
          {
               $cssClass .= ' samCarousel swiper-wrapper';
          }

          if ($this->settings['css_class'])
          {
               $cssClass .= " {$this->settings['css_class']}";
          }

          $attr = 'class="' . $cssClass . '"';

          if (!$carousel)
          {
               $attr .= $this->getUnitStyle();
          }

          $attr .= ' data-xf-init="sam-unit"';

          return $attr;
     }
     public function getUnitStyle()
     {
          $attr = '';

          if ($this->settings['unit_size'])
          {
               $attr .= $this->getUnitSize();
          }

          $unitStyle = $this->settings['unit_style'];

          if ($unitStyle)
          {
               if (strpos($attr, 'style=') !== false)
               {
                    $attr = preg_replace('/style="(.*?)"/', "style=\"$1 {$unitStyle}\"", $attr);
               }
               else
               {
                    $attr .= ' style="' . $unitStyle . '"';
               }
          }

          return $attr;
     }
     public function getCarouselSettings()
     {
          $carousel = $this->settings['carousel'];
          $settings = [];

          if ($carousel['itemsPerView'] > 1)
          {
               $settings['slidesPerView'] = $carousel['itemsPerView'];
               $settings['spaceBetween']  = 5;
          }

          if ($carousel['itemsPerColumn'] > 1)
          {
               $settings['slidesPerColumn'] = $carousel['itemsPerColumn'];
          }

          if ($carousel['itemsPerGroup'] > 1)
          {
               $settings['slidesPerGroup'] = $carousel['itemsPerGroup'];
          }

          if ($carousel['transitionSpeed'] != 300)
          {
               $settings['speed'] = $carousel['transitionSpeed'];
          }

          if ($carousel['autoplaySpeed'] >= 1)
          {
               $settings['autoplay'] = ['delay' => $carousel['autoplaySpeed'] * 1000];
          }

          if ($carousel['effect'] != 'slide')
          {
               $settings['effect'] = $carousel['effect'];
          }

          if ($carousel['direction'] != 'horizontal')
          {
               $settings['direction'] = $carousel['direction'];
          }

          if (!empty($carousel['breakpoints']))
          {
               foreach ($carousel['breakpoints'] as $key => $val)
               {
                    $settings['breakpoints'][$key]['slidesPerView'] = $val;
               }
          }

          return json_encode($settings, JSON_NUMERIC_CHECK);
     }
     public function isCarousel($adCount = 1)
     {
          $userDevice = $this->app()->container()['samUserDevice'];

          return ($this->ad_display_limit > 1
               && $adCount > 1
               && !empty($this->settings['carousel']['enabled'])
               && !empty($this->settings['carousel']['device'][$userDevice]));
     }
     public function hasPlaceholder()
     {
          return $this->placeholder_id != 0;
     }
     public function hasPurchaseLimit()
     {
          return $this->advertiser_purchase_limit > 0;
     }
     public function isCpm()
     {
          return $this->cost_per == 'cpm';
     }
     public function isCpc()
     {
          return $this->cost_per == 'cpc';
     }
     public function isCostPer(array $costPer = [])
     {
          return in_array($this->cost_per, $costPer);
     }
     public function isValidAdvertiser()
     {
          $visitor = \XF::visitor();

          $advertiserCriteria = $this->app()->criteria('Siropu\AdsManager:Advertiser', $this->advertiser_criteria);
          $advertiserCriteria->setMatchOnEmpty(false);

          return $advertiserCriteria->isMatched($visitor);
     }
     public function isFree()
     {
          return $this->cost_amount == 0;
     }
     public function isInPostLayout($position)
     {
          return $this->getPostLayoutSetting('enabled')
               && preg_match('/post_below_|post_above_|message_below_|message_above_|profile_post_/', $position);
     }
     public function getCost($customCost = 0)
     {
          if ($this->isFree())
          {
               return \XF::phrase('siropu_ads_manager_free');
          }

          $cost = $customCost ?: $this->cost_amount;

          return $this->app()->data('XF:Currency')->languageFormat($cost, $this->cost_currency) . ' / ' .  $this->cost_per_phrase;
     }
     public function getCostPerPhrase($purchase = 0)
     {
          $options = \XF::options();

          switch ($this->cost_per)
          {
               case '':
                    return \XF::phrase('siropu_ads_manager_lifetime');
                    break;
               case 'day':
                    return \XF::phrase($purchase > 1 ? 'days' : 'day');
                    break;
               case 'week':
                    return \XF::phrase($purchase > 1 ? 'weeks' : 'siropu_ads_manager_week');
                    break;
               case 'month':
                    return \XF::phrase($purchase > 1 ? 'months' : 'siropu_ads_manager_month');
                    break;
               case 'year':
                    return \XF::phrase($purchase > 1 ? 'years' : 'year');
                    break;
               case 'cpm':
                    if ($options->siropuAdsManagerViewCountMethod == 'view')
                    {
                         return \XF::phrase($purchase ? 'siropu_ads_manager_views' : 'siropu_ads_manager_cpm_views');
                    }
                    else
                    {
                         return \XF::phrase($purchase ? 'siropu_ads_manager_impressions' : 'siropu_ads_manager_cpm_impressions');
                    }
                    break;
               case 'cpc':
                    return \XF::phrase($purchase ? 'siropu_ads_manager_clicks' : 'siropu_ads_manager_cpc');
                    break;
          }
     }
     public function getItemCustomCost($item)
     {
          $item = utf8_strtolower($item);

          if (isset($this->cost_custom[$item]))
          {
               return $this->cost_custom[$item];
          }
     }
     public function getMinimumLength()
     {
          return $this->min_purchase . ' ' . $this->getCostPerPhrase($this->min_purchase);
     }
     public function enablePlaceholder($useAsBackup = false)
     {
          if ($this->cost_amount > 0)
          {
               if ($useAsBackup)
               {
                    $settings = $this->settings;
                    $settings['use_backup_ad'] = 1;

                    $this->settings = $settings;
               }

               $placeholder = $this->app()->service('Siropu\AdsManager:Package\Placeholder', $this);
               $placeholder->generate();
          }
     }
     public function disablePlaceholder()
     {
          if (!$this->Placeholder)
          {
               return;
          }

          $this->Placeholder->delete();

          $settings = $this->settings;
          $settings['use_backup_ad'] = 0;

          $this->settings = $settings;
          $this->placeholder_id = 0;
          $this->save();
     }
     protected function getPlaceholderService()
     {
          return $this->app()->service('Siropu\AdsManager:Package\Placeholder', $this);
     }
     public function getCustomCost($itemId)
     {
          return isset($this->cost_custom[$itemId]) ? $this->cost_custom[$itemId] : $this->cost_amount;
     }
     public function hasPreviewImage()
     {
          return !empty($this->preview);
     }
     public function getBreadcrumbs($includeSelf = true)
	{
          $breadcrumbs = [
               [
                    'href'  => $this->app()->router()->buildLink('ads-manager/packages'),
                    'value' => \XF::phrase('siropu_ads_manager_packages')
               ]
          ];

          if ($includeSelf)
          {
               $breadcrumbs[] = [
				'href'  => $this->app()->router()->buildLink('ads-manager/packages/edit', $this),
				'value' => $this->title
			];
          }

          return $breadcrumbs;
     }
     public function getTimeToWait()
     {
          if ($this->isCostPer(['cpm', 'cpc']))
          {
               return \XF::phrase('n_a');
          }

          $adsFinder = $this->finder('Siropu\AdsManager:Ad')
               ->with('Extra')
               ->forPackage($this->package_id);

          if ($this->isXFItem())
          {
               $adsFinder->active();
          }
          else
          {
               $adsFinder->whereOr([['status', ['active', 'paused', 'queued']], ['Extra.prev_status', ['active', 'paused', 'queued']]]);
          }

          $endDates = [];

          foreach ($adsFinder->fetch() as $ad)
          {
               if ($ad->end_date)
               {
                    $endDates[] = max(0, $ad->end_date - \XF::$time);
               }
               else if ($ad->isQueued() || $ad->Extra->prev_status == 'queued')
               {
                    $endDates[] = max(0, strtotime("+{$ad->Extra->purchase} {$this->cost_per}") - \XF::$time);
               }
          }

          $time = $endDates ? min($endDates) : 0;

          if ($time == 0)
          {
               return \XF::phrase('n_a');
          }
          else if ($time > 86400)
          {
               return \XF::phrase('x_days', ['days' => round($time / 86400)]);
          }
          else
          {
               return \XF::phrase('x_hours', ['count' => round($time / 3600)]);
          }
     }
     public function getImpressionDistributionDays()
     {
          if (empty($this->settings['cpm_distribution']['unit']))
          {
               return;
          }

          $length = $this->settings['cpm_distribution']['length'];
          $unit   = $this->settings['cpm_distribution']['unit'];

          switch ($unit)
          {
               case 'days':
                    return $length * 1;
                    break;
               case 'weeks':
                    return $length * 7;
                    break;
               case 'months':
                    return $length * 30;
                    break;
          }
     }
     public function getEmptySlotCountFromDb()
     {
          return $this->db()->fetchOne('
               SELECT empty_slot_count
               FROM xf_siropu_ads_manager_package
               WHERE package_id = ?', $this->package_id
          );
     }
     public function isPurchaseLimitReached(\XF\Entity\User $user = null)
     {
          $limit = $this->advertiser_purchase_limit;

          if ($limit)
          {
               $visitor = $user ?: \XF::visitor();

               $count = $this->db()->fetchOne('
                    SELECT COUNT(*)
                    FROM xf_siropu_ads_manager_ad
                    WHERE package_id = ?
                    AND user_id = ?
                    AND status NOT IN ("inactive", "rejected", "archived")', [$this->package_id, $visitor->user_id]);

               return $count >= $limit;
          }
     }
     public function getNextBreakpointCounter()
     {
          $breakpoints = $this->getCarouselSetting('breakpoints');

          if ($breakpoints)
          {
               return count($breakpoints) + 1;
          }

          return 2;
     }
     public function getAbsoluteFilePath($file)
     {
          return $this->app()->applyExternalDataUrl("siropu/am/package/{$file}", true);
     }
     protected function verifySettings(&$settings)
     {
          if (!empty($settings['daily_stats']) || $this->isCpm())
          {
               $settings['count_views'] = 1;
          }

          if (!empty($settings['click_stats']) || $this->isCpc())
          {
               $settings['count_clicks'] = 1;
          }

          if (!empty($settings['carousel']['breakpoints']))
          {
               $breakpoints = [];

     		foreach ($settings['carousel']['breakpoints'] AS $data)
     		{
                    if (empty($data['width']) || empty($data['ads']))
                    {
                         continue;
                    }

                    $breakpoints[$data['width']] = $data['ads'];
     		}

               $settings['carousel']['breakpoints'] = $breakpoints;
          }

          $settings = array_replace_recursive([
               'display'            => '',
               'unit_alignment'     => '',
               'unit_size'          => '',
               'unit_style'         => '',
               'css_class'          => '',
               'ad_allowed_sizes'   => [],
               'carousel'           => [
                    'enabled'         => 0,
                    'arrows'          => 0,
                    'bullets'         => 0,
                    'itemsPerView'    => 1,
                    'itemsPerColumn'  => 1,
                    'itemsPerGroup'   => 1,
                    'autoplaySpeed'   => 1,
                    'transitionSpeed' => 300,
                    'effect'          => 'slide',
                    'direction'       => 'horizontal',
                    'device'          => [
                         'desktop' => 0,
                         'tablet'  => 0,
                         'mobile'  => 0
                    ],
                    'breakpoints'     => []
               ],
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
               'use_backup_ad'      => 0,
               'hide_after'         => 0,
               'display_after'      => 0,
               'display_frequency'  => 0,
               'cpm_distribution'   => ['length' => 0, 'unit' => 'days'],
               'randomize_display'  => 0,
               'lazyload_image'     => 0,
               'lazyload'           => 0,
               'no_wrapper'         => 0,
               'no_approval'        => 0,
               'xf_post_layout'     => ['enabled' => 0, 'avatar' => '', 'username' => '', 'title' => '']
          ], $settings);

          return true;
     }
     protected function verifyCostCustom(&$cost)
     {
          if (isset($cost['item'], $cost['cost']))
          {
               $cost = array_filter(array_combine(array_map('utf8_strtolower', $cost['item']), array_map('floatval', $cost['cost'])));
          }

          return true;
     }
     protected function verifyDiscount(&$discount)
     {
          if (isset($discount['purchase'], $discount['discount']))
          {
               $discount = array_filter(array_combine($discount['purchase'], array_map('floatval', $discount['discount'])));
          }

          return true;
     }
     protected function verifyAdvertiserCriteria(&$criteria)
     {
          $advertiserCriteria = $this->app()->criteria('Siropu\AdsManager:Advertiser', $criteria);
          $criteria = $advertiserCriteria->getCriteria();
          return true;
     }
     protected function _preSave()
     {
          if ($this->isInsert())
          {
               $this->empty_slot_count = $this->ad_allowed_limit;
          }
     }
     protected function _postSave()
     {
          if ($this->isUpdate())
          {
               $this->getPackageRepo()->updateAdCount($this->package_id);
               $this->getPackageRepo()->updateEmptySlotCount($this->package_id);

               if ($this->isOfType(['thread', 'sticky']))
               {
                    $this->getPackageRepo()->updateAdvertiseHereThreadCache();
               }
          }
     }
     protected function _postDelete()
     {
          if ($this->Placeholder)
          {
               $this->Placeholder->delete();
          }

          if ($this->isOfType(['thread', 'sticky']))
          {
               $this->getPackageRepo()->updateAdvertiseHereThreadCache();
          }

          if ($this->preview)
          {
               \XF\Util\File::deleteFromAbstractedPath("data://siropu/am/package/{$this->preview}");
          }
     }
}
