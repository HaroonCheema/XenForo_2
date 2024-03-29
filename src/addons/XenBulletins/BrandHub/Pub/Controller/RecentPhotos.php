<?php

namespace XenBulletins\BrandHub\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class RecentPhotos extends AbstractController
{
        protected function preDispatchController($action, ParameterBag $params)
	{
            if (!\XF::visitor()->hasPermission('bh_brand_hub','canViewRecentContent'))  throw $this->exception($this->noPermission());
	}

	public function actionIndex(ParameterBag $params)
	{
		if ($params->attachment_id)
		{
			return $this->rerouteController(__CLASS__, 'view', $params);
		}

		$linkFilters = [];

		$page = $this->filterPage();
		$perPage = 20;

		if ($this->request->exists('delete_attachments'))
		{
			return $this->rerouteController(__CLASS__, 'delete');
		}

		$attachmentRepo = $this->getAttachmentRepo();
		$attachmentFinder = $attachmentRepo->findAttachmentsForList()->limitByPage($page, $perPage);
                
                $contentType = 'bh_item';
                $attachmentFinder->where('content_type', $contentType);
                $linkFilters['content_type'] = $contentType;
                
                

		if ($username = $this->filter('username', 'str'))
		{
			$user = $this->finder('XF:User')->where('username', $username)->fetchOne();
			if ($user)
			{
				$attachmentFinder->where('Data.user_id', $user->user_id);
				$linkFilters['username'] = $user->username;
			}
		}

		if ($start = $this->filter('start', 'datetime'))
		{
			$attachmentFinder->where('attach_date', '>', $start);
			$linkFilters['start'] = $start;
		}

		if ($end = $this->filter('end', 'datetime'))
		{
			$attachmentFinder->where('attach_date', '<', $end);
			$linkFilters['end'] = $end;
		}

		if ($mode = $this->filter('mode', 'str'))
		{
			if ($mode == 'size')
			{
				$attachmentFinder->order('Data.file_size', 'DESC');
			}
			else if ($mode == 'recent')
			{
				$attachmentFinder->order('attach_date', 'DESC');
			}
			$linkFilters['mode'] = $mode;
		}

		if ($this->isPost())
		{
			return $this->redirect($this->buildLink('bh-recent-photos', null, $linkFilters), '');
		}

		$total = $attachmentFinder->total();
		$this->assertValidPage($page, $perPage, $total, 'bh-recent-photos');

		$viewParams = [
			'attachments' => $attachmentFinder->fetch(),
			'handlers' => $attachmentRepo->getAttachmentHandlers(),

			'page' => $page,
			'perPage' => $perPage,
			'total' => $total,

			'linkFilters' => $linkFilters,

			'datePresets' => \XF::language()->getDatePresets()
		];
		return $this->view('XF:Attachment\Listing', 'bh_attachment_list', $viewParams);
	}

	public function actionDelete(ParameterBag $params)
	{
          
		$linkFilters = $this->filter([
			'content_type' => 'str',
			'username' => 'str',
			'start' => 'datetime',
			'end' => 'datetime'
		]);
		$linkFilters = array_filter($linkFilters); // filter empty values

		$attachmentIds = $this->filter('attachment_ids', 'array-uint');
		if ($attachmentId = $this->filter('attachment_id', 'uint', $params->attachment_id))
		{
			$attachmentIds[] = $attachmentId;
		}
                

		if (!$attachmentIds)
		{
			return $this->redirect($this->buildLink('bh-recent-photos', null, $linkFilters));
		}

		if ($this->isPost() && !$this->request->exists('delete_attachments'))
		{
			foreach ($attachmentIds AS $attachmentId)
			{
				/** @var \XF\Entity\Attachment $attachment */
				$attachment = $this->em()->find('XF:Attachment', $attachmentId);
				$attachment->delete(false);
			}

			return $this->redirect($this->buildLink('bh-recent-photos', null, $linkFilters));
		}
		else
		{
			$viewParams = [
				'attachmentIds' => $attachmentIds,
				'linkFilters' => $linkFilters
			];
			if (count($attachmentIds) == 1)
			{
                            
                                            
				/** @var \XF\Entity\Attachment $attachment */
				$attachment = $this->em()->find('XF:Attachment', reset($attachmentIds));
                                
				if (!$attachment || !$attachment->Data || !$attachment->Data->isDataAvailable())
				{
					throw $this->exception($this->notFound());
				}
                                
				$viewParams['attachment'] = $attachment;
			}
			return $this->view('XF:Attachment\Delete', 'bh_attachment_delete', $viewParams);
		}
	}

	public function actionView(ParameterBag $params)
	{
		/** @var \XF\Entity\Attachment $attachment */
		$attachment = $this->em()->find('XF:Attachment', $params->attachment_id);
		if (!$attachment)
		{
			throw $this->exception($this->notFound());
		}

		if (!$attachment->Data || !$attachment->Data->isDataAvailable())
		{
			return $this->error(\XF::phrase('attachment_cannot_be_shown_at_this_time'));
		}

		$this->setResponseType('raw');

		$eTag = $this->request->getServer('HTTP_IF_NONE_MATCH');
		$return304 = ($eTag && $eTag == '"' . $attachment['attach_date'] . '"');

		$viewParams = [
			'attachment' => $attachment,
			'return304' => $return304
		];
		return $this->view('XF:Attachment\View', '', $viewParams);
	}

	public function actionOptions()
	{
		$group = $this->em()->find('XF:OptionGroup', 'attachments');
		if ($group)
		{
			return $this->redirectPermanently($this->buildLink('options/groups', $group));
		}
		else
		{
			return $this->redirect($this->buildLink('options'));
		}
	}

	/**
	 * @return \XF\Repository\Attachment
	 */
	protected function getAttachmentRepo()
	{
            return $this->repository('XF:Attachment');
	}
        
}