<?php

namespace Siropu\AdsManager\ControllerPlugin;

class Embed extends \XF\ControllerPlugin\AbstractPlugin
{
     public function embedUnit($entity)
     {
          $linkParams = [];

          if ($entity instanceof \Siropu\AdsManager\Entity\Ad)
          {
               $linkParams['aid'] = $entity->ad_id;
          }

          if ($entity instanceof \Siropu\AdsManager\Entity\Package)
          {
               $linkParams['pid'] = $entity->package_id;
          }

          $viewParams = [
               'url'      => \XF::app()->router('public')->buildLink('full:sam-embed', '', $linkParams),
               'unitSize' => $entity->settings['unit_size']
          ];

          return $this->view('Siropu\AdsManager:Embed', 'siropu_ads_manager_embed', $viewParams);
     }
}
