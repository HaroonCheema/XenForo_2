<?php

namespace FS\TractorByNetMyThreads\XF\ForumType;

use XF\Entity\Forum;

class Article extends XFCP_Article
{
    public function getForumViewAndTemplate(Forum $forum): array
    {
        $options = \XF::options();
        if ($options->fs_tbn_my_thread_forum_id == $forum->node_id) {
            return ['XF:Forum\ViewTypeArticle', 'fs_tbn_forum_view_type_article'];
        }

        return parent::getForumViewAndTemplate($forum);
    }
}
