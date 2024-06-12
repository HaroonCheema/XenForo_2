<?php

namespace FS\ChangeAttachmentsFilename\Job;

use XF\Job\AbstractRebuildJob;

class ChangeAttachmentName extends AbstractRebuildJob
{
    protected $rebuildDefaultData = [
        'steps' => 0,
        'start' => 0,
        'batch' => 1000,
    ];

    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn($db->limit(
            "
                SELECT data_id
                FROM xf_attachment_data
                WHERE data_id > ?
                ORDER BY data_id
            ",
            $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        $attachmentData = $this->app->em()->find('XF:AttachmentData', $id);

        if (isset($attachmentData['data_id'])) {

            $fileName = $attachmentData['filename'];

            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            $randomFileName = $this->generateRandomString(10);

            $fileName = $randomFileName . '.' . $fileExtension;

            $attachmentData->fastUpdate('filename', $fileName);
        }
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

    protected function getStatusType()
    {
        return \XF::phrase('fs_change_attachments_filename_status_type');
    }
}
