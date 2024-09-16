<?php

namespace AVForums\TagEssentials\EditHistory;

use AVForums\TagEssentials\XF\Entity\Tag;
use XF\EditHistory\AbstractHandler;
use XF\Mvc\Entity\Entity;
use XF\Entity\EditHistory;

/**
 * Class TagWiki
 *
 * @package AVForums\TagEssentials\EditHistory
 */
class TagWiki extends AbstractHandler
{
    /**
     * @param Entity|Tag $content
     *
     * @return bool
     */
    public function canRevertContent(Entity $content)
    {
        return $content->canEditWiki($error);
    }

    /**
     * @param Entity|Tag $content
     *
     * @return array
     */
    public function getBreadcrumbs(Entity $content)
    {
        return $content->getBreadcrumbs(true);
    }

    /**
     * @param Entity|Tag $content
     *
     * @return string
     */
    public function getContentTitle(Entity $content)
    {
        return \XF::phrase('avForumsTagEss_wiki_info_for_x', [
            'tag' => $content->tag
        ]);
    }

    /**
     * @param                 $text
     * @param Entity|Tag|null $content
     *
     * @return mixed|null|string|string[]
     */
    public function getHtmlFormattedContent($text, Entity $content = null)
    {
        $func = \XF::$versionId >= 2010370 ? 'func' : 'fn';
        return \XF::app()->templater()->$func('bb_code', [$text, 'tag_wiki', $content]);
    }

    /**
     * @param Entity|Tag $content
     *
     * @return bool
     */
    public function canViewHistory(Entity $content)
    {
        return ($content->canView() && $content->canViewHistory());
    }

    /**
     * @param Entity|Tag       $content
     * @param EditHistory      $history
     * @param EditHistory|null $previous
     *
     * @return mixed
     */
    public function revertToVersion(Entity $content, EditHistory $history, EditHistory $previous = null)
    {
        /** @var Tag $content */
        /** @var \XF\Service\Post\Editor $editor */
        $editor = \XF::app()->service('XF:Post\Editor', $content);

        $editor->logEdit(false);
        $editor->setMessage($history->old_text);

        if (!$previous || $previous->edit_user_id != $content->tagess_wiki_last_edit_user_id)
        {
            $content->tagess_wiki_last_edit_date = 0;
        }
        else
        {
            if ($previous && $previous->edit_user_id == $content->tagess_wiki_last_edit_user_id)
            {
                $content->tagess_wiki_last_edit_date = $previous->edit_date;
                $content->tagess_wiki_last_edit_user_id = $previous->edit_user_id;
            }
        }

        return $editor->save();
    }

    /**
     * @param Entity|Tag $content
     *
     * @return mixed|string
     */
    public function getContentLink(Entity $content)
    {
        return \XF::app()->router('public')->buildLink('tag', $content);
    }

    /**
     * @param Entity|Tag $content
     *
     * @return mixed|null
     */
    public function getContentText(Entity $content)
    {
        return $content->tag;
    }

    /**
     * @return string
     */
    public function getSectionContext()
    {
        return 'forums';
    }
}