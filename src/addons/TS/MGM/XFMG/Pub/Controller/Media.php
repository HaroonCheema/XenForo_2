<?php

namespace TS\MGM\XFMG\Pub\Controller;

use XF\Mvc\ParameterBag;

class Media extends XFCP_Media {
	
	
	protected function prepareMediaInput(array $rawInput)
	{
		
		$input = parent::prepareMediaInput($rawInput);
		
		$editorPlugin = $this->plugin('XF:Editor');
		$bbCode = $editorPlugin->convertToBbCode($input['description']);
		$input['description'] = $bbCode;
		$input += $this->app->inputFilterer()->filterArray($rawInput, [
					'additional' => 'array'
		]);
		
		return $input;
		
	}
	
	protected function finalizeMediaItemEdit(\XFMG\Service\Media\Editor $editor) {
		
		parent::finalizeMediaItemEdit($editor);
		$editor->createAdditionalCategories();
		
	}
	
	protected function setupMediaItemEdit(\XFMG\Entity\MediaItem $mediaItem)
	{	
	
		$editor = parent::setupMediaItemEdit($mediaItem);
		
		$title = $editor->getMediaItem()->title;
		
		$editorPlugin = $this->plugin('XF:Editor');
		$description = $editorPlugin->fromInput('description');
		
		$additional = $this->filter('additional', 'array');
		$editor->setAdditionalCategories($additional);

		$editor->setTitle($title, $description);
		
		return $editor;
	}

