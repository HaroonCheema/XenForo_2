<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;

class PositionCategory extends AbstractController
{
     public function actionAdd(ParameterBag $params)
     {
          $positionCategory = $this->em()->create('Siropu\AdsManager:PositionCategory');
          return $this->positionCategoryAddEdit($positionCategory);
     }
     public function actionEdit(ParameterBag $params)
     {
          $positionCategory = $this->assertPositionCategoryExists($params->category_id);
          return $this->positionCategoryAddEdit($positionCategory);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->category_id)
		{
			$positionCategory = $this->assertPositionCategoryExists($params->category_id);
		}
		else
		{
			$positionCategory = $this->em()->create('Siropu\AdsManager:PositionCategory');
		}

		$this->positionCategorySaveProcess($positionCategory)->run();

		return $this->redirect($this->buildLink('ads-manager/positions'));
     }
     public function actionDelete(ParameterBag $params)
     {
          $positionCategory = $this->assertPositionCategoryExists($params->category_id);

          if ($this->isPost())
          {
               $positionCategory->delete();
               return $this->redirect($this->buildLink('ads-manager/positions'));
          }

          $viewParams = [
               'positionCategory' => $positionCategory
          ];

          return $this->view('Siropu\AdsManager:PositionCategory\Delete', 'siropu_ads_manager_position_category_delete', $viewParams);
     }
     protected function positionCategoryAddEdit(\Siropu\AdsManager\Entity\PositionCategory $positionCategory)
	{
          $viewParams = [
               'positionCategory' => $positionCategory
          ];

          return $this->view('Siropu\AdsManager:PositionCategory\Edit', 'siropu_ads_manager_position_category_edit', $viewParams);
     }
     protected function positionCategorySaveProcess(\Siropu\AdsManager\Entity\PositionCategory $positionCategory)
	{
          $input = $this->filter([
               'title'         => 'str',
               'description'   => 'str',
               'display_order' => 'uint'
          ]);

          $form = $this->formAction();
          $form->basicEntitySave($positionCategory, $input);

		return $form;
     }
     protected function assertPositionCategoryExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:PositionCategory', $id, $with, 'siropu_ads_manager_requested_position_category_not_found');
     }
}
