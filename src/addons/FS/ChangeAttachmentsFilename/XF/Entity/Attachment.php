<?php

namespace FS\ChangeAttachmentsFilename\XF\Entity;

class Attachment extends XFCP_Attachment
{
    protected function _postSave()
    {
        $parent = parent::_postSave();

        $fileName = $this->Data->filename;

        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        $randomFileName = $this->generateRandomString(10);

        $fileName = $randomFileName . '.' . $fileExtension;

        $this->Data->fastUpdate('filename', $fileName);

        return $parent;
    }

    protected function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
