<?php

namespace EWR\Porta\Repository;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Repository;

class Feature extends Repository
{
	public function findFeature()
	{
		return $this->finder('EWR\Porta:Feature')
			->with('Thread', true)
			->with('Thread.FirstPost', true)
			->order('feature_date', 'DESC');
	}
	
	public function fetchFeatureByThread($thread)
	{
		return $this->finder('EWR\Porta:Feature')
			->where('thread_id', $thread->thread_id)
			->fetchOne();
	}
	
	public function parseFeatures($features)
	{
		foreach ($features AS &$feature)
		{
			$feature = $this->parseFeature($feature);
		}
		
		return $features;
	}
	
	public function parseFeature($feature)
	{
		if (empty($feature->feature_excerpt))
		{
			$feature->feature_excerpt = $feature->Thread->FirstPost->message;
		}
		
		return $feature;
	}
	
	public function setFeatureFromUpload($thread, $upload)
	{
		$upload->requireImage();

		if (!$upload->isValid($errors))
		{
			throw new \XF\PrintableException(reset($errors));
		}
		
		$target = 'data://features/'.$thread->thread_id.'.jpg';
		$dimensions = \XF::options()->EWRporta_feature_dimensions;
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
			throw new \XF\PrintableException(\XF::phrase('unexpected_error_occurred'));
		}
	}
}