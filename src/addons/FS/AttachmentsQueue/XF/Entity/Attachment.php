<?php

namespace FS\AttachmentsQueue\XF\Entity;

use XF\Mvc\Entity\Structure;

class Attachment extends XFCP_Attachment
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['attachment_state'] =  [
            'type' => self::STR,
            'allowedValues' => [
                'pending',
                'approve',
                'rejected'
            ],
            'default' => 'pending'
        ];

        $structure->relations += [
            'Post' => [
                'entity' => 'XF:Post',
                'type' => self::TO_ONE,
                'conditions' => [
                    ['post_id', '=', '$content_id'],
                    // ['content_type', '=', 'post']
                ]
            ]
        ];

        return $structure;
    }

    protected function _postSave()
    {
        if ($this->content_type == 'post') {
            \XF::repository("FS\AttachmentsQueue:AttachmentQueueRepo")->rebuildPendingAttachmentCounts();
        }

        return parent::_postSave();
    }
}
