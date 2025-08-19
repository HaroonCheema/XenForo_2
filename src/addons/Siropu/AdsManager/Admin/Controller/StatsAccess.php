<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;

class StatsAccess extends AbstractController
{
     public function actionIndex()
     {
          $viewParams = [
               'statsAccess' => $this->finder('Siropu\AdsManager:StatsAccess')->fetch()
          ];

          return $this->view('Siropu\AdsManager:StatsAccess', 'siropu_ads_manager_stats_access_list', $viewParams);
     }
     public function actionAdd()
     {
          $statsAccess = $this->em()->create('Siropu\AdsManager:StatsAccess');
          return $this->statsAccessAddEdit($statsAccess);
     }
     public function actionEdit(ParameterBag $params)
     {
          $statsAccess = $this->assertStatsAccessExists($params->access_key);
          return $this->statsAccessAddEdit($statsAccess);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->access_key)
		{
			$statsAccess = $this->assertStatsAccessExists($params->access_key);
		}
		else
		{
			$statsAccess = $this->em()->create('Siropu\AdsManager:StatsAccess');
               $statsAccess->access_key = $this->repository('Siropu\AdsManager:StatsAccess')->generateAccessKey();
		}

		$this->statsAccessSaveProcess($statsAccess)->run();

		return $this->redirect($this->buildLink('ads-manager/stats-access/link', $statsAccess));
     }
     public function actionLink(ParameterBag $params)
     {
          $statsAccess = $this->assertStatsAccessExists($params->access_key);

          $viewParams = [
               'statsAccess' => $statsAccess
          ];

          return $this->view('Siropu\AdsManager:StatsAccess\Link', 'siropu_ads_manager_stats_access_link', $viewParams);
     }
     public function actionDelete(ParameterBag $params)
     {
          $statsAccess = $this->assertStatsAccessExists($params->access_key);
          $plugin  = $this->plugin('XF:Delete');

          return $plugin->actionDelete(
               $statsAccess,
               $this->buildLink('ads-manager/stats-access/delete', $statsAccess),
               $this->buildLink('ads-manager/stats-access/edit', $statsAccess),
               $this->buildLink('ads-manager/stats-access'),
               $statsAccess->title
          );
     }
     protected function statsAccessAddEdit(\Siropu\AdsManager\Entity\StatsAccess $statsAccess)
     {
          $ads = $this->getAdRepo()
               ->findAdsForList()
               ->where('Extra.is_placeholder', 0)
               ->order('name', 'asc')
               ->fetch()
               ->pluckNamed('name', 'ad_id');

          $viewParams = [
               'statsAccess' => $statsAccess,
               'ads'         => $ads
          ];

          return $this->view('Siropu\AdsManager:Tool\StatsAccess', 'siropu_ads_manager_stats_access_edit', $viewParams);
     }
     protected function statsAccessSaveProcess(\Siropu\AdsManager\Entity\StatsAccess $statsAccess)
	{
          $input = $this->filter([
               'ad_list' => 'array-uint',
               'title'   => 'str',
          ]);

          $form = $this->formAction();
          $form->basicEntitySave($statsAccess, $input);

		return $form;
     }
     /**
     * @param string $id
     * @param array|string|null $with
     *
     * @return \Siropu\AdsManager\Entity\StatsAccess
     */
     protected function assertStatsAccessExists($id, $with = null)
     {
          return $this->assertRecordExists('Siropu\AdsManager:StatsAccess', $id, $with, 'siropu_ads_manager_requested_stats_access_not_found');
     }
}
