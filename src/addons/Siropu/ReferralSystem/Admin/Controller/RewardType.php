<?php

namespace Siropu\ReferralSystem\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class RewardType extends AbstractController
{
     public function actionIndex(ParameterBag $params)
     {
          $finder = $this->getRewardTypeRepo()->findRewardTypesForList();

          $viewParams = [
               'rewardTypes' => $finder->fetch(),
               'total'       => $finder->total()
          ];

          return $this->view('Siropu\ReferralSystem:RewardType', 'siropu_referral_system_reward_type_list', $viewParams);
     }
     public function actionAdd(ParameterBag $params)
     {
          $rewardType = $this->em()->create('Siropu\ReferralSystem:RewardType');
          $rewardType->type = $this->filter('type', 'str');

          if ($rewardType->isDbTechCredits() && !$this->em()->find('XF:AddOn', 'DBTech/Credits'))
          {
               return $this->error(\XF::phrase('siropu_referral_system_dbtech_credits_not_installed'));
          }

          return $this->rewardTypeAddEdit($rewardType);
     }
     public function actionEdit(ParameterBag $params)
     {
          $rewardType = $this->assertRewardTypeExists($params->reward_type_id);
          return $this->rewardTypeAddEdit($rewardType);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->reward_type_id)
		{
			$rewardType = $this->assertRewardTypeExists($params->reward_type_id);
		}
		else
		{
			$rewardType = $this->em()->create('Siropu\ReferralSystem:RewardType');
               $rewardType->type = $this->filter('type', 'str');
		}

		$this->rewardTypeSaveProcess($rewardType)->run();

		return $this->redirect($this->buildLink('referral-system/reward-types'));
     }
     public function actionDelete(ParameterBag $params)
     {
          $rewardType = $this->assertRewardTypeExists($params->reward_type_id);
          $plugin     = $this->plugin('XF:Delete');

          return $plugin->actionDelete(
               $rewardType,
               $this->buildLink('referral-system/reward-types/delete', $rewardType),
               $this->buildLink('referral-system/reward-types/edit', $rewardType),
               $this->buildLink('referral-system/reward-types/'),
               $rewardType->name
          );
     }
     public function getRewardTypeRepo()
     {
          return $this->repository('Siropu\ReferralSystem:RewardType');
     }
     protected function rewardTypeAddEdit(\Siropu\ReferralSystem\Entity\RewardType $rewardType)
	{
          $viewParams = [
               'rewardType' => $rewardType,
               'currencies' => []
          ];

          if ($rewardType->isDbTechCredits())
          {
               $addon = $this->em()->find('XF:AddOn', 'DBTech/Credits');

               if ($addon->version_id >= 905010031)
               {
                    $currencies = \XF::repository('DBTech\Credits:Currency')->findCurrenciesForList(true);

                    foreach ($currencies as $currency)
                    {
                         $viewParams['currencies'][$currency->currency_id] = $currency->title;
                    }
               }
               else
               {
                    $currencies = \DBTech\Credits\Application\App::em()->findCached('DBTech\Credits:Currency');

                    foreach ($currencies as $currencyId => $currency)
                    {
                         $viewParams['currencies'][$currencyId] = $currency->getTitle();
                    }
               }
          }

          return $this->view('Siropu\ReferralSystem:RewardType\Edit', 'siropu_referral_system_reward_type_edit', $viewParams);
     }
     protected function rewardTypeSaveProcess(\Siropu\ReferralSystem\Entity\RewardType $rewardType)
	{
          $input = $this->filter([
               'name'     => 'str',
               'currency' => 'str'
          ]);

          $form = $this->formAction();
          $form->basicEntitySave($rewardType, $input);

          $form->validate(function(FormAction $form) use ($rewardType)
          {
               if (!$rewardType->type)
               {
                    $form->logError(\XF::phrase('siropu_referral_system_reward_type_not_found'));
               }
          });

		return $form;
     }
     protected function assertRewardTypeExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\ReferralSystem:RewardType', $id, $with, 'siropu_referral_system_reward_type_not_found');
     }
}
