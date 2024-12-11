<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

	public function actionIndex(ParameterBag $params)
	{
		$reply = parent::actionIndex($params);
		
		if (!$reply instanceof \XF\Mvc\Reply\View)
		{
			return $reply;
		}
		
		$thread = $reply->getParam('thread');

		$reply->setParam('ftslider', $this->repository('XDinc\FTSlider:FTSlider')->fetchFTSliderByThread($thread));
		
		return $reply;
	}
	
	/*** Edit - FTSlider ***/	

	public function actionFTSliderEdit(ParameterBag $params)
	{
		if (!\XF::visitor()->hasPermission('FTSlider_permissions', 'FTSlider_submit'))
		{
			return $this->noPermission();
		}

		$thread = $this->assertViewableThread($params->thread_id);
		$ftsliderRepo = $this->repository('XDinc\FTSlider:FTSlider');
		$ftslider = $ftsliderRepo->fetchFTSliderByThread($thread);

		if ($ftslider && !$ftslider->canEdit())
		{
			return $this->noPermission();
		}

		if ($this->isPost())
		{
			if (!$ftslider)
			{
				$ftslider = $this->em()->create('XDinc\FTSlider:FTSlider');
			}

			if ($upload = $this->request->getFile('upload', false, false))
			{
				$ftsliderRepo->setFTSliderFromUpload($thread, $upload);
			}

			$input = $this->filter('ftslider', 'array');
			$input['thread_id'] = $thread->thread_id;
			$input['ftslider_title'] = !empty($input['ftslider_title']) ? $input['ftslider_title'] : '';
			$input['ftslider_excerpt'] = !empty($input['ftslider_excerpt']) ? $input['ftslider_excerpt'] : '';
			$date = $this->filter('date', 'datetime');
			$time = $this->filter('time', 'str');
			list ($hour, $min) = explode(':', $time);
			$dateTime = new \DateTime('@'.$date);
			$dateTime->setTimeZone(\XF::language()->getTimeZone());
			$dateTime->setTime($hour, $min);
			$input['ftslider_date'] = $dateTime->getTimestamp();
			$form = $this->formAction();
			$form->basicEntitySave($ftslider, $input);
			$form->run();

			return $this->redirect($this->buildLink('threads', $thread));
		}

		$viewParams = [
			'thread' => $thread,
			'ftslider' => $ftslider,
		];

		return $this->view('XDinc\FTSlider:Thread\FTSliderEdit', 'FTSlider_edit_block', $viewParams);
	}

	/*** Delete - FTSlider ***/	
			
	public function actionFTSliderDelete(ParameterBag $params)
	{
		$ftslider = $this->assertFTSliderExists($params->thread_id, 'Thread');

		if (!$ftslider->canEdit())
		{
			return $this->noPermission();
		}

		if (!$ftslider->preDelete())
		{
			return $this->error($ftslider->getErrors());
		}

		if ($this->isPost())
		{
			$ftslider->delete();
			return $this->redirect($this->buildLink('threads', $ftslider));
		}
		else
		{
			$viewParams = [
				'ftslider' => $ftslider
			];
			return $this->view('XDinc\FTSlider:FTSlider\Delete', 'FTSlider_delete', $viewParams);
		}
	}
	
	protected function assertFTSliderExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('XDinc\FTSlider:FTSlider', $id, $with, $phraseKey);
	}

}