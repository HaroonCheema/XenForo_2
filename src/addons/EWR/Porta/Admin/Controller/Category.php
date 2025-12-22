<?php

namespace EWR\Porta\Admin\Controller;

use XF\Mvc\ParameterBag;

class Category extends \XF\Admin\Controller\AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('EWRporta');
	}
	
	public function actionIndex(ParameterBag $params)
	{
		$categoryRepo = $this->getCategoryRepo();
		$entries = $categoryRepo->findCategory();

		$viewParams = [
			'categories' => $entries->fetch(),
			'total' => $entries->total(),
		];
		return $this->view('EWR\Porta:Category\List', 'EWRporta_category_list', $viewParams);
	}
	
	public function actionEdit(ParameterBag $params)
	{
		$category = $this->assertCategoryExists($params->category_id);
		
		$styleRepo = $this->repository('XF:Style');
		$styleTree = $styleRepo->getStyleTree(false);
		
		$viewParams = [
			'category' => $category,
			'styleTree' => $styleTree,
		];
		
		return $this->view('EWR\Porta:Category\Edit', 'EWRporta_category_edit', $viewParams);
	}
	
	public function actionAdd()
	{
		$styleRepo = $this->repository('XF:Style');
		$styleTree = $styleRepo->getStyleTree(false);
		
		$viewParams = [
			'styleTree' => $styleTree,
		];
		
		return $this->view('EWR\Porta:Category\Edit', 'EWRporta_category_edit', $viewParams);
	}
	
	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();
		
		if ($params->category_id)
		{
			$category = $this->assertCategoryExists($params->category_id);
		}
		else
		{
			$category = $this->em()->create('EWR\Porta:Category');
		}
		
		$input = $this->filter('category', 'array');
		$input['style_id'] = !empty($input['style_id']) ? $input['style_id'] : 0;
		
		$form = $this->formAction();
		$form->basicEntitySave($category, $input);
		$form->run();
		
		return $this->redirect($this->buildLink('ewr-porta/categories'));
	}
	
	public function actionDelete(ParameterBag $params)
	{
		$category = $this->assertCategoryExists($params->category_id);

		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$category,
			$this->buildLink('ewr-porta/categories/delete', $category),
			$this->buildLink('ewr-porta/categories/edit', $category),
			$this->buildLink('ewr-porta/categories'),
			$category->category_name
		);
	}
	
	protected function assertCategoryExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('EWR\Porta:Category', $id, $with, $phraseKey);
	}
	
	protected function getCategoryRepo()
	{
		return $this->repository('EWR\Porta:Category');
	}
}