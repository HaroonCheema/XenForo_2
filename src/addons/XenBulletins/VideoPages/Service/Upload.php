<?php

namespace XenBulletins\VideoPages\Service;

use XenBulletins\VideoPages\Entity\AddVideo;


Class Upload extends \XF\Service\AbstractService{
    
    protected $brand;
    protected $error = null;
    protected $allowedTypes = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];
    protected $fileName;
    protected $width;
    protected $height;
    protected $type;
    protected $throwErrors = true;
    
    public function __construct(\XF\App $app , AddVideo $brand) {
        parent::__construct($app);
        $this->setbrand($brand);
    }
      protected function setbrand(AddVideo $brand) {
       
        $this->brand = $brand;
    }

    public function getError() {
        return $this->error;
    }

    public function setImageFromUpload(\XF\Http\Upload $upload) {
    $upload->requireImage();
         
        if (!$upload->isValid($errors)) {
            $this->error = reset($errors);
            return false;
        }

        return $this->setImage($upload->getTempFile());
    }

    public function setImage($fileName) {
        if (!$this->validateImageAsSig($fileName, $error)) {
            $this->error = $error;
            $this->fileName = null;
            return false;
        }

        $this->fileName = $fileName;
        return true;
    }

    public function validateImageAsSig($fileName, &$error = null) {
        $error = null;

        if (!file_exists($fileName)) {
            return $this->throwException(new \InvalidArgumentException("Invalid file '$fileName' passed to upload service"));
        }
        if (!is_readable($fileName)) {
            return $this->throwException(new \InvalidArgumentException("'$fileName' passed to upload service is not readable"));
        }

        $imageInfo = filesize($fileName) ? @getimagesize($fileName) : false;
        if (!$imageInfo) {
            $error = \XF::phrase('provided_file_is_not_valid_image');
            return false;
        }

        $type = $imageInfo[2];
        if (!in_array($type, $this->allowedTypes)) {
            $error = \XF::phrase('provided_file_is_not_valid_image');
            return false;
        }

        
        $this->type = $type;

        return true;
    }

    public function updateBrandImage($upload,$type) 
    {
        if (!$this->fileName) {
            return $this->throwException(new \LogicException("No source file for image set"));
        }
//        if (!$this->brand->exists()) {
//            return $this->throwException(new \LogicException("Brand does not exist, cannot update image"));
//        }
        $imageManager = $this->app->imageManager();
        $outputFiles = [];
        $baseFile = $this->fileName;
        $image = $imageManager->imageFromFile($this->fileName);
        if (!$image) {
            return false;
        }
        $newTempFile = \XF\Util\File::getTempFile();
        if ($newTempFile && $image->save($newTempFile, null, 95)) {
            $outputFiles['o'] = $newTempFile;
            $baseFile = $newTempFile;
            $width = $image->getWidth();
            $height = $image->getHeight();
        } 
        else
        {
            return $this->throwException(new \RuntimeException("Failed to save image to temporary file; check internal_data/data permissions"));
        }
        unset($image);
        foreach ($outputFiles AS $code => $file) 
        {
            $dataFile = $this->brand->getAbstractedCustomBrandImgPath($upload,$type);
            \XF\Util\File::copyFileToAbstractedPath($file, $dataFile);
        }
        return true;
    }
    
    protected function throwException(\Exception $error)
    {
        if ($this->throwErrors)
        {
                throw $error;
        }
        else
        {
                return false;
        }
    }
}
