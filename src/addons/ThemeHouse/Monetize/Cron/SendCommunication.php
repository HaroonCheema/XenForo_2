<?php

namespace ThemeHouse\Monetize\Cron;

use ThemeHouse\Monetize\Entity\AbstractCommunication;
use ThemeHouse\Monetize\Entity\Communication;

/**
 * Class SendCommunication
 * @package ThemeHouse\Monetize\Cron
 */
class SendCommunication
{
    /**
     *
     */
    public static function process()
    {
        /** @var \ThemeHouse\Monetize\Service\CalculateNextSend $service */
        $service = \XF::app()->service('ThemeHouse\Monetize:CalculateNextSend');


        /** @var \ThemeHouse\Monetize\Finder\Communication $comFinder */
        $comFinder = \XF::finder('ThemeHouse\Monetize:Communication')
            ->order('next_send')
            ->where('next_send', '<', \XF::$time);

        $communications = $comFinder
            ->activeOnly()
            ->fetch();

        foreach ($communications as $communication) {
            /** @var Communication $communication */
            if ($service->updateSendTimeAtomic($communication)) {
                \XF::app()->jobManager()->enqueueUnique(
                    'ThMonetize_SendCommunication_' . $communication->communication_id,
                    'ThemeHouse\Monetize:SendCommunication',
                    [
                        'communication_id' => $communication->communication_id,
                    ],
                    false
                );
            }
        }

    }
}
