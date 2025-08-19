<?php

namespace Siropu\AdsManager\Service\Ad;

class Toggler extends \XF\Service\AbstractService
{
	protected $ad;
     protected $itemId = 0;

	public function __construct(\XF\App $app, $ad, $itemId)
	{
		parent::__construct($app);

          $this->ad     = $ad;
          $this->itemId = $itemId;
	}
     public function toggleSticky($sticky)
     {
          $thread = $this->app->em()->find('XF:Thread', $this->itemId ?: $this->ad->item_id);
          $prefix = (int) @\XF::options()->siropuAdsManagerStickyThreadPrefix;

          if ($thread)
          {
               if ($prefix && $this->ad->Extra)
               {
                    if ($sticky)
                    {
                         if ($thread->prefix_id && $thread->prefix_id != $prefix)
                         {
                              $this->ad->Extra->prev_prefix = $thread->prefix_id;
                              $this->ad->Extra->save();
                         }

                         $thread->prefix_id = $prefix;
                    }
                    else if ($this->ad->isInactive())
                    {
                         $thread->prefix_id = $this->ad->Extra->prev_prefix;
                    }
               }

               $thread->sticky = $sticky;
               $thread->saveIfChanged();
          }
     }
     public function toggleFeatured($featured)
     {
          $resource = $this->app->em()->find('XFRM:ResourceItem', $this->itemId ?: $this->ad->item_id);
          $prefix   = (int) @\XF::options()->siropuAdsManagerFeaturedResourcePrefix;

          if ($resource)
          {
               $featurer = \XF::service('XFRM:ResourceItem\Feature', $resource);

               if ($featured)
               {
                    $featurer->feature();
               }
               else
               {
                    $featurer->unfeature();
               }

               if ($prefix && $this->ad->Extra)
               {
                    if ($featured)
                    {
                         if ($resource->prefix_id && $resource->prefix_id != $prefix)
                         {
                              $this->ad->Extra->prev_prefix = $resource->prefix_id;
                              $this->ad->Extra->save();
                         }

                         $resource->prefix_id = $prefix;
                    }
                    else if ($this->ad->isInactive())
                    {
                         $resource->prefix_id = $this->ad->Extra->prev_prefix;
                    }

                    $resource->saveIfChanged();
               }
          }
     }
}
