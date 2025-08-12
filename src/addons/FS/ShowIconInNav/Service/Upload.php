<?php

namespace FS\ShowIconInNav\Service;

class Upload extends \XF\Service\AbstractService
{

    protected $navIcon;
    protected $error = null;
    protected $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
    protected $fileName;
    protected $width;
    protected $height;
    protected $type;
    protected $throwErrors = true;

    public function __construct(\XF\App $app, \FS\ShowIconInNav\Entity\NavIcon $navIcon)
    {
        parent::__construct($app);
        $this->setUser($navIcon);
    }

    protected function setUser(\FS\ShowIconInNav\Entity\NavIcon $navIcon)
    {

        $this->navIcon = $navIcon;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setImageFromUpload(\XF\Http\Upload $upload)
    {

        $upload->requireImage();

        return $this->setImage($upload->getTempFile());
    }

    public function setImage($fileName)
    {

        $this->fileName = $fileName;
        return true;
    }

    public function validateImageAsSig($fileName, &$error = null)
    {
        $error = null;

        return true;
    }

    public function uploadImage()
    {
        $dataFile = $this->navIcon->getAbstractedCustomImgPath();

        \XF\Util\File::copyFileToAbstractedPath($this->fileName, $dataFile);

        return true;
    }

    protected function throwException(\Exception $error)
    {
        if ($this->throwErrors) {
            throw $error;
        } else {
            return false;
        }
    }
}
