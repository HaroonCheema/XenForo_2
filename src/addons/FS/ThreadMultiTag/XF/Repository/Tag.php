<?php

namespace FS\ThreadMultiTag\XF\Repository;

use XF\Mvc\Entity\Repository;
use XF\Util\Arr;

class Tag extends XFCP_Tag
{

    public function modifyContentMultiTags($contentType, $contentId, array $addIds, array $removeIds, $userId = null)
    {
        $handler = $this->getTagHandler($contentType, true);
        $content = $handler->getContent($contentId);
        if (!$content) {
            return null;
        }

        if ($userId === null) {
            $userId = \XF::visitor()->user_id;
        }

        $db = $this->db();
        $db->beginTransaction();

        if ($removeIds) {
            $this->removeTagIdsFromContent($removeIds, $contentType, $contentId);
        }

        if ($addIds) {
            $contentDate = $handler->getContentDate($content);
            $contentVisible = $handler->getContentVisibility($content);

            $this->addTagIdsToContentMulti($addIds, $contentType, $contentId, $contentDate, $contentVisible, $userId);
        }

        $cache = $this->getContentTagCache($contentType, $contentId);
        $handler->updateContentTagCache($content, $cache);

        $db->commit();

        return $cache;
    }

    protected function addTagIdsToContentMulti(array $tagIds, $contentType, $contentId, $contentDate, $contentVisible, $addUserId)
    {

        $db = $this->db();
        //        
        $multiTagIds = $db->query("SELECT tag_id FROM xf_tag_content
                                WHERE multi_order != 0
				AND content_type = ?
				AND content_id = ?
			", [$contentType, $contentId])->fetchAll();

        if (count($multiTagIds)) {

            $this->recalculateTagUsageCache($multiTagIds);
        }

        $visibleSql = $contentVisible ? 1 : 0;

        $insertedIds = [];

        $order = 0;
        foreach ($tagIds as $addId) {
            $order = $order + 1;
            $inserted = $db->insert('xf_tag_content', [
                'content_type' => $contentType,
                'content_id' => $contentId,
                'tag_id' => $addId,
                'add_user_id' => $addUserId,
                'add_date' => \XF::$time,
                'content_date' => $contentDate,
                'visible' => $visibleSql,
                'multi_order' => $order,
            ], false, false, 'IGNORE');
            $contentTagId = $db->lastInsertId();

            if ($inserted && $contentVisible) {
                $db->query("
					UPDATE xf_tag
					SET use_count = use_count + 1,
						last_use_date = ?
					WHERE tag_id = ?
				", [\XF::$time, $addId]);
            }
            if ($inserted) {
                $insertedIds[$contentTagId] = $addId;
            }
        }

        return $insertedIds;
    }
}