	protected function finalizeMediaChange(ParameterBag $params, $oldMediaItem) {
		
		$this->assertPostOnly();

		$mediaInput = $this->filter('media', 'array');
		if (!$mediaInput)
		{
			return $this->error(\XF::phrase('xfmg_ensure_you_have_added_at_least_one_media_item_before_continuing'));
		}
		
		$mediaInput = array_slice($mediaInput, 0, 1, true);
		
		$container = $this->getContainerToSaveMedia();

		/** @var \XFMG\Service\Media\Creator[] $creators */
		$creators = [];

		/** @var \XFMG\Service\Media\TranscodeEnqueuer[] $enqueuers */
		$enqueuers = [];

		$errors = [];

		foreach ($mediaInput AS $mediaTempId => $input)
		{
			/** @var \XFMG\Entity\MediaTemp $mediaTemp */
			$mediaTemp = $this->em()->find('XFMG:MediaTemp', $mediaTempId);
			$input = $this->prepareMediaInput($input);
			if (!$mediaTemp || $mediaTemp->media_hash !== $input['media_hash'])
			{
				continue;
			}

			if (($mediaTemp->media_type == 'video' || $mediaTemp->media_type == 'audio')
				&& $mediaTemp->requires_transcoding
			)
			{
				$enqueuer = $this->setupTranscodeQueue($mediaTemp, $container, $input);
				if ($enqueuer->validate($errors))
				{
					$enqueuers[] = $enqueuer;
				}
				else
				{
					break;
				}
			}
			else
			{
				$creator = $this->setupMediaItemCreate($mediaTemp, $container, $input);
				$creator->checkForSpam();
				if ($creator->validate($errors))
				{
					$creators[] = $creator;
				}
				else
				{
					break;
				}
			}
		}

		if ($errors)
		{
			return $this->error($errors);
		}

		$session = $this->session();
		foreach ($creators AS $creator)
		{
			$attachment = $this->em()->find('XF:Attachment', $input['attachment_id'], 'Data');
			$mediaItem = $oldMediaItem;
			
			if($mediaItem->Attachment) {
				$mediaItem->Attachment->content_id = 0;
				$mediaItem->Attachment->temp_hash = "temp";
				$mediaItem->Attachment->save();
				$mediaItem->Attachment->delete();
			}
			
			$mediaItem->hydrateRelation('Attachment', $attachment);

			$this->app()->db()->update('xf_attachment', [
				'content_id' => $mediaItem->media_id,
				'temp_hash' => '',
				'unassociated' => 0
			], 'attachment_id = ?', $attachment->attachment_id);

			$attachment->getHandler()->onAssociation($attachment, $mediaItem);
			$thumbChanger = $this->service("XFMG:Media\ThumbnailChanger", $mediaItem);
			// Driven2Services.com - located bug and resolved it.  Function name changed in new versions of Media Gallery
			//$changed = $thumbChanger->useDefaultAvatar();
			$changed = $thumbChanger->useDefaultThumbnail();      
			$mediaItem->save();
			
		}

		foreach ($enqueuers AS $enqueuer)
		{
			$enqueuer->save();
			$this->finalizeTranscodeQueue($enqueuer);

			if (!$session->keyExists('xfmgTranscoding'))
			{
				$session->set('xfmgTranscoding', true);
			}
		}

		if (count($creators) && !count($enqueuers))
		{
			$firstCreator = reset($creators);
			$redirect = $this->buildLink('media', $mediaItem);
		}
		else
		{
			if ($container instanceof \XFMG\Entity\Category)
			{
				$redirect = $this->buildLink('media/categories', $container);
			}
			else if ($container instanceof \XFMG\Entity\Album && $container->isVisible())
			{
				$redirect = $this->buildLink('media/albums', $container);
			}
			else
			{
				$redirect = $this->buildLink('media');
			}
		}
		
		return $this->redirect($redirect);
	}		
		
		
	public function actionEdit(ParameterBag $params)
	{
		if($this->isPost())
			return parent::actionEdit($params);
		
		$mediaItem = $this->assertViewableMediaItem($params->media_id);
		
		if (!$mediaItem->canEdit($error))
		{
			return $this->noPermission();
		}
		
		$viewParams = parent::actionEdit($params)->getParams();
		
		$categoryRepo = $this->repository("XFMG:Category");
		$categoryList = $categoryRepo->getViewableCategories();
		$categoryTree = $categoryRepo->createCategoryTree($categoryList);
		$categoryExtras = $categoryRepo->getCategoryListExtras($categoryTree);
		$categoryAddTree = $categoryTree->filter(null, function($id, \XFMG\Entity\Category $category, $depth, $children, \XF\Tree $tree)
		{
			return ($children || $category->canAddMedia());
		});		
		$additionalCategories = [];
		
		foreach($categoryAddTree as $subTree) {
			
			$cat = $subTree["record"];
			
			if($cat->category_id != $mediaItem->category_id)
				$additionalCategories[] = $cat;
			
				
			if($cat->hasChildren()) {
				
				foreach($categoryRepo->findChildren($cat) as $child) {
					if($child->canView() && $child->category_id != $mediaItem->category_id)
						$additionalCategories[] = $child;
				}
					
			}
				
		}
		
		$viewParams["additional"] = $additionalCategories;
		return $this->view('XFMG:Media\Edit', 'xfmg_media_edit', $viewParams);
			
	}
	public function actionChangeMedia(ParameterBag $params) {
		
		$visitor = \XF::visitor();
		$extraWith = ['Category'];
		
		if ($visitor->user_id)
		{
			$extraWith[] = 'Category.Permissions|' . $visitor->permission_combination_id;
			$extraWith[] = 'DraftComments|' . $visitor->user_id;
			$extraWith[] = 'CommentRead|' . $visitor->user_id;
			$extraWith[] = 'Viewed|' . $visitor->user_id;
			$extraWith[] = 'Watch|' . $visitor->user_id;
		}
		
		$mediaItem = $this->assertViewableMediaItem($params->media_id, $extraWith);
		
		if(!$visitor->user_id === $mediaItem->user_id && !$visitor->hasPermission("xfmg", "canChangeAny"))
			return $this->noPermission();
		
		$category = $mediaItem->Category;

		if (!$category || !$category->canAddMedia($error))
		{
			return $this->noPermission();
		}
		
		if($this->isPost()) {
			
			return $this->finalizeMediaChange($params, $mediaItem);
			
			
		}
		
		$album = null;
		if ($category->category_type == 'album')
		{
			$album = $this->em()->create('XFMG:Album');
			$album->category_id = $category->category_id;
		}

		/** @var \XF\Repository\Attachment $attachmentRepo */
		$attachmentRepo = $this->repository('XF:Attachment');
		$attachmentData = $attachmentRepo->getEditorData('xfmg_media', $category);

		$viewParams = [
			'category' => $category,
			'album' => $album,
			'attachmentData' => $attachmentData,
			'mediaItem' => $mediaItem
		];
		return $this->view('XFMG:Category\Add', 'ts_mgm_xfmg_category_add', $viewParams);
		
		
	}
	
	protected function setupMediaItemCreate(\XFMG\Entity\MediaTemp $mediaTemp, \XF\Mvc\Entity\Entity $container, array $input) {
		
		$creator = parent::setupMediaItemCreate($mediaTemp, $container, $input);
		
		if($input['additional'])
			$creator->setAdditionalCategories($input['additional']);
		
		return $creator;		
	}
	
	protected function finalizeMediaItemCreate(\XFMG\Service\Media\Creator $creator)
	{	
		parent::finalizeMediaItemCreate($creator);
		$creator->createAdditionalCategories();
	}
}