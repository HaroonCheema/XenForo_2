<?php

namespace EWR\Porta\Admin\Controller;

use XF\Mvc\ParameterBag;

class Author extends \XF\Admin\Controller\AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('EWRporta');
	}
	
	public function actionIndex(ParameterBag $params)
	{
		$authorRepo = $this->getAuthorRepo();
		$entries = $authorRepo->findAuthor();

		$viewParams = [
			'authors' => $entries->fetch(),
			'total' => $entries->total(),
		];
		return $this->view('EWR\Porta:Author\List', 'EWRporta_author_list', $viewParams);
	}
	
	public function actionEdit(ParameterBag $params)
	{
		$author = $this->assertAuthorExists($params->user_id, 'User');
		
		$viewParams = [
			'author' => $author,
		];
		
		return $this->view('EWR\Porta:Author\Edit', 'EWRporta_author_edit', $viewParams);
	}
	
	public function actionAdd()
	{
		return $this->view('EWR\Porta:Author\Edit', 'EWRporta_author_edit');
	}
	
	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();
		
		if ($params->user_id)
		{
			$author = $this->assertAuthorExists($params->user_id);
		}
		else
		{
			$author = $this->em()->create('EWR\Porta:Author');
			
			$username = $this->filter('username', 'str');
			$user = $this->em()->findOne('XF:User', ['username' => $username]);
			
			if (!$user)
			{
				return $this->error(\XF::phrase('requested_user_not_found'));
			}
			
			$author->user_id = $user->user_id;
		}
		
		if ($upload = $this->request->getFile('upload', false, false))
		{
			$this->getAuthorRepo()->setAuthorFromUpload($author, $upload);
		}
		
		$input = $this->filter('author', 'array');
		$input['author_byline'] = $this->plugin('XF:Editor')->fromInput('byline');
		
		$form = $this->formAction();
		$form->basicEntitySave($author, $input);
		$form->run();
		
		return $this->redirect($this->buildLink('ewr-porta/authors'));
	}
	
	public function actionDelete(ParameterBag $params)
	{
		$author = $this->assertAuthorExists($params->user_id);

		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$author,
			$this->buildLink('ewr-porta/authors/delete', $author),
			$this->buildLink('ewr-porta/authors/edit', $author),
			$this->buildLink('ewr-porta/authors'),
			$author->author_name
		);
	}
	
	protected function assertAuthorExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('EWR\Porta:Author', $id, $with, $phraseKey);
	}
	
	protected function getAuthorRepo()
	{
		return $this->repository('EWR\Porta:Author');
	}
}