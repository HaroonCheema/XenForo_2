<?php

namespace FS\TagPermissions\XF\Repository;

use XF\Mvc\Entity\Structure;

class Tag extends XFCP_Tag
{
    public function getTagSearchResults($tagId, $limit, $visibleOnly = true)
    {
        $visitor = \XF::visitor();

        $fetchTag = \XF::app()->em()->find('XF:Tag', $tagId);

        // if ($visitor->user_id == 0) {
        //     return [];
        // }

        if ($visitor->is_admin || $visitor->is_moderator || $visitor->isMemberOf($fetchTag->fs_usergroup_ids)) {
            return parent::getTagSearchResults($tagId, $limit, $visibleOnly);
        }

        $limit = max(1, intval($limit));

        $results = $this->db()->query("
			SELECT content_type, content_id
			FROM xf_tag_content
			WHERE tag_id = ?
				" . ($visibleOnly ? "AND visible = 1" : '') . "
			ORDER BY content_date DESC
			LIMIT {$limit}
		", $tagId);
        $output = [];
        while ($result = $results->fetch()) {
            $type = $result['content_type'];
            $id = $result['content_id'];
            $output["{$type}-{$id}"] = [$type, $id];
        }

        $threadIds = [];

        foreach ($output as $value) {
            if ($value[0] === 'thread') {
                $threadIds[] = $value[1];
            }
        }

        $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->fetch();

        foreach ($output as $key => $value) {

            if ($value[0] == 'thread') {
                $thread = $threads[$value[1]] ?? null;

                if (!$thread || $thread->user_id != $visitor->user_id) {
                    unset($output[$key]);
                }
            }
        }

        return $output;
    }
}
