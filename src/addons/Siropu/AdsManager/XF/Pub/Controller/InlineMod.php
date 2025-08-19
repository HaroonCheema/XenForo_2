<?php

namespace Siropu\AdsManager\XF\Pub\Controller;

class InlineMod extends XFCP_InlineMod
{
     public function actionPerform()
	{
          $type   = $this->filter('type', 'str');
          $action = $this->filter('action', 'str');
          $ids    = $this->filter('ids', 'array-uint');
          $ids    = array_unique($ids);

          if (empty($ids) && ($handler = $this->getInlineModHandler($type)))
          {
               $ids = $handler->getCookieIds($this->request);
          }

          if (in_array($type, ['thread', 'resource']) && in_array($action, ['move', 'delete', 'unstick', 'unfeature']))
          {
               $moderator = $this->service('Siropu\AdsManager:Ad\Moderator', $ids);

               if ($moderator->isAd())
               {
                    $error = '';

                    switch ($type)
                    {
                         case 'thread':
                              if ($action == 'unstick'
                                   || $action == 'move' && !$moderator->hasPermission('moveSticky')
                                   || $action == 'delete' && !$moderator->hasPermission('deleteSticky'))
                              {
                                   $error = 'siropu_ads_manager_action_cannot_be_taken_for_following_x_threads';
                              }
                              break;
                         case 'resource':
                              if ($action == 'unfeature'
                                   || $action == 'move' && !$moderator->hasPermission('moveFeatured')
                                   || $action == 'delete' && !$moderator->hasPermission('deleteFeatured'))
                              {
                                   $error = 'siropu_ads_manager_action_cannot_be_taken_for_following_x_resources';
                              }
                              break;
                    }

                    if ($error)
                    {
                         return $this->error(\XF::phrase($error, ['items' => $moderator->getTitles()]));
                    }
               }
          }

          return parent::actionPerform();
     }
}
