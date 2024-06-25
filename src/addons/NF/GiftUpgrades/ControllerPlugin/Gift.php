<?php

namespace NF\GiftUpgrades\ControllerPlugin;

use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Globals;
use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use XF\ControllerPlugin\AbstractPlugin;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Reply\AbstractReply;

/**
 * Class Gift
 *
 * @package NF\GiftUpgrades\ControllerPlugin
 */
class Gift extends AbstractPlugin
{
    /**
     * @param Entity $entity
     * @param array  $options
     * @return AbstractReply
     * @throws \Exception
     * @noinspection PhpUnusedParameterInspection
     */
    public function actionGift(Entity $entity, array $options = []): AbstractReply
    {
        if (!($entity instanceof IGiftable))
        {
            $shortName = $entity->structure()->shortName;
            throw new \LogicException("Expect {$shortName} entity to implement \NF\GiftUpgrades\Entity\IGiftable");
        }

        $handler = $entity->getGiftHandler();
        if (!$handler)
        {
            $shortName = $entity->structure()->shortName;
            throw new \LogicException("Expect {$shortName} entity to implement gift handler");
        }

        if (!$entity->canGiftTo($error))
        {
            return $this->noPermission($error);
        }

        $contentUrl = $handler->getContentUrl($entity);
        $giftUser = $handler->getContentUser($entity);
        $breadcrumbs = $handler->getBreadCrumbs($entity);

        /** @var \XF\Repository\UserUpgrade $upgradeRepo */
        $upgradeRepo = \XF::repository('XF:UserUpgrade');

        Globals::$isGift = true;
        try
        {
            /** @var ArrayCollection $upgrades */
            /** @noinspection PhpUnusedLocalVariableInspection */
            [$upgrades, $purchased] = $upgradeRepo->getFilteredUserUpgradesForList();
        }
        finally
        {
            Globals::$isGift = false;
        }
        /** @var ArrayCollection $upgrades */
        $upgrades = $upgrades->filter(function($entity)
        {
            /** @var \NF\GiftUpgrades\XF\Entity\UserUpgrade $entity */
            return $entity->canGift();
        });

        if (!$upgrades->count())
        {
            return $this->message(\XF::phrase('no_account_upgrades_can_be_purchased_at_this_time'));
        }
        /** @var \NF\GiftUpgrades\XF\Entity\UserUpgrade $selectedUserUpgrade */
        $selectedUserUpgrade = $upgrades->first();

        /** @var \XF\Repository\Payment $paymentRepo */
        $paymentRepo = $this->repository('XF:Payment');
        $profiles = $paymentRepo->getPaymentProfileOptionsData();

        $isWarnedContent = $entity->isValidKey('warning_id') && $entity->get('warning_id');
        $viewParams = [
            'isWarnedContent' => $isWarnedContent,
            'content' => $entity,
            'user' => $giftUser,
            'breadcrumbs' => $breadcrumbs,
            'contentUrl' => $contentUrl,

            'upgrades' => $upgrades,
            'selectedUpgradeId' => $selectedUserUpgrade->getEntityId(),
            'profiles' => $profiles
        ];
        return $this->view('NF\GiftUpgrades:Gifts\Gift', 'nf_content_gift', $viewParams);
    }

    public function actionListGifts(Entity $entity): AbstractReply
    {
        if (!($entity instanceof IGiftable))
        {
            $shortName = $entity->structure()->shortName;
            throw new \LogicException("Expect {$shortName} entity to implement \NF\GiftUpgrades\Entity\IGiftable");
        }

        $handler = $entity->getGiftHandler();
        if (!$handler)
        {
            $shortName = $entity->structure()->shortName;
            throw new \LogicException("Expect {$shortName} entity to implement gift handler");
        }

        if (!$entity->canViewGiftsList())
        {
            return $this->notFound();
        }

        if ($entity->GiftCount <= 0)
        {
            return $this->error(\XF::phrase('nf_no_one_has_gifted_this_content_yet'));
        }

        $repo = GiftUpgradeRepo::get();
        $totalFinder = $repo->getGiftFinderForList($entity);
        $total = $totalFinder->total();

        $limit = $this->options()->discussionsPerPage;
        $finder = $repo->getGiftFinderForList($entity, false);
        $totalPublicGifts = $finder->total();
        $gifts = $finder->limit($limit)
                        ->fetch();

        if ($gifts->count() <= 0)
        {
            return $this->error(\XF::phrase('nf_no_one_has_gifted_this_content_yet'));
        }

        $viewParams = [
            'entity'     => $entity,
            'handler'    => $handler,

            'gifts'      => $gifts,
            'totalGifts' => $total,

            'hasMore'    => $totalPublicGifts > $gifts->count(),
        ];

        return $this->view(
            'NF\GiftUpgrades:Gifts\Index',
            'nf_content_gifts',
            $viewParams
        );
    }
}