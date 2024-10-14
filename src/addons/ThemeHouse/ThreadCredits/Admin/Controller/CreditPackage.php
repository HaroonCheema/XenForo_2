<?php

namespace ThemeHouse\ThreadCredits\Admin\Controller;

use ThemeHouse\ThreadCredits\Entity\CreditPackage as CreditPackageEntity;
use ThemeHouse\ThreadCredits\Repository\CreditPackage as CreditPackageRepository;
use ThemeHouse\ThreadCredits\Service\CreditPackage\Purchase;
use XF\Admin\Controller\AbstractController;
use XF\ControllerPlugin\Delete;
use XF\ControllerPlugin\Toggle;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use XF\Repository\Payment;
use XF\Repository\UserGroup;

class CreditPackage extends AbstractController
{
    public function actionIndex(): View
    {
        $creditPackages = $this->getCreditPackageRepo()->findCreditPackagesForList()->fetch();

        $viewParams = [
            'creditPackages' => $creditPackages
        ];

        return $this->view('ThemeHouse\ThreadCredits:CreditPackage\List', 'thtc_credit_package_list', $viewParams);
    }

    public function actionAdd(): View
    {
        /** @var CreditPackageEntity $creditPackage */
        $creditPackage = $this->em()->create('ThemeHouse\ThreadCredits:CreditPackage');
        return $this->creditPackageAddEdit($creditPackage);
    }

    public function actionEdit(ParameterBag $params): View
    {
        $creditPackage = $this->assertCreditPackageExists($params['credit_package_id']);
        return $this->creditPackageAddEdit($creditPackage);
    }

    protected function creditPackageAddEdit(CreditPackageEntity $creditPackage)
    {
        $userGroupRepository = $this->getUserGroupRepo();
        $userGroups = $userGroupRepository->getUserGroupTitlePairs();

        /** @var Payment $paymentRepo */
        $paymentRepo = $this->repository('XF:Payment');
        $paymentProfiles = $paymentRepo->findPaymentProfilesForList()->fetch();

        $viewParams = [
            'profiles' => $paymentProfiles,
            'creditPackage' => $creditPackage,
            'userGroups' => $userGroups
        ];

        return $this->view('TheemHouse\ThreadCredits:CreditPackage\Edit', 'thtc_credit_package_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params['credit_package_id']) {
            $creditPackage = $this->assertCreditPackageExists($params['credit_package_id']);
        } else {
            /** @var CreditPackageEntity $creditPackage */
            $creditPackage = $this->em()->create('ThemeHouse\ThreadCredits:CreditPackage');
        }

        $this->creditPackageSaveProcess($creditPackage)->run();

        return $this->redirect($this->buildLink('thtc-credit-package'));
    }

    protected function creditPackageSaveProcess(CreditPackageEntity $creditPackage): FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'title' => 'str',
            'description' => 'str',
            'display_order' => 'uint',
            'extra_group_ids' => 'array-uint',
            'credits' => 'int',
            'cost_amount' => 'unum',
            'cost_currency' => 'str',
            'length_amount' => 'uint',
            'length_unit' => 'string',
            'payment_profile_ids' => 'array-uint',
            'can_purchase' => 'bool'
        ]);
        $form->basicEntitySave($creditPackage, $input);

        $form->setup(function () use ($creditPackage) {
            if ($this->filter('length_type', 'str') == 'permanent') {
                $creditPackage->length_amount = 0;
                $creditPackage->length_unit = '';
            }
        });

        return $form;
    }

    public function actionDelete(ParameterBag $params)
    {
        $creditPackage = $this->assertCreditPackageExists($params['credit_package_id']);

        /** @var Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $creditPackage,
            $this->buildLink('thtc-credit-package/delete', $creditPackage),
            $this->buildLink('thtc-credit-package/edit', $creditPackage),
            $this->buildLink('thtc-credit-package'),
            $creditPackage->title
        );
    }

    public function actionToggle() {
        /** @var Toggle $plugin */
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle('ThemeHouse\ThreadCredits:CreditPackage', 'can_purchase');
    }

    public function actionPurchaseLog(ParameterBag $params): View
    {
        $creditPackage = $this->assertCreditPackageExists($params['credit_package_id']);

        $finder = $this->getCreditPackageRepo()
            ->findUserCreditPackagesForCreditPackage($creditPackage)
            ->with('User')
            ->with('PurchaseRequest');

        $page = $this->filterPage();
        $perPage = 25;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            'creditPackage' => $creditPackage,
            'purchases' => $finder->fetch()
        ];

        return $this->view('ThemeHouse\ThreadCredits:CreditPackage\PurchaseLog', 'thtc_credit_package_purchase_log', $viewParams);
    }

    public function actionManual(ParameterBag $params)
    {
        $creditPackage = $this->assertCreditPackageExists($params['credit_package_id']);

        if ($this->isPost()) {
            $username = $this->filter('username', 'str');
            $user = $this->em()->findOne('XF:User', ['username' => $username]);
            if (!$user)
            {
                return $this->error(\XF::phrase('requested_user_not_found'));
            }

            $endDate = $this->filter('end_type', 'str') == 'date'
                ? $this->filter('end_date', 'datetime')
                : 0;

            /** @var Purchase $service */
            $service = $this->service('ThemeHouse\ThreadCredits:CreditPackage\Purchase', $creditPackage, $user);
            $service->setEndDate($endDate);
            $service->ignoreUnpurchasable(true);
            $service->purchase();

            return $this->redirect($this->buildLink('thtc-credit-package/purchase-log', $creditPackage));
        } else {
            if ($creditPackage->length_unit)
            {
                $endDate = strtotime('+' . $creditPackage->length_amount . ' ' . $creditPackage->length_unit);
            }
            else
            {
                $endDate = false;
            }

            $viewParams = [
                'creditPackage' => $creditPackage,
                'endDate' => $endDate
            ];

            return $this->view('ThemeHouse\ThreadCredits:CreditPackage\Manual', 'thtc_credit_package_manual', $viewParams);
        }
    }

    protected function assertCreditPackageExists($id, $with = null, $phraseKey = null): CreditPackageEntity
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->assertRecordExists('ThemeHouse\ThreadCredits:CreditPackage', $id, $with, $phraseKey);
    }

    protected function getCreditPackageRepo(): CreditPackageRepository
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository('ThemeHouse\ThreadCredits:CreditPackage');
    }

    protected function getUserGroupRepo(): UserGroup
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository('XF:UserGroup');
    }
}
