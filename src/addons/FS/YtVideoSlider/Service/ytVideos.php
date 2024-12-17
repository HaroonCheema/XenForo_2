<?php

namespace FS\YtVideoSlider\Service;

class ytVideos extends \XF\Service\AbstractService
{

    public function getTempThumbnailFromFfmpeg($sourceFile, $abstractedDestination, $mediaType)
    {
        $tempThumbFile = null;

        $ffmpegFilePath = \dirname(\dirname(\dirname(\dirname(\dirname(\dirname(__FILE__)))))) . '/ffmpeg';

        $class = '\FS\YtVideoSlider\Ffmpeg\Runner';
        $class = \XF::extendClass($class);

        /** @var \FS\YtVideoSlider\Ffmpeg\Runner $ffmpeg */
        // $ffmpeg = new $class($ffmpegOptions['ffmpegPath']);
        $ffmpeg = new $class($ffmpegFilePath);
        $ffmpeg->setFileName($sourceFile);
        $ffmpeg->setType($mediaType);

        $frame = $ffmpeg->getKeyFrame();
        if (!$frame) {
            return false;
        }

        $imageInfo = @getimagesize($frame);
        if (!$imageInfo) {
            return false;
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];

        if ($width && $height && $this->app->imageManager()->canResize($width, $height)) {
            $tempThumbFile = $this->generateThumbnailFromFile($frame);
        }

        if (!$tempThumbFile) {
            return false;
        }

        try {
            \XF\Util\File::copyFileToAbstractedPath($tempThumbFile, $abstractedDestination);
        } catch (\Exception $e) {
            \XF\Util\File::deleteFromAbstractedPath($abstractedDestination);

            throw $e;
        }

        return true;
    }

    public function generateThumbnailFromFile($sourceFile, &$width = null, &$height = null)
    {
        $image = $this->app->imageManager()->imageFromFile($sourceFile);
        if (!$image) {
            return null;
        }

        if ($image instanceof \XF\Image\Imagick) {
            // Workaround to only use the first frame of a multi-frame image for the thumb
            foreach ($image->getImage() as $imagick) {
                $image->setImage($imagick->getImage());
                break;
            }
        }

        // $thumbDimensions = $this->app->options()->xfmgThumbnailDimensions;
        // $thumbWidth = $thumbDimensions['width'];
        // $thumbHeight = $thumbDimensions['height'];

        $thumbWidth = '1280';
        $thumbHeight = '720';

        $image->resizeAndCrop($thumbWidth, $thumbHeight)
            ->unsharpMask();

        $newTempFile = \XF\Util\File::getTempFile();
        if ($newTempFile && $image->save($newTempFile)) {
            $width = $image->getWidth();
            $height = $image->getHeight();

            return $newTempFile;
        } else {
            return null;
        }
    }
}
