<?php

namespace Siropu\AdsManager\Service\Ad;

class Preparer extends \XF\Service\AbstractService
{
	protected $ad;
	protected $input = [];
	protected $errors = [];
     protected $files = [];
	protected $isValid = false;
	protected $uploads;
	protected $isAcp;

	public function __construct(\XF\App $app, \Siropu\AdsManager\Entity\Ad $ad, array $input, $isAcp = true)
	{
		parent::__construct($app);

		$this->ad      = $ad;
		$this->input   = $input;
		$this->uploads = $this->app->request->getFile('upload', true, false);
		$this->isAcp   = $isAcp;
	}
	public function runValidation()
	{
		$options = \XF::options();

		if ($this->ad->isOfType(['code', 'banner', 'text', 'link'])
			&& $this->isAcp
			&& empty($this->input['position'])
			&& !$this->input['inherit_package'])
		{
			$this->errors[] = \XF::phrase('siropu_ads_manager_please_select_position');
		}

          if ($this->ad->isOfType(['code', 'banner', 'text', 'popup']) && !$this->isAcp)
          {
               $content = $this->input['content_1'] ?: (isset($this->input['content_2']) ? $this->input['content_2'] : '');

               if (preg_match('@(<xf:(.+?(?:</xf:[a-z]+>|/>))?|{\$.+?}|{{.+?}})@is', $content, $match))
               {
                    $this->errors[] = \XF::phrase('siropu_ads_manager_syntax_not_allowed', ['syntax' => $match[1]]);
               }
          }

		if ($this->ad->isCode())
		{
			if (empty($this->input['content_1']))
			{
				$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_code');
			}
			else
			{
				$this->ad->content_1 = $this->input['content_1'];

				if ($this->ad->isCallback())
				{
					if (preg_match('/^callback=([\w\\\\]+)::([\w]+)/i', $this->input['content_1'], $match))
					{
						if (!\XF\Util\Php::validateCallbackPhrased($match[1], $match[2], $error))
						{
							$this->errors[] = $error;
						}
					}
					else
					{
						$this->errors[] = \XF::phrase('invalid_callback');
					}
				}
			}
		}

		if ($this->ad->isOfType(['banner', 'background'])
               && !($this->ad->hasBanner()
                    || array_filter($this->input['banner_url'])
                    || $this->input['content_2']
                    || $this->uploads))
		{
               if ($this->ad->isBackground())
               {
                    $this->errors[] = \XF::phrase('siropu_ads_manager_please_provide_valid_image');
               }
               else
               {
                    $this->errors[] = \XF::phrase('siropu_ads_manager_please_provide_valid_banner');
               }
		}

		if (in_array($this->ad->type, ['text', 'link']))
		{
			$maxTitleLength = $options->siropuAdsManagerMaxAdTitleLength;

			if (empty($this->input['title']))
			{
				$this->errors[] = \XF::phrase('please_enter_valid_title');
			}
			else if (!$this->isAcp && strlen($this->input['title']) > $maxTitleLength)
			{
				$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_title_that_is_at_most_x_characters_long',
					['count' => $maxTitleLength]);
			}
		}

