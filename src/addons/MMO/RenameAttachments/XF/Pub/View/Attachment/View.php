<?php

namespace MMO\RenameAttachments\XF\Pub\View\Attachment;

class View extends XFCP_View
{
    /**
     * @return string|\XF\Http\ResponseStream
     */
    public function renderRaw()
    {
        /** @var \XF\Entity\Attachment $attachment */
        $attachment = $this->params['attachment'];

        $options = \XF::options();
        $fileName = $options->mraDownloadFileName;
        $type = $options->mraRenameAttachmentType;

        $response = parent::renderRaw();

        if($type == 'prefix')
        {
            $this->response
                ->setAttachmentFileParams($fileName . $attachment->filename, $attachment->extension);
        }
        else if($type == 'postfix')
        {
            $originalFile = pathinfo($attachment->filename, PATHINFO_FILENAME) . $fileName;
            $extension = pathinfo($attachment->filename, PATHINFO_EXTENSION);
            $this->response
                ->setAttachmentFileParams($originalFile . '.' . $extension, $attachment->extension);
        }

        return $response;
    }

}