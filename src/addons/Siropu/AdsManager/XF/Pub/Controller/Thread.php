<?php

namespace Siropu\AdsManager\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
     protected function preDispatchController($action, ParameterBag $params)
     {
          parent::preDispatchController($action, $params);

          switch ($action)
          {
               case 'Edit':
               case 'Move':
               case 'Delete':
                    $moderator = $this->service('Siropu\AdsManager:Ad\Moderator', $params->thread_id);

                    if ($moderator->isAd()
                         && ($action == 'Edit' && !$moderator->hasPermission('editSticky')
                              || $action == 'Move' && !$moderator->hasPermission('moveSticky')
                              || $action == 'Delete' && !$moderator->hasPermission('deleteSticky')))
                    {
                         throw $this->exception($this->error(\XF::phrase('siropu_ads_manager_action_not_allowed_for_paid_sticky')));
                    }
                    break;
          }
     }
}
