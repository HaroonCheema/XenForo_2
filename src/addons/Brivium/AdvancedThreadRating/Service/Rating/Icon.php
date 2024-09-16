<?php
namespace Brivium\AdvancedThreadRating\Service\Rating;

use Brivium\AdvancedThreadRating\Entity\StyleRating;
use XF\Http\Upload;
use XF\Service\AbstractService;
use XF\Util\File;

class Icon extends AbstractService
{

	protected $styleRating;
	protected $error;
	protected $allowedTypes = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

	protected $fileName;
	protected $width;
	protected $height;

	public function __construct(\XF\App $app, StyleRating $styleRating)
	{
		parent::__construct($app);
		$this->setStyleRating($styleRating);
	}

	protected function setStyleRating(StyleRating $styleRating)
	{
		if (!$styleRating->style_rating_id)
		{
			throw new \LogicException("StyleRating must be saved");
		}
		$this->styleRating = $styleRating;
	}

	public function getError()
	{
		return $this->error;
	}

	public function setImage($fileName)
	{
		if (!$this->validateImage($fileName, $error))
		{
			$this->error = $error;
            $fileName = null;
			return false;
		}

		$this->fileName = $fileName;
		return true;
	}

	public function setIcon(Upload $upload)
	{
		$upload->requireImage();

		if (!$upload->isValid($errors))
		{
			$this->error = reset($errors);
			return false;
		}
		return $this->setImage($upload->getTempFile());
	}

	public function validateImage($fileName, &$error = NULL)
	{
		$error = null;

		if (!file_exists($fileName))
		{
			throw new \InvalidArgumentException("Invalid file '$fileName' passed to icon  service");
		}
		if (!is_readable($fileName))
		{
			throw new \InvalidArgumentException("'$fileName' passed to icon service is not readable");
		}

		$imageInfo = filesize($fileName) ? getimagesize($fileName) : false;
		if (!$imageInfo)
		{
			$error = \XF::phrase('provided_file_is_not_valid_image');
			return false;
		}

		$type = $imageInfo[2];
		if (!in_array($type, $this->allowedTypes))
		{
			$error = \XF::phrase('provided_file_is_not_valid_image');
			return false;
		}

		$width = $imageInfo[0];
		$height = $imageInfo[1];

		if (!$this->app->imageManager()->canResize($width, $height))
		{
			$error = \XF::phrase('uploaded_image_is_too_big');
			return false;
		}

		$this->width = $width;
		$this->height = $height;
		return true;
	}

	public function updateIcon()
	{
		if (!$this->styleRating->exists())
		{
			throw new \LogicException("StyleRating does not exist, cannot update icons");
		}
		$this->writeIcon();
		$this->updateStyleRating();
	}

	protected function updateStyleRating()
	{
		$styleRating = $this->styleRating;
		$styleRating->bulkSet([
			'style_date' => \XF::$time,
			'image_width' => $this->width,
			'image_height' => $this->height,
		]);
		$styleRating->save();
	}

	protected function writeIcon()
	{
		$filePath = $this->styleRating->getIconFilePath();
		File::copyFileToAbstractedPath($this->fileName, $filePath);
	}

	public function deleteIcon($filePath = null)
	{
		if($filePath === null)
		{
			$filePath = $this->styleRating->getIconFilePath();
		}
		File::deleteFromAbstractedPath($filePath);
	}
}