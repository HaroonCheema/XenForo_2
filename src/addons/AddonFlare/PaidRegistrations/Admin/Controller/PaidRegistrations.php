<?php

namespace AddonFlare\PaidRegistrations\Admin\Controller;

use XF\Entity\ConnectedAccountProvider;
use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

use AddonFlare\PaidRegistrations\Entity\Coupon;

class PaidRegistrations extends \XF\Admin\Controller\AbstractController
{
    use PaidRegistrationsMessagesTrait;

    public function actionIndex()
    {
        $accountTypes = $this->getAccountTypeRepo()->findAccountTypesForList()->fetch();

        $accountTypeRows = $accountTypes->groupBy('row');

        ksort($accountTypeRows);

        $viewParams = [
            'accountTypeRows' => $accountTypeRows,
        ];

        return $this->view('', 'af_paidregistrations_accounttype_list', $viewParams);
    }

    public function accountTypeAddEdit($accountType)
    {
        $upgrades = $this->getUserUpgradeRepo()->findUserUpgradesForList()
            ->where('user_upgrade_id', '!=', $accountType->user_upgrade_id);

        $viewParams = [
            'accountType' => $accountType,
            'upgrades'    => $upgrades->fetch(),
            'nextCounter' => count($accountType->alias_user_upgrades)
        ];

        return $this->view('', 'af_paidregistrations_accounttype_edit', $viewParams);
    }

    public function actionEdit(ParameterBag $params)
    {
        $accountType = $this->assertAccountTypeExists($params->account_type_id);

        return $this->accountTypeAddEdit($accountType);
    }

    public function actionAdd()
    {
        $userUpgradeId = $this->filter('user_upgrade_id', 'int');

        if (!$userUpgradeId)
        {
            if ($this->isPost())
            {
                return $this->error("You must select a valid user upgrade to continue");
            }
            else
            {
                $purchasable = $this->em()->find('XF:Purchasable', 'user_upgrade', 'AddOn');
                if (!$purchasable->isActive())
                {
                    return $this->error(\XF::phrase('no_account_upgrades_can_be_purchased_at_this_time'));
                }

                $upgrades = $this->getUserUpgradeRepo()->findUserUpgradesForList()->fetch();

                if (!$upgrades->count())
                {
                    return $this->error(\XF::phrase('af_paidregistrations_no_upgrades_exist'));
                }

                $viewParams = [
                    'upgrades' => $upgrades
                ];
                return $this->view('', 'af_paidregistrations_choose_upgrade', $viewParams);
            }
        }

        $accountType = $this->em()->create('AddonFlare\PaidRegistrations:AccountType');

        if ($userUpgradeId != -1)
        {
            // if it's not "free", verify the upgrade exists
            $userUpgrade = $this->assertUpgradeExists($userUpgradeId);
        }

        $accountType->user_upgrade_id = $userUpgradeId;

        if ($this->isPost())
        {
            return $this->redirect(
                $this->buildLink('paid-registrations/add', null, ['user_upgrade_id' => $userUpgradeId]), ''
            );
        }

        return $this->accountTypeAddEdit($accountType);
    }

    protected function accountTypeSaveProcess(\AddonFlare\PaidRegistrations\Entity\AccountType $accountType)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'custom_title'        => 'str',
            'row'                 => 'uint',
            'display_order'       => 'uint',
            'user_upgrade_id'     => 'int',
            'color'               => 'str',
            'features'            => 'str',
            'active'              => 'bool',
            'is_featured'         => 'bool',
            'allow_custom_amount' => 'bool',
            'custom_amount_min'   => 'unum',
            'disable_custom_amount_guest' => 'bool',
            'is_giftable' => 'bool',
            'purchase_user_group_ids' => 'array-uint',
        ]);

        // take care of "all user groups" setting (if selected)
        if ($this->filter('purchase_user_group', 'str') == 'all')
        {
            $input['purchase_user_group_ids'] = [-1];
        }

        $alias_user_upgrades = $this->filter('alias_user_upgrades', 'array');

        $input['alias_user_upgrades'] = [];
        $hasSetDefault = false;

        foreach ($alias_user_upgrades as $alias)
        {
            $alias = $this->filterArray($alias, [
                'user_upgrade_id' => 'uint',
                'default' => 'bool',
            ]);

            // skip any keys that have an empty user_upgrade_id
            if (!$userUpgradeId = $alias['user_upgrade_id'])
            {
                continue;
            }

            // this should never happen, but just incase
            if ($userUpgradeId == $accountType->user_upgrade_id)
            {
                continue;
            }

            if ($hasSetDefault)
            {
                // make sure we don't have multiple defaults
                $alias['default'] = false;
            }

            // save with key to avoid duplicates
            $input['alias_user_upgrades'][$userUpgradeId] = $alias;

            if ($alias['default'])
            {
                $hasSetDefault = true;
            }
        }

        // reset keys
        $input['alias_user_upgrades'] = array_values($input['alias_user_upgrades']);

        $form->basicEntitySave($accountType, $input);

        $form->setup(function(FormAction $form) use ($input, $accountType)
        {
            $accountTypeRepo = $this->getAccountTypeRepo();

            $hex = $accountTypeRepo->rgbToHex($input['color']);

            if ($hex)
            {
                $accountType->color_dark = $accountTypeRepo->adjustBrightness($hex, -23);
            }
            else
            {
                $form->logError('Invalid color specified', 'color');
            }

            if (!$accountType->for_deletion)
            {
                $accountType->active = 1;
            }
        });

        if (!$accountType->version)
        {
            \XF::db()->update('xf_af_paidregistrations_accounttype',
                ['active' => 1],
                'user_upgrade_id = ?', -1
            );
        }

        return $form;
    }

    public function actionSave(ParameterBag $params)
    {
        $this->assertPostOnly();

        if ($params->account_type_id)
        {
            $accountType = $this->assertAccountTypeExists($params->account_type_id);
        }
        else
        {
            $accountType = $this->em()->create('AddonFlare\PaidRegistrations:AccountType');
        }
        $this->accountTypeSaveProcess($accountType)->run();

        return $this->redirect($this->buildLink('paid-registrations') . $this->buildLinkHash($accountType->account_type_id));
    }

    public function actionDelete(ParameterBag $params)
    {
        $accountType = $this->assertAccountTypeExists($params->account_type_id);

        if ($this->isPost())
        {
            $accountType->delete();
            return $this->redirect($this->buildLink('paid-registrations'));
        }
        else
        {
            $viewParams = [
                'accountType' => $accountType
            ];
            return $this->view('', 'af_paidregistrations_accounttype_delete', $viewParams);
        }
    }

    public function actionToggle()
    {
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle('AddonFlare\PaidRegistrations:AccountType');
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \XF\Entity\UserUpgrade
     */
    protected function assertUpgradeExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('XF:UserUpgrade', $id, $with, $phraseKey);
    }

    protected function assertAccountTypeExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('AddonFlare\PaidRegistrations:AccountType', $id, 'UserUpgrade', $phraseKey);
    }

    protected function assertCouponExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('AddonFlare\PaidRegistrations:Coupon', $id, $with, $phraseKey);
    }

    /**
     * @return \XF\Repository\UserUpgrade
     */
    protected function getUserUpgradeRepo()
    {
        return $this->repository('XF:UserUpgrade');
    }

    protected function getAccountTypeRepo()
    {
        return $this->repository('AddonFlare\PaidRegistrations:AccountType');
    }
}