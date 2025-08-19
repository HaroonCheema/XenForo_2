<?php

namespace Siropu\AdsManager\XFRM\Pub\Controller;

use XF\Mvc\ParameterBag;

class ResourceItem extends XFCP_ResourceItem
{
     protected function preDispatchController($action, ParameterBag $params)
     {
          parent::preDispatchController($action, $params);

          switch ($action)
          {
               case 'QuickFeature':
               case 'Edit':
               case 'Move':
               case 'Delete':
                    $moderator = $this->service('Siropu\AdsManager:Ad\Moderator', $params->resource_id);

                    if ($moderator->isAd()
                         && ($action == 'QuickFeature'
                              || $action == 'Edit' && !$moderator->hasPermission('editFeatured')
                              || $action == 'Move' && !$moderator->hasPermission('moveFeatured')
                              || $action == 'Delete' && !$moderator->hasPermission('deleteFeatured')))
                    {
                         throw $this->exception($this->error(\XF::phrase('siropu_ads_manager_action_not_allowed_for_paid_featured')));
                    }
                    break;
          }
     }
}
