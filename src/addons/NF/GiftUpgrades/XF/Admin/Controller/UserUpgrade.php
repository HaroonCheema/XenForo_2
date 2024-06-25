<?php

namespace NF\GiftUpgrades\XF\Admin\Controller;

use XF\Mvc\FormAction;

/**
 * Extends \XF\Admin\Controller\UserUpgrade
 */
class UserUpgrade extends XFCP_UserUpgrade
{
    /**
     * @param \XF\Entity\UserUpgrade $upgrade
     *
     * @return FormAction
     */
    protected function upgradeSaveProcess(\XF\Entity\UserUpgrade $upgrade)
    {
        $form = parent::upgradeSaveProcess($upgrade);

        $canGift = $this->filter('can_gift', 'bool');
        $form->setup(function(/** @noinspection PhpUnusedParameterInspection */
            FormAction $form) use ($canGift, $upgrade)
        {
            /** @var \NF\GiftUpgrades\XF\Entity\UserUpgrade $upgrade */
            $upgrade->can_gift = $canGift;
        });

        return $form;
    }
}