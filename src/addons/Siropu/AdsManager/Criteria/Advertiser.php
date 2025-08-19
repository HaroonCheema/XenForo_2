<?php

namespace Siropu\AdsManager\Criteria;

class Advertiser extends \XF\Criteria\AbstractCriteria
{
     public function __construct(\XF\App $app, array $criteria)
     {
          parent::__construct($app, $criteria);
     }
     public function _matchUserGroups(array $data, \XF\Entity\User $user)
     {
          if (empty($data['user_group_ids']))
          {
               return true;
          }

          return $user->isMemberOf($data['user_group_ids']);
     }
     public function getExtraTemplateData()
     {
          $userGroupRepo = $this->app->repository('XF:UserGroup');

          $templateData = [
			'userGroups' => $userGroupRepo->getUserGroupTitlePairs()
		];

          return $templateData;
     }
}
