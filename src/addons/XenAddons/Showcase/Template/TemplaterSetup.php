<?php

namespace XenAddons\Showcase\Template;

class TemplaterSetup
{
	public function fnScItemThumbnail(\XF\Template\Templater $templater, &$escape, \XenAddons\Showcase\Entity\Item $item, $additionalClasses = '', $inline = false)
	{
		$escape = false;
	
		$class = 'scThumbnail scThumbnail--item';
		if ($additionalClasses)
		{
			$class .= " $additionalClasses";
		}
	
		if (!$item->isVisible())
		{
			$class .= ' scThumbnail--notVisible scThumbnail--notVisible--';
			$class .= $item->item_state;
		}
			
		$thumbnailUrl = null;
		$width = 300;
		$height = 300;
				
		if ($item->cover_image_id && $item->CoverImage && $item->CoverImage->thumbnail_url)
		{
			$thumbnailUrl = $item->CoverImage->thumbnail_url;
			
			$width = $item->CoverImage->thumbnail_width ?? 300;
			$height = $item->CoverImage->thumbnail_height ?? 300;
		}
		elseif ($item->Category->content_image_url)
		{
			$baseUrl = \XF::app()->request()->getFullBasePath();
			$imagePath = "/" . $item->Category->content_image_url;
			$thumbnailUrl = $baseUrl . $imagePath;
		}
	
		$outputUrl = null;
		$hasThumbnail = false;
	
		if ($thumbnailUrl)
		{
			$outputUrl = $thumbnailUrl;
			$hasThumbnail = true;
		}
			
		if (!$hasThumbnail)
		{
			$class .= ' scThumbnail--noThumb';
			$outputUrl = $templater->func('transparent_img');
		}
	
		$title = $templater->filterForAttr($templater, $item->title, $null);
	
		if ($inline)
		{
			$tag = 'span';
		}
		else
		{
			$tag = 'div';
		}
	
		return "<$tag class='$class'>
			<img class='scThumbnail-image' src='$outputUrl' loading='lazy' width='$width' height='$height' alt='$title' />
			<span class='scThumbnail-icon'></span>
			</$tag>";
	}
		
	public function fnScCategoryIcon($templater, &$escape, \XenAddons\Showcase\Entity\Item $item, $additionalClasses = '', $inline = false)
	{		
		$escape = false;
	
		$class = 'scThumbnail scThumbnail--item';
		if ($additionalClasses)
		{
			$class .= " $additionalClasses";
		}
	
		if (!$item->isVisible())
		{
			$class .= ' scThumbnail--notVisible scThumbnail--notVisible--';
			$class .= $item->item_state;
		}
	
		$thumbnailUrl = null;
	
		if ($item->Category->content_image_url)
		{
			$baseUrl = \XF::app()->request()->getFullBasePath();
			$imagePath = "/" . $item->Category->content_image_url;
			$thumbnailUrl = $baseUrl . $imagePath;
		}
	
		$outputUrl = null;
		$hasThumbnail = false;
	
		if ($thumbnailUrl)
		{
			$outputUrl = $thumbnailUrl;
			$hasThumbnail = true;
		}
	
		if (!$hasThumbnail)
		{
			$class .= ' scThumbnail--noThumb';
			$outputUrl = $templater->func('transparent_img');
		}
	
		$title = $templater->filterForAttr($templater, $item->title, $null);
	
		if ($inline)
		{
			$tag = 'span';
		}
		else
		{
			$tag = 'div';
		}
		
		$width = 300;
		$height = 300;
	
		return "<$tag class='$class'>
			<img class='scThumbnail-image' src='$outputUrl' loading='lazy' width='$width' height='$height' alt='$title' />
			<span class='scThumbnail-icon'></span>
			</$tag>";
	}	
}