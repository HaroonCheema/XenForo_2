<?php

namespace XenBulletins\BrandHub\XF\Repository;

class Attachment extends XFCP_Attachment
{    
        
        public function fastDeleteOwnerPageAttachments($contentType, $pageId)
        {
            if (!$pageId)
            {
                    return 0;
            }

            $db = $this->db();
            $pairs = $db->fetchPairs('
                    SELECT attachment_id, data_id
                    FROM xf_attachment
                    WHERE content_type = ?
                            AND page_id = ?' , [$contentType, $pageId]);
            

            return $this->fastDeleteAttachmentsFromPairs($pairs);
        }
}