		if ($this->ad->isText())
		{
			$maxDescriptionLength = $options->siropuAdsManagerMaxAdDescriptionLength;

			if (empty($this->input['content_1']))
			{
				$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_description');
			}
			else if (!$this->isAcp && strlen($this->input['content_1']) > $maxDescriptionLength)
			{
				$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_description_that_is_at_most_x_characters_long',
					['count' => $maxDescriptionLength]);
			}
		}

		if ($this->ad->isKeyword())
		{
               $itemArray = isset($this->input['item_array']) ? $this->input['item_array'] : [];

               if (!empty($itemArray))
               {
                    $itemArray = array_filter($this->input['item_array'], function($item)
                    {
                         return (trim($item['keyword']) && trim($item['url']));
                    });
               }

			if (empty($this->input['content_1']) && empty($itemArray) && ($this->ad->isInsert() || $this->isAcp))
			{
				$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_keyword');
			}

			if (empty($this->input['target_url']) && empty($itemArray) && !$this->isAcp)
			{
				$this->errors[] = \XF::phrase('please_enter_valid_url');
			}

			$keywordDescriptionLength = $options->siropuAdsManagerKeywordDescription;

			if ($keywordDescriptionLength && strlen($this->input['title']) > $keywordDescriptionLength)
			{
				$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_title_that_is_at_most_x_characters_long',
					['count' => $keywordDescriptionLength]);
			}

               if (!empty($this->input['content_1']))
               {
                    if (!$this->isAcp)
                    {
                         $disallowed = $options->siropuAdsManagerDisallowedKeywords;

                         if (!empty($disallowed))
                         {
                              $disallowedKeywordsRegex = \Siropu\AdsManager\Util\Arr::getItemsForRegex($disallowed);

                              if (preg_match("/{$disallowedKeywordsRegex}/i", $this->input['content_1'], $matches))
                              {
                                   $this->errors[] = \XF::phrase('siropu_ads_manager_keywords_not_allowed',
                                        ['keywords' => implode(', ', $matches)]);
                              }
                         }

                         $keywordListArray = \Siropu\AdsManager\Util\Arr::getItemArray($this->input['content_1'], false, "\n");
                         $maxWords         = $options->siropuAdsManagerKeywordMaxWords;

                         foreach ($keywordListArray as $keyword)
                         {
                              if (count(preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY)) > $maxWords)
                              {
                                   $this->errors[] = \XF::phrase('siropu_ads_manager_max_words_in_keyword_is_x', ['limit' => $maxWords]);
                                   break;
                              }
                         }
                    }

                    $approver = $this->service('Siropu\AdsManager:Ad\Approver', $this->ad);
                    $approver->setKeywords($this->input['content_1']);
                    $approver->verifyExclusiveKeywords($error);

                    if ($error)
                    {
                         $this->errors[] = $error;
                    }
               }
		}

		if ($this->ad->isAffiliate())
		{
               switch ($this->input['content_2'])
               {
                    case 'to_aff':
                         if (empty($this->input['content_3']))
                         {
                              $this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_param');
                         }
                         break;
                    case 'aff_to':
                    case 'replace':
                         if (empty($this->input['content_3']))
                         {
                              $this->errors[] = \XF::phrase('please_enter_valid_url');
                         }
                         break;
                    case 'params':
                         if (empty($this->input['content_4']))
                         {
                              $this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_params');
                         }
                         break;
                    case 'callback':
                         if (preg_match('/^([\w\\\\]+)::([\w]+)$/i', $this->input['content_3'], $match))
                         {
                              if (!\XF\Util\Php::validateCallbackPhrased($match[1], $match[2], $error))
                              {
                                   $this->errors[] = $error;
                              }
                         }
                         else
                         {
                              $this->errors[] = \XF::phrase('invalid_callback');
                         }
                         break;
               }
		}

		if (empty($this->input['target_url'])
			&& ($this->ad->isOfType(['text', 'link', 'background']) || $this->ad->isBanner() && !$this->input['content_2']))
		{
			$this->errors[] = \XF::phrase('please_enter_valid_url');
		}

		$itemId = !empty($this->input['item_id']) ? $this->input['item_id'] : $this->ad->item_id;

		if ($this->ad->isSticky() && !$this->em()->find('XF:Thread', $itemId))
		{
			$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_thread');
		}

		if ($this->ad->isResource() && !$this->em()->find('XFRM:ResourceItem', $itemId))
		{
			$this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_resource');
		}

          if ($this->ad->canEditPromoThread())
          {
               if (empty($this->input['content_1']))
               {
                    $this->errors[] = \XF::phrase('siropu_ads_manager_please_select_a_forum');
               }
               else
               {
                    $approver = $this->service('Siropu\AdsManager:Ad\Approver');
                    $approver->setPackageId($this->ad->package_id);
                    $approver->setNodeId($this->input['content_1']);
                    $approver->verifyPromoThreadUserForumLimit($error1);

                    if ($error1)
                    {
                         $this->errors[] = $error1;
                    }

                    if ($this->app->request->filter('sticky', 'bool'))
                    {
                         $approver->verifyEmptyPromoThreadStickySlots($error2);

                         if ($error2)
                         {
                              $this->errors[] = $error2;
                         }
                    }
               }

               if (empty($this->input['content_2']))
               {
                    $this->errors[] = \XF::phrase('please_enter_valid_title');
               }

               if (empty($this->input['content_3']))
               {
                    $this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_content');
               }
          }

          if ($this->ad->isPopup())
          {
               if (!$this->isAcp && !empty($this->input['content_1']) && preg_match('/on[a-zA-Z]+=/', $this->input['content_1']))
               {
                    $this->errors[] = \XF::phrase('siropu_ads_manager_js_events_are_not_allowed');
               }

               if (empty($this->input['title'])
                    && empty($this->input['content_1'])
                    && empty($this->input['content_2'])
                    && empty($this->input['target_url']))
               {
                    $this->errors[] = \XF::phrase('siropu_ads_manager_cannot_submit_empty_popup');
               }
               else
               {
                    if (!empty($this->input['title']) && empty($this->input['content_1']))
                    {
                         $this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_popup_content');
                    }
                    else if (!empty($this->input['content_1']) && empty($this->input['title']))
                    {
                         $this->errors[] = \XF::phrase('siropu_ads_manager_please_enter_valid_popup_title');
                    }
               }
          }

		if ($this->uploads)
		{
			$extensions = $options->siropuAdsManagerAllowedBannerTypes;

			if (!empty($extensions['jpg']))
			{
				$extensions += ['jpe' => 1, 'jpeg' => 1];
			}

               if ($this->isAcp)
               {
                    $extensions['svg'] = 1;
                    $extensions['webp'] = 1;
                    $extensions['gif'] = 1;
                    $extensions['mp4'] = 1;
                    $extensions['swf'] = 1;
               }

               $maxImageSize = $options->siropuAdsManagerMaxImageSize;

               if ($this->ad->isBackground())
               {
                    if (isset($extensions['swf']))
                    {
                         unset($extensions['swf']);
                    }

                    $maxImageSize = $options->siropuAdsManagerMaxBgImageSize;
               }

			$constraints = [
				'extensions' => array_keys($extensions),
				'size'       => $this->isAcp ? null : $maxImageSize * 1024
			];

               $allowedSizes = $this->ad->Package ? $this->ad->Package->settings['ad_allowed_sizes'] : null;

			foreach ($this->uploads as $upload)
               {
                    if ($upload->getExtension() == 'mp4')
                    {
                         $allowedSizes = null;
                    }

				if ($allowedSizes)
				{
                         $uploadDimension = "{$upload->getImageWidth()}x{$upload->getImageHeight()}";

                         if (!in_array($uploadDimension, $allowedSizes))
                         {
                              $this->errors[] = \XF::phrase('siropu_ads_manager_allowed_dimensions_are_x',
                                   ['dimensions' => implode(', ', $allowedSizes)]);
     					break;
                         }
				}

				$upload->applyConstraints($constraints);

				if (!$upload->isValid($errors))
				{
					$this->errors[] = reset($errors);
					break;
				}
			}
		}

		if (empty($this->errors))
		{
			$this->isValid = true;
		}
	}
	public function isValid()
	{
		return $this->isValid;
	}
	public function getErrors()
	{
		return $this->errors;
	}
	public function saveFiles()
	{
          if ($this->uploads)
          {
			$this->files = $this->ad->banner_file;
               $i = 1;

               foreach ($this->uploads as $upload)
               {
				try
				{
					$fileName = sprintf('%s.%s', uniqid($i++), $upload->getExtension());
					\XF\Util\File::copyFileToAbstractedPath($upload->getTempFile(), "data://{$this->ad->getBannerDirName()}/$fileName");

                         $height = $upload->getImageHeight();
                         $width  = $upload->getImageWidth();

					$this->files[] = $fileName;
				}
				catch (\Exception $e) {}
               }

			$this->ad->set('banner_file', $this->files, ['forceSet' => true]);
          }
	}
     public function deleteFiles()
     {
          if ($this->ad->isInsert() && $this->files)
          {
               foreach ($this->files as $file)
               {
                    \XF\Util\File::deleteFromAbstractedPath("data://{$this->ad->getBannerDirName()}/{$file}");
               }
          }
     }
}
