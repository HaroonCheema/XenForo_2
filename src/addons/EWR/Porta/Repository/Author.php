<?php

namespace EWR\Porta\Repository;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Repository;

class Author extends Repository
{
	public function findAuthor()
	{
		return $this->finder('EWR\Porta:Author')
			->with('User', true)
			->order('author_order')
			->order('author_name');
	}
	
	public function fetchAuthorByUser($user)
	{
		return $this->finder('EWR\Porta:Author')
			->where('user_id', $user->user_id)
			->fetchOne();
	}
	
	public function setAuthorFromUpload($author, $upload)
	{
		$upload->requireImage();

		if (!$upload->isValid($errors))
		{
			throw new \XF\PrintableException(reset($errors));
		}
		
		$target = 'data://authors/'.$author->user_id.'.jpg';
		$width = 150;
		$height = 200;
			
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