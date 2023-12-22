<?php

namespace nick97\WatchList\XF\Pub\Controller;

use \XF\Mvc\Reply\View;
use \XF\Mvc\FormAction;
use \XF\Entity\User;

class Account extends XFCP_Account
{
    /**
     * @param User $visitor
     * @return FormAction
     */
    protected function savePrivacyProcess(User $visitor)
    {
        $form = parent::savePrivacyProcess($visitor);

        $visitor = \XF::visitor();

        if ($form instanceof FormAction) {
            $input = $this->filter([
                'privacy' => [
                    'allow_view_watchlist' => 'str',
                    'allow_view_stats' => 'str',
                ]
            ]);

            $userPrivacy = $visitor->getRelationOrDefault('Privacy');
            $form->setupEntityInput($userPrivacy, $input['privacy']);

            $form->complete(function () use ($visitor) {
                /** @var \XF\Repository\IP $ipRepo */
                $ipRepo = $this->repository('XF:Ip');
                $ipRepo->logIp($visitor->user_id, $this->request->getIp(), 'user', $visitor->user_id, 'privacy_edit');
            });
        }

        return $form;
    }
}
