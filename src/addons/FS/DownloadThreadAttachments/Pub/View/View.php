<?php

namespace FS\DownloadThreadAttachments\Pub\View;

/**
 * Class View
 *
 * @package FS\DownloadThreadAttachments\Pub\View
 */
class View extends \XF\Mvc\View
{

    public function renderRaw()
    {
        $rootPath = \XF::getRootDirectory();

        $zipFile = $this->params['zipFile'];
        $fileName = $this->params['fileName'];
        $dirPath = $this->params['dirPath'];


        $this->response
            ->setAttachmentFileParams($fileName, 'zip')
            ->setDownloadFileName($fileName);

        if (file_exists($dirPath)) {
            $this->deleteDir($dirPath);
        }

        readfile($zipFile);
        unlink($rootPath . '/' . $fileName);

        // ---------- update user's download size record ---------------
        $visitor = \XF::visitor();

        $data = [
            'daily_download_size' => $visitor->daily_download_size + $this->params['sizeOfAttachments'],
            'weekly_download_size' => $visitor->weekly_download_size + $this->params['sizeOfAttachments'],
            'overall_download_size' => $visitor->overall_download_size + $this->params['sizeOfAttachments'],
        ];

        $visitor->fastUpdate($data);
        //----------------------------------------------------------------

    }

    public static function deleteDir($dirPath)
    {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file))
                self::deleteDir($file);
            else
                unlink($file);
        }
        rmdir($dirPath);
    }
}
