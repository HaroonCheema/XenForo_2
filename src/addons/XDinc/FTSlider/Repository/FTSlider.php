<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Repository;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Repository;

class FTSlider extends Repository
{
	public function findFTSlider()
	{
		$options = \XF::options();
		$orderType = $options->FTSliderOrderType;
		$orderBy = $options->FTSliderOrderBy;
		
		return $this->finder('XDinc\FTSlider:FTSlider')
			->with('Thread', true)
			->with('Thread.FirstPost', true)
			->order($orderType, $orderBy);
	}

	public function fetchFTSliderByThread($thread)
	{
		return $this->finder('XDinc\FTSlider:FTSlider')
			->where('thread_id', $thread->thread_id)
			->fetchOne();
	}

	public function parseFTSliders($ftsliders, $trim = 0)
	{
		foreach ($ftsliders AS &$ftslider)
		{
			$ftslider = $this->parseFTSlider($ftslider, $trim);
		}

		return $ftsliders;
	}

	public function parseFTSlider($ftslider, $trim = 0)
	{
		$options = \XF::options();
		$trim = !empty($trim) ? $trim : $options->FTSlider_limit;
		
		if (empty($ftslider->ftslider_excerpt))
		{
			$ftslider->ftslider_excerpt = $ftslider->Thread->FirstPost->message;
		}
		
		$ftslider->ftslider_excerpt = str_replace(["\r","\n"], ' ', $ftslider->ftslider_excerpt);
		
		$formatter = \XF::app()->stringFormatter();
		$ftslider->ftslider_excerpt = $formatter->snippetString($ftslider->ftslider_excerpt, $trim, ['stripBbCode' => true]);
		
		return $ftslider;
	}

	/*** Upload - Resize ***/	
	
	public function setFTSliderFromUpload($thread, $upload)
	{
		$upload->requireImage();

		if (!$upload->isValid($errors))
		{
			throw new \XF\PrintableException(reset($errors));
		}

		$target = 'data://FTSlider/'.$thread->thread_id.'.jpg';
		$dimensions = \XF::options()->FTSlider_size;
		$width = $dimensions['width'];
		$height = $dimensions['height'];
		try
		{
			$image = \XF::app()->imageManager->imageFromFile($upload->getTempFile());
			$ratio = $width / $height;
			$w = $image->getWidth();
			$h = $image->getHeight();
			
			if ($w / $h > $ratio)
			{
				$image->resizeTo($w * ($height / $h), $height);
			}
			else
			{
				$image->resizeTo($width, $h * ($width / $w));
			}

			$w = $image->getWidth();
			$h = $image->getHeight();
			$offWidth = ($w - $width) / 2;
			$offHeight = ($h - $height) / 2;

			$image->crop($width, $height, $offWidth, $offHeight);

			$tempFile = \XF\Util\File::getTempFile();
			if ($tempFile && $image->save($tempFile))
			{
				$output = $tempFile;
			}
			unset($image);

			\XF\Util\File::copyFileToAbstractedPath($output, $target);
		}
		catch (Exception $e)
		{
			throw new \XF\PrintableException(\XF::phrase('fts_slider_warning'));
		}
	}
}
