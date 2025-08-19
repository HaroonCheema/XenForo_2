<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;

class PromoCode extends AbstractController
{
     public function actionIndex()
     {
          $promoCodes = $this->getPromoCodeRepo()
               ->findPromoCodesForList()
               ->fetch();

          $viewParams = [
               'promoCodes' => $promoCodes
          ];

          return $this->view('Siropu\AdsManager:PromoCode\List', 'siropu_ads_manager_promo_code_list', $viewParams);
     }
     public function actionAdd()
     {
          $promoCode = $this->em()->create('Siropu\AdsManager:PromoCode');
          return $this->promoCodeAddEdit($promoCode);
     }
     public function actionEdit(ParameterBag $params)
     {
          $promoCode = $this->assertPromoCodeExists($params->promo_code);
          return $this->promoCodeAddEdit($promoCode);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->promo_code)
		{
			$promoCode = $this->assertPromoCodeExists($params->promo_code);
		}
		else
		{
			$promoCode = $this->em()->create('Siropu\AdsManager:PromoCode');
		}

		$this->promoCodeSaveProcess($promoCode)->run();

		return $this->redirect($this->buildLink('ads-manager/promo-codes'));
     }
     public function actionDelete(ParameterBag $params)
     {
          $promoCode = $this->assertPromoCodeExists($params->promo_code);
          $plugin  = $this->plugin('XF:Delete');

          return $plugin->actionDelete(
               $promoCode,
               $this->buildLink('ads-manager/promo-codes/delete', $promoCode),
               $this->buildLink('ads-manager/promo-codes/edit', $promoCode),
               $this->buildLink('ads-manager/promo-codes'),
               $promoCode->promo_code
          );
     }
     public function actionToggle()
     {
          $plugin = $this->plugin('XF:Toggle');
		return $plugin->actionToggle('Siropu\AdsManager:PromoCode', 'enabled');
     }
     protected function promoCodeAddEdit(\Siropu\AdsManager\Entity\PromoCode $promoCode)
	{
          $viewParams = [
               'promoCode'    => $promoCode,
               'packages'     => $this->getPackageRepo()->getPackagesForSelect(),
               'userCriteria' => $this->app->criteria('XF:User', $promoCode->user_criteria),
          ];

          return $this->view('Siropu\AdsManager:PromoCode\Edit', 'siropu_ads_manager_promo_code_edit', $viewParams);
     }
     protected function promoCodeSaveProcess(\Siropu\AdsManager\Entity\PromoCode $promoCode)
	{
          $input = $this->filter([
               'promo_code'        => 'str',
               'value'             => 'float',
               'type'              => 'str',
               'package'           => 'array-uint',
               'invoice_amount'    => 'float',
               'active_date'       => 'datetime',
               'expire_date'       => 'datetime',
               'user_usage_limit'  => 'uint',
               'total_usage_limit' => 'uint',
               'user_criteria'     => 'array',
               'enabled'           => 'bool'
          ]);

          $form = $this->formAction();
          $form->basicEntitySave($promoCode, $input);

		return $form;
     }
     /**
      * @return \Siropu\AdsManager\Entity\Package
      */
     protected function assertPromoCodeExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:PromoCode', $id, $with, 'siropu_ads_manager_requested_promo_code_not_found');
     }
}
