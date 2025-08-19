<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class PromoCode extends Repository
{
     public function findPromoCodesForList()
     {
          return $this->finder('Siropu\AdsManager:PromoCode');
     }
     public function getPromoCodePairs()
     {
          return $this->findPromoCodesForList()
               ->order('promo_code', 'ASC')
               ->fetch()
               ->pluckNamed('promo_code', 'promo_code');
     }
     public function canApplyPromoCode(\Siropu\AdsManager\Entity\Ad $ad, \Siropu\AdsManager\Entity\AdExtra $adExtra)
     {
          $costDetails = $ad->getCost($adExtra->purchase);

          if ($adExtra->PromoCode && $adExtra->PromoCode->canApply($ad->package_id, $costDetails['costDiscounted']))
          {
               return true;
          }
     }
}
