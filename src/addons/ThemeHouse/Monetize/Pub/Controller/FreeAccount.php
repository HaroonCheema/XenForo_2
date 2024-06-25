<?php

namespace ThemeHouse\Monetize\Pub\Controller;

use XF;
use XF\Entity\ConnectedAccountProvider;
use XF\Pub\Controller\AbstractController;
use XF\Repository\ConnectedAccount;
use XF\Service\User\EmailConfirmation;
use XF\Service\User\Welcome;

/**
 * Class FreeAccount
 * @package ThemeHouse\Monetize\Pub\Controller
 */
class FreeAccount extends AbstractController
{
    /**
     * @throws XF\PrintableException
     * @throws XF\Mvc\Reply\Exception
     */
    public function actionIndex()
    {
        $user = XF::visitor();
        if (!$user->user_id
            || $user->user_state !== 'thmonetize_upgrade'
            || !XF::options()->thmonetize_allowFreeUpgrade) {
            return $this->notFound();
        }

        if ($this->filter('confirm', 'bool')) {
            $this->assertPostOnly();
            if ($user->user_state === 'thmonetize_upgrade') {
                $options = $this->app->options();

                /** @var ConnectedAccount $connectedAccountRepo */
                $connectedAccountRepo = $this->repository('XF:ConnectedAccount');
                $providers = $connectedAccountRepo->getUsableProviders();

                $skipEmailConfirm = false;
                foreach ($providers as $provider) {
                    /** @var ConnectedAccountProvider $provider */
                    if ($provider->isAssociated($user)) {
                        $providerData = $provider->getUserInfo($user);
                        if ($providerData->email) {
                            $skipEmailConfirm = true;
                        }
                    }
                }

                if ($options->registrationSetup['emailConfirmation'] && !$skipEmailConfirm) {
                    $user->user_state = 'email_confirm';
                } elseif ($options->registrationSetup['moderation']) {
                    $user->user_state = 'moderated';
                } else {
                    $user->user_state = 'valid';
                }
                $user->save();

                if ($user->user_state == 'email_confirm') {
                    /** @var EmailConfirmation $emailConfirmation */
                    $emailConfirmation = $this->service('XF:User\EmailConfirmation', $user);
                    $emailConfirmation->triggerConfirmation();
                } elseif ($user->user_state == 'valid') {
                    /** @var Welcome $userWelcome */
                    $userWelcome = $this->service('XF:User\Welcome', $user);
                    $userWelcome->send();
                }
            }

            return $this->redirect($this->buildLink(''));
        } else {
            return $this->view('ThemeHouse\Monetize:FreeAccount', 'thmonetize_free_account_confirm');
        }
    }
}
