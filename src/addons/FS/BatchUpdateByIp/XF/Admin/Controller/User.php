<?php

namespace FS\BatchUpdateByIp\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class User extends XFCP_User
{
    public function actionList()
    {
        $criteria = $this->filter('criteria', 'array');
        $order = $this->filter('order', 'str');
        $direction = $this->filter('direction', 'str');

        if (isset($criteria['ip'])) {
            if (empty($criteria['ip'])) {
                return parent::actionList();
            }
        } else {
            return parent::actionList();
        }

        $page = $this->filterPage();
        $perPage = 20;

        $showingAll = $this->filter('all', 'bool');
        if ($showingAll) {
            $page = 1;
            $perPage = 5000;
        }

        if (!$criteria) {
            $this->setSectionContext('listAllUsers');
        } else {
            $this->setSectionContext('searchForUsers');
        }

        $searcher = $this->searcher('XF:User', $criteria);

        $finder = \XF::finder('XF:User')->where('user_id', $criteria['userIds']);

        $finder->limitByPage($page, $perPage);

        $filter = $this->filter('_xfFilter', [
            'text' => 'str',
            'prefix' => 'bool'
        ]);
        if (strlen($filter['text'])) {
            $finder->where('username', 'LIKE', $finder->escapeLike($filter['text'], $filter['prefix'] ? '?%' : '%?%'));
        }

        $total = $finder->total();
        $users = $finder->fetch();

        $this->assertValidPage($page, $perPage, $total, 'users/list');

        if (!strlen($filter['text']) && $total == 1 && ($user = $users->first())) {
            return $this->redirect($this->buildLink('users/edit', $user));
        }

        $viewParams = [
            'users' => $users,

            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,

            'showingAll' => $showingAll,
            'showAll' => (!$showingAll && $total <= 5000),

            'criteria' => $searcher->getFilteredCriteria(),
            'filter' => $filter['text'],
            'sortOptions' => $searcher->getOrderOptions(),
            'order' => $order,
            'direction' => $direction
        ];
        return $this->view('XF:User\Listing', 'user_list', $viewParams);
    }

    public function actionBatchUpdateConfirm()
    {
        $this->setSectionContext('batchUpdateUsers');

        $this->assertPostOnly();

        $criteria = $this->filter('criteria', 'array');

        $searcher = $this->searcher('XF:User', $criteria);

        $userIds = $this->filter('user_ids', 'array-uint');
        $total = 0;

        if (count($userIds) || empty($criteria['ip'])) {
            return parent::actionBatchUpdateConfirm();
        }

        if (!count($userIds) && isset($criteria['ip'])) {

            $allUsers = \XF::finder('XF:User')->total();
            $searchAllUsers = $searcher->getFinder()->total();
            $ip = $criteria['ip'];

            /** @var \XF\Repository\Ip $ipRepo */
            $ipRepo = $this->repository('XF:Ip');

            $parsed = \XF\Util\Ip::parseIpRangeString($ip);

            if (!$parsed) {
                return $this->message(\XF::phrase('please_enter_valid_ip_or_ip_range'));
            } else if ($parsed['isRange']) {
                $ips = $ipRepo->getUsersByIpRange($parsed['startRange'], $parsed['endRange']);
            } else {
                $ips = $ipRepo->getUsersByIp($parsed['startRange']);
            }

            if ($searchAllUsers && $searchAllUsers != $allUsers) {
                $users = $searcher->getFinder()->fetch();
                $newUser = array();

                $ipUserIds = array_column($ips, 'user_id');
                $ipUserIds = array_unique($ipUserIds);

                foreach ($users as $user) {
                    if (in_array($user['user_id'], $ipUserIds)) {
                        $newUser[] = $user;
                    }
                }

                $userIds = array_column($newUser, 'user_id');
                $userIds = array_unique($userIds);
                $total = count($userIds);
            } else {

                $userIds = array_column($ips, 'user_id');
                $userIds = array_unique($userIds);
                $total = count($userIds);
            }
        }

        if (!$total) {
            throw $this->exception($this->error(\XF::phraseDeferred('no_items_matched_your_filter')));
        }

        $criteria = $searcher->getFilteredCriteria();
        $criteria['userIds'] = $userIds;

        $viewParams = [
            'total' => $total,
            'userIds' => $userIds,
            'criteria' => $criteria,
            'userGroups' => $this->repository('XF:UserGroup')->findUserGroupsForList()->fetch()
        ];
        return $this->view('XF:User\BatchUpdate\Confirm', 'user_batch_update_confirm', $viewParams);
    }
}
