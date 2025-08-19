<?php

namespace Siropu\AdsManager\Behavior;

use XF\Mvc\Entity\Behavior;

class ExtraUpdatable extends Behavior
{
	protected function getDefaultOptions()
	{
		return [
               'data' => []
		];
	}
	public function postSave()
	{
          $ad    = $this->entity;
          $extra = \XF::service('Siropu\AdsManager:AdExtra\Manager', $ad);
          $data  = $this->getOption('data');

          if (!empty($data) || $ad->isChanged('status'))
          {
               if (isset($data['prefix_id']))
               {
                    $data['prefix_id'] = $data['prefix_id'] ?: \XF::options()->siropuAdsManagerPromoThreadPrefix;
               }

               if (!($ad->canEditEssentialData() || $ad->isInsert() || $ad->getOption('admin_edit')))
               {
                    unset($data['purchase'],
                         $data['exclusive_use'],
                         $data['is_sticky'],
                         $data['prefix_id'],
                         $data['custom_fields'],
                         $data['promo_code']
                    );
               }

               $extra->bulkSet($data);

               if (isset($data['purchase']))
               {
                    $extra->setPurchase($data['purchase']);
               }

               if (isset($data['custom_fields']))
               {
                    $extra->setCustomFields($data['custom_fields']);
               }

               $extra->save();
          }

          if ($ad->package_id && $ad->isChanged('status') && !$ad->isChanged('package_id'))
          {
               $this->getPackageRepo()->updateEmptySlotCount($ad->package_id);
          }

          if ($ad->getOption('process_queue'))
          {
               $this->getAdRepo()->processQueue();
          }
	}
     protected function getAdRepo()
     {
          return $this->repository('Siropu\AdsManager:Ad');
     }
     protected function getPackageRepo()
     {
          return $this->repository('Siropu\AdsManager:Package');
     }
     protected function getPromoCodeRepo()
     {
          return $this->repository('Siropu\AdsManager:PromoCode');
     }
}
