<?php

namespace JUM\ConnectedAccounts;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Exception;
use XF\Util\File;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    /**
     * @return void
     */
    public function installStep1()
    {
        $this->db()->insertBulk('xf_connected_account_provider',
            [
                [
                    'provider_id' => 'jum_vkontakte',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Vkontakte',
                    'display_order' => 9,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_odnoklassniki',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Odnoklassniki',
                    'display_order' => 11,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_reddit',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Reddit',
                    'display_order' => 19,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_instagram',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Instagram',
                    'display_order' => 27,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_twitch',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Twitch',
                    'display_order' => 28,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_yandex',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Yandex',
                    'display_order' => 29,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_dropbox',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Dropbox',
                    'display_order' => 41,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_paypal',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Paypal',
                    'display_order' => 51,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_vimeo',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Vimeo',
                    'display_order' => 52,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_tumblr',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Tumblr',
                    'display_order' => 71,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_pinterest',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Pinterest',
                    'display_order' => 72,
                    'options' => ''
                ],
                [
                    'provider_id' => 'jum_amazon',
                    'provider_class' => 'JUM\\ConnectedAccounts:Provider\\Amazon',
                    'display_order' => 73,
                    'options' => ''
                ]

            ], 'provider_id');

    }

    /**
     * @return void
     * @throws Exception
     */
    public function upgrade2010170Step1()
    {
        $providerClass = 'JUM\\\\ConnectedAccounts:Provider\\\\%';

        $this->db()->query("
                UPDATE xf_connected_account_provider 
                SET provider_id = CONCAT('jum_', provider_id)
                WHERE provider_class LIKE ?;
         ", $providerClass);
    }

    public function upgrade2010170Step2()
    {
        $this->db()->query("
                UPDATE xf_user_connected_account AS conuser INNER JOIN xf_connected_account_provider AS conprovider
                ON conprovider.provider_id = CONCAT('jum_', conuser.provider)
                SET provider = CONCAT('jum_', provider);
         ");
    }

    public function upgrade2010170Step3()
    {
        $this->app->jobManager()->enqueueUnique(
            'jumConnectedAccountsRebuild',
            'JUM\ConnectedAccounts:ConnectedAccountsRebuild',
            [],
            false
        );
    }

    public function upgrade2010170Step4()
    {
        $ds = \XF::$DS;

        $addOn = $this->addOn;
        $addOnDir = $addOn->getAddOnDirectory();

        $removeDir = $addOnDir . $ds . 'XF';

        if (file_exists($removeDir))
        {
            File::deleteDirectory($removeDir);
        }
    }

    /**
     * @return void
     */
    public function uninstallStep1()
    {
        $providerClass = 'JUM\\\\ConnectedAccounts:Provider\\\\%';
        $this->db()->delete('xf_connected_account_provider', "provider_class LIKE ?", $providerClass);

    }
}