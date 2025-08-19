<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;

class Position extends AbstractController
{
     public function actionIndex()
     {
          $type = $this->filter('type', 'str');

          $viewParams = [
               'positionData' => $this->getPositionRepo()->getPositionListData($type),
               'type'         => $type
          ];

          return $this->view('Siropu\AdsManager:Position\List', 'siropu_ads_manager_position_list', $viewParams);
     }
     public function actionAdd(ParameterBag $params)
     {
          $position = $this->em()->create('Siropu\AdsManager:Position');
          return $this->positionAddEdit($position);
     }
     public function actionEdit(ParameterBag $params)
     {
          $position = $this->assertPositionExists($params->position_id);
          return $this->positionAddEdit($position);
     }
     public function actionSort(ParameterBag $params)
     {
          if ($this->isPost())
          {
               $positions = $this->finder('Siropu\AdsManager:Position')->fetch();

               foreach ($this->filter('positions', 'array-json-array') AS $positionInCategory)
               {
                    $lastOrder = 0;

                    foreach ($positionInCategory AS $key => $positionValue)
                    {
                         if (!isset($positionValue['id']) || !isset($positions[$positionValue['id']]))
                         {
                              continue;
                         }

                         $lastOrder += 10;

                         $position = $positions[$positionValue['id']];
                         $position->category_id = $positionValue['parent_id'];
                         $position->display_order = $lastOrder;
                         $position->saveIfChanged();
                    }
               }

               return $this->redirect($this->buildLink('ads-manager/positions'));
          }

          $viewParams = [
               'positionData' => $this->getPositionRepo()->getPositionListData()
          ];

          return $this->view('Siropu\AdsManager:Position\Sort', 'siropu_ads_manager_position_sort', $viewParams);
     }
     public function actionReset(ParameterBag $params)
     {
          if ($this->isPost())
          {
               $this->getPositionCategoryRepo()->resetPostionCategories();
               $this->getPositionRepo()->resetPositions();

               return $this->redirect($this->buildLink('ads-manager/positions'));
          }

          return $this->view('Siropu\AdsManager:Position\Reset', 'siropu_ads_manager_position_reset');
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->position_id)
		{
			$position = $this->assertPositionExists($params->position_id);
		}
		else
		{
			$position = $this->em()->create('Siropu\AdsManager:Position');
		}

		$this->positionSaveProcess($position)->run();

		return $this->redirect($this->buildLink('ads-manager/positions/usage', $position));
     }
     public function actionUsage(ParameterBag $params)
     {
          $position = $this->assertPositionExists($params->position_id);

          $viewParams = [
               'position' => $position
          ];

          return $this->view('Siropu\AdsManager:Position\Usage', 'siropu_ads_manager_position_usage', $viewParams);
     }
     public function actionDelete(ParameterBag $params)
     {
          $position = $this->assertPositionExists($params->position_id);
          $plugin  = $this->plugin('XF:Delete');

          return $plugin->actionDelete(
               $position,
               $this->buildLink('ads-manager/positions/delete', $position),
               $this->buildLink('ads-manager/positions/edit', $position),
               $this->buildLink('ads-manager/positions'),
               $position->title
          );
     }
     public function actionTopPerforming()
     {
          $orderField = $this->filter('order_field', 'str');
          $orderDir   = $this->filter('order_direction', 'str');

          $viewParams = [
               'positions' => $this->getDailyStatsRepo()->getTopPerformingPositions($orderField, $orderDir),
               'order'     => [
                    'field'     => $orderField,
                    'direction' => $orderDir
               ]
          ];

          return $this->view('Siropu\AdsManager:Position\Top', 'siropu_ads_manager_position_top_performing', $viewParams);
     }
     protected function positionAddEdit(\Siropu\AdsManager\Entity\Position $position)
	{
          $viewParams = [
               'position'           => $position,
               'positionCategories' => $this->getPositionCategoryRepo()->getPositionCategoryTitlePairs()
          ];

          return $this->view('Siropu\AdsManager:Position\Edit', 'siropu_ads_manager_position_edit', $viewParams);
     }
     protected function positionSaveProcess(\Siropu\AdsManager\Entity\Position $position)
	{
          $input = $this->filter([
               'position_id'   => 'str',
               'title'         => 'str',
               'description'   => 'str',
               'category_id'   => 'uint',
               'display_order' => 'uint'
          ]);

          $form = $this->formAction();
          $form->basicEntitySave($position, $input);

		return $form;
     }
     protected function assertPositionExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:Position', $id, $with, 'siropu_ads_manager_requested_position_not_found');
     }
     /**
      * @return \Siropu\AdsManager\Repository\PromoCode
      */
     public function getDailyStatsRepo()
     {
          return $this->repository('Siropu\AdsManager:DailyStats');
     }
}
