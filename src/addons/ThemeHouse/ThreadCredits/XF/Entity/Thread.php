<?php

namespace ThemeHouse\ThreadCredits\XF\Entity;

use ThemeHouse\ThreadCredits\Entity\CreditPackage;
use ThemeHouse\ThreadCredits\Service\CreditPackage\Purchase;

class Thread extends XFCP_Thread
{
    protected function _postSave()
    {
        if (
            (\XF::options()->thtc_newPostNodeId && \XF::options()->thtc_newThreadCreditPackage)
            && ($this->node_id == \XF::options()->thtc_newPostNodeId)
            && ($this->discussion_state == 'visible')
            && ($this->isInsert() || $this->isChanged('discussion_state'))
        ) {
            /** @var CreditPackage $creditPackage */
            $creditPackage = $this->em()->find('ThemeHouse\ThreadCredits:CreditPackage', \XF::options()->thtc_newThreadCreditPackage);

            /** @var Purchase $service */
            $service = \XF::service('ThemeHouse\ThreadCredits:CreditPackage\Purchase', $creditPackage, $this->User);
            $service->setEndDate(null);
            $service->ignoreUnpurchasable(true);
            $service->setExtraData([
                'thread_id' => $this->thread_id,
                'thread_title' => $this->title,
                'thread_url' => $this->getContentUrl(true)
            ]);
            $service->notifyUser(true);
            $service->purchase();
        }

        parent::_postSave();
    }
}
