<?php

namespace AVForums\TagEssentials\XF\Repository;

use XF\Mvc\Entity\ArrayCollection;

/**
 * Class Tag
 *
 * @package AVForums\TagEssentials\XF\Repository
 */
class Tag extends XFCP_Tag
{
    /**
     * @param $tag
     *
     * @return bool
     */
    public function isValidTag($tag)
    {
        $isValidTag = parent::isValidTag($tag);

        if ($isValidTag && $this->options()->tagess_blockNumberTags)
        {
            return !$this->isNumericTag($tag);
        }

        return $isValidTag;
    }

    /**
     * @param $tag
     *
     * @return bool
     */
    public function isNumericTag($tag)
    {
        $tag = $this->normalizeTag($tag);

        return is_numeric($tag) || is_float($tag);
    }

    /**
     * @param \XF\Entity\Tag $tag
     *
     * @return array
     */
    public function getTopUsers(\XF\Entity\Tag $tag)
    {
        $topUsersData = $this->db()->fetchAllKeyed('
            SELECT add_user_id, COUNT(*) AS total_count
            FROM xf_tag_content
            WHERE tag_id = ?
            GROUP BY add_user_id
            ORDER BY total_count DESC
        ', 'add_user_id', $tag->tag_id);

        if (!$topUsersData)
        {
            return [new ArrayCollection([]), []];
        }

        $extraDataRef = [];
        $topUserIds = [];

        foreach ($topUsersData AS $topUser)
        {
            $topUserIds[] = $topUser['add_user_id'];
            $extraDataRef[$topUser['add_user_id']] = $topUser['total_count'];
        }

        $topUsers = $this->finder('XF:User')
            ->where('user_id', $topUserIds)
            ->with('Profile')
            ->with('Option')
            ->limit(20)
            ->fetch()
            ->sortByList($topUserIds);

        return [$topUsers, $extraDataRef];
    }

    /**
     * @param string $title
     * @param null|int $nodeId
     *
     * @return array
     */
    public function getTagsFromTitle($title, $nodeId = null)
    {
        if (utf8_strlen($title) === 0)
        {
            return [];
        }

        $parts = preg_split('/\s+/u', $title, -1, PREG_SPLIT_NO_EMPTY);
        if (!$parts)
        {
            return [];
        }

        $options = $this->options();
        $rawStopWords = $options->tagess_suggeststopwords;
        $stopWordsApplyToAllWords = false;
        switch ($options->tagess_suggeststopwords_state)
        {
            case 'firstword':
                break;
            case 'allwords':
                $stopWordsApplyToAllWords = true;
                break;
            case 'disable':
            default:
                $rawStopWords = '';
                break;
        }

        $stopWords = $rawStopWords
            ? array_fill_keys(array_filter(array_map('\utf8_trim', explode(',', preg_replace('/\s+/us', ',', $rawStopWords)))), true)
            : [];

        $tags = [];
        foreach ($parts AS $part)
        {
            $tag = $this->normalizeTag($part);

            if (isset($stopWords[$tag]))
            {
                continue;
            }
            $tags[] = $tag;

            // trim non-word characters off the end
            $trimmedTag = preg_replace('/^(.+?)\W*$/u', '$1', $tag);

            if ($trimmedTag !== $tag)
            {
                $tag = $this->normalizeTag($trimmedTag);
                $tags[] = $tag;
            }
        }

        // build alternative tags, up to the limit
        if (count($parts) > 1)
        {
            $suggestWordCountLimit = $options->tagess_suggestwordcountlimit;
            foreach ($parts AS $key => $tag)
            {
                $wordCount = 1;
                $nextTag = $key + 1;
                $phrase = $tag;

                while ($nextTag < count($parts) && $wordCount < $suggestWordCountLimit)
                {
                    $newTag = $this->normalizeTag($parts[$nextTag]);

                    if ($stopWordsApplyToAllWords && isset($stopWords[$newTag]))
                    {
                        ++$nextTag;
                        continue;
                    }

                    // phrase must be normalized when it is added to the tag list as the middle of tags are allowed characters that are not allowed on the end
                    $phrase .= " " . $parts[$nextTag];

                    $tagText = $this->normalizeTag($phrase);
                    $tags[] = $tagText;

                    // trim non-word characters off the end
                    $trimmedTag = preg_replace('/^(.+?)\W*$/u', '$1', $tagText);
                    if ($trimmedTag !== $tagText)
                    {
                        $tagText = $this->normalizeTag($trimmedTag);
                        $tags[] = $tagText;
                    }

                    ++$nextTag;
                    ++$wordCount;
                }
            }
        }

        if (!$tags)
        {
            return [];
        }

        $tags = $this->finder('XF:Tag')
                     ->where('tag', array_unique($tags))
                     ->fetch();

        $finalTags = [];
        if ($tags->count())
        {
            if ($nodeId)
            {
                $tags = $tags->filter(function($entity) use($nodeId)
                {
                    /** @var \AVForums\TagEssentials\XF\Entity\Tag $entity */
                    return !$entity->allowed_node_ids || in_array($nodeId, $entity->allowed_node_ids, true);
                });
            }

            /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
            foreach ($tags AS $tag)
            {
                $finalTags[$tag->tag_id] = $tag->tag;
            }
        }

        return $finalTags;
    }

    /**
     * @param $requestUrl
     *
     * @return array
     */
    protected function getWikiPage($requestUrl)
    {
        $request = $this->app()->http()->reader()->getUntrusted($requestUrl, [], null, [
            'timeout' => 5,
            'headers' => [
                'Accept-encoding' => 'identity',
                'Accept' => 'text/html,*/*;q=0.8'
            ]
        ]);

        if (!$request || $request->getStatusCode() !== 200)
        {
            return [];
        }

        $body = (string)$request->getBody();

        if (\XF::options()->tagessWikiDebug)
        {
            \XF::logError('URL: '.$requestUrl.', Response body:'.var_export($body, true));
        }

        $body = json_decode($body, true);
        if (!$body)
        {
            $body = [];
        }

        return $body;
    }

    /**
     * @param $language
     *
     * @return string
     */
    protected function getWikiMediaApiLink($language)
    {
        $url = $this->options()->tagessAltMediaWikiApiLink;

        if ($url)
        {
            $url = trim($url);
        }

        if (empty($url))
        {
            $url = "https://{$language}.wikipedia.org/w/api.php";
        }

        return $url;
    }

    /**
     * @param $language
     *
     * @return string
     */
    protected function getWikiMediaEmbedLink($language)
    {
        $url = $this->options()->tagessAltMediaWikiEmbedLink;

        if ($url)
        {
            $url = trim($url);
        }

        if (empty($url))
        {
            $url = "https://{$language}.wikipedia.org/wiki";
        }

        return $url;
    }

    /**
     * @param null $language
     *
     * @return string
     */
    protected function getRedirectMessage(/** @noinspection PhpUnusedParameterInspection */$language = null)
    {
        return 'This is a redirect';
    }

    /**
     * @param string $title
     * @param null|string $language
     * @param null|boolean $excludeDisambiguation
     *
     * @return null|string
     */
    public function getWikiDescriptionByExactTitle($title, $language = null, $excludeDisambiguation = null)
    {
        $description = null;
        if ($language === null)
        {
            $language = $this->app()->options()->tagessWikipediaLanguageCode;
        }

        if ($excludeDisambiguation === null)
        {
            $excludeDisambiguation = $this->app()->options()->tagess_disambiguation_exclude;
        }

        $page = $this->getWikiPage($this->getWikiMediaApiLink($language) . '?format=json&action=query&prop=extracts%7Cpageprops&exintro&explaintext&redirects&titles=' . urlencode($title));

        if (!empty($page) && !empty($page['query']['pages']))
        {
            foreach ($page['query']['pages'] as $pageData)
            {
                if (empty($pageData['pageid']))
                {
                    continue;
                }
                if ($excludeDisambiguation && isset($pageData['pageprops']['disambiguation']))
                {
                    break;
                }

                $extract = isset($pageData['extract']) ? trim($pageData['extract']) : null;
                $redirectMessage = $this->getRedirectMessage($language);

                if ($extract && utf8_substr($extract, 0, utf8_strlen($extract)) === $redirectMessage)
                {
                    $extract = '';
                }

                $extract = $extract ? \XF::cleanString($extract) : '';
                if (trim(\strip_tags($extract)))
                {
                    $viewMoreLink = $this->getWikiMediaEmbedLink($language) . '?'. http_build_query(['curid' => $pageData['pageid']]);
                    $viewMoreMessage = \XF::phrase('avForumsTagEss_view_more_on_wikipedia')->render();

                    $description = $extract . "\n\n[URL={$viewMoreLink}]{$viewMoreMessage}[/URL]";
                    break;
                }
            }
        }

        return $description;
    }

    /**
     * @param string $title
     * @param null|string $language
     * @param null|boolean $excludeDisambiguation
     *
     * @return null|string
     */
    public function getWikiDescriptionByFuzzyTitle($title, $language = null, $excludeDisambiguation = null)
    {
        $description = null;
        if ($language === null)
        {
            $language = $this->app()->options()->tagessWikipediaLanguageCode;
        }

        if ($excludeDisambiguation === null)
        {
            $excludeDisambiguation = $this->app()->options()->tagess_disambiguation_exclude;
        }

        $page = $this->getWikiPage($this->getWikiMediaApiLink($language) .'?&format=json&action=query&list=search&srlimit=10&srprop=&srsearch=' . urlencode('intitle:' . $title));

        if (!empty($page) && is_array($page) && !empty($page['query']['search']))
        {
            foreach ($page['query']['search'] as $pageData)
            {
                if ($pageData['title'])
                {
                    $description = $this->getWikiDescriptionByExactTitle($pageData['title'], $language, $excludeDisambiguation);
                    if ($description)
                    {
                        break;
                    }
                }
            }
        }

        return $description;
    }

    /**
     * @param string $search
     * @param int    $tagId
     * @param int    $maxResults
     * @return ArrayCollection
     */
    public function getSynonymTagAutoCompleteResults($search, $tagId = 0, $maxResults = 10)
    {
        /** @var \AVForums\TagEssentials\XF\Finder\Tag $finder */
        $finder = $this->finder('XF:Tag');
        $finder->sqlJoin('xf_tagess_synonym', 'synonym', ['tag_id','parent_tag_id'], false);
        $finder->sqlJoinConditions('synonym', [['tag_id', '=', '$tag_id']]);
        $finder->sqlJoin('xf_tagess_synonym', 'synonymParent', ['tag_id','parent_tag_id'], false);
        $finder->sqlJoinConditions('synonymParent', [['parent_tag_id', '=', '$tag_id']]);
        if ($tagId)
        {
            $finder->where('tag_id', '!=', $tagId);
        }

        $tags = $finder
            ->where('tag', 'like', $finder->escapeLike($search, '?%'))
            ->whereOr(
                ['use_count', '>', 0],
                ['permanent', '=', 1]
            )
            ->where('synonym.parent_tag_id', '=', null)
            ->where('synonymParent.parent_tag_id', '=', null)
            ->order('tag')
            ->fetch($maxResults);

        if ($tags->count() < $maxResults)
        {
            $finder = $this->finder('XF:Tag');
            $finder->sqlJoin('xf_tagess_synonym', 'synonym', ['tag_id','parent_tag_id'], false);
            $finder->sqlJoinConditions('synonym', [['tag_id', '=', '$tag_id']]);
            $finder->sqlJoin('xf_tagess_synonym', 'synonymParent', ['tag_id','parent_tag_id'], false);
            $finder->sqlJoinConditions('synonymParent', [['parent_tag_id', '=', '$tag_id']]);
            if ($tagId)
            {
                $finder->where('tag_id', '!=', $tagId);
            }
            $extraTags = $finder
                ->where('tag', 'like', $finder->escapeLike($search, '%?%'))
                ->where('tag', 'not like', $finder->escapeLike($search, '?%'))
                ->whereOr(
                    ['use_count', '>', 0],
                    ['permanent', '=', 1]
                )
                ->where('synonym.parent_tag_id', '=', null)
                ->where('synonymParent.parent_tag_id', '=', null)
                ->order('tag')
                ->fetch($maxResults - $tags->count());

            $tags = $tags->merge($extraTags);
        }

        return $tags;
    }

    /**
     * @param string $contentType
     * @param int $contentId
     *
     * @return array
     */
    public function getContentTagCache($contentType, $contentId)
    {
        $cache = parent::getContentTagCache($contentType, $contentId);

        if ($tagIds = array_keys($cache))
        {
            $db = $this->db();

            $tagsCategoryData = $db->fetchAllKeyed('
                SELECT tag.tag_id, tag_category.category_id, tag_category.title
                FROM xf_tag AS tag
                INNER JOIN xf_tagess_category AS tag_category ON
                  (tag_category.category_id = tag.tagess_category_id)
                WHERE tag.tag_id IN (' . $db->quote($tagIds) . ')
            ', 'tag_id');

            if ($tagsCategoryData)
            {
                foreach ($tagsCategoryData AS $tagId => $tagCategoryData)
                {
                    $categoryId = '';
                    $categoryTitle = '';

                    if (isset($cache[$tagId]))
                    {
                        $categoryId = $tagCategoryData['category_id'];
                        $categoryTitle = $tagCategoryData['title'];
                    }

                    $cache[$tagId]['category_id'] = $categoryId;
                    $cache[$tagId]['category_title'] = $categoryTitle;
                }
            }
        }

        return $cache;
    }

    /**
     * @param     $limit
     * @param int $minUses
     *
     * @return array|\XF\Mvc\Entity\Entity[]
     */
    public function getTagsForGroupedCloud($limit, $minUses = 1)
    {
        /** @var \AVForums\TagEssentials\Entity\TagCategory[] $categories */
        $categories = $this->finder('AVForums\TagEssentials:TagCategory')->fetch();

        $db = $this->db();
        $ids = [];
        foreach($categories as $category)
        {
            $query = $db->query($db->limit("
                SELECT tag_id
                FROM xf_tag
                WHERE use_count >= ? and xf_tag.tagess_category_id = ?
                ORDER BY use_count DESC
            ", $limit), [$minUses, $category->category_id]);

            while ($id = $query->fetch())
            {
                $ids[] = $id['tag_id'];
            }
        }

        if (!$ids)
        {
            return [];
        }

        return $this->finder('XF:Tag')
            ->where('tag_id', $ids)
            ->order('tag')
            ->fetch()->toArray();
    }

    /**
     * @param array $tags
     * @param int   $levels
     *
     * @return array
     */
    public function getTagGroupedCloud(array $tags, $levels = 7)
    {
        if (!$tags)
        {
            return [];
        }

        $minArr = [];
        $maxArr = [];
        $categoryIds = [];
        $groupedTags = [];

        /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
        foreach ($tags AS $tag)
        {
            $uses = $tag->use_count;
            $categoryId = $tag->tagess_category_id;

            $categoryIds[$categoryId] = true;

            if (!isset($minArr[$categoryId]))
            {
                $minArr[$categoryId] = PHP_INT_MAX;
            }

            if (!isset($maxArr[$categoryId]))
            {
                $maxArr[$categoryId] = 0;
            }

            if ($uses < $minArr[$categoryId])
            {
                $minArr[$categoryId] = $uses;
            }

            if ($uses > $maxArr[$categoryId])
            {
                $maxArr[$categoryId] = $uses;
            }

            $groupedTags[$categoryId][$tag->tag_id] = $tag;
        }

        $categoryIds = array_keys($categoryIds);
        $levelSizeArr = [];

        foreach ($categoryIds AS $categoryId)
        {
            if (!isset($maxArr[$categoryId]))
            {
                $e = new \LogicException("No maximum tag count found for category: {$categoryId}");
                \XF::logException($e);
                if (\XF::$debugMode)
                {
                    throw $e;
                }
                continue;
            }

            if (!isset($minArr[$categoryId]))
            {
                $e = new \LogicException("No minimum tag count found for category: {$categoryId}");
                \XF::logException($e);
                if (\XF::$debugMode)
                {
                    throw $e;
                }
                continue;
            }

            $levelSizeArr[$categoryId] = ($maxArr[$categoryId] - $minArr[$categoryId]) / $levels;
        }

        $output = [];
        foreach ($categoryIds AS $categoryId)
        {
            $tags = $groupedTags[$categoryId];
            if ($minArr[$categoryId] === $maxArr[$categoryId])
            {
                $middle = ceil($levels / 2);
                foreach ($tags AS $key => $tag)
                {
                    if (!isset($output[$categoryId]['title']))
                    {
                        if ($tag->TagCategory)
                        {
                            $output[$categoryId]['title'] = $tag->TagCategory->title;
                        }
                        else
                        {
                            $output[$categoryId]['title'] = '';
                        }
                    }

                    $output[$categoryId]['tags'][$key]['level'] = $middle;
                    $output[$categoryId]['tags'][$key]['tag'] = $tag;
                }
            }
            else
            {
                foreach ($tags AS $key => $tag)
                {
                    $diffFromMin = $tag->use_count - $minArr[$categoryId];
                    if (!$diffFromMin)
                    {
                        $level = 1;
                    }
                    else
                    {
                        $level = min($levels, ceil($diffFromMin / $levelSizeArr[$categoryId]));
                    }

                    if (!isset($output[$categoryId]['title']))
                    {
                        if ($tag->TagCategory)
                        {
                            $output[$categoryId]['title'] = $tag->TagCategory->title;
                        }
                        else
                        {
                            $output[$categoryId]['title'] = '';
                        }
                    }

                    $output[$categoryId]['tags'][$key]['level'] = $level;
                    $output[$categoryId]['tags'][$key]['tag'] = $tag;
                }
            }
            ksort($output[$categoryId]['tags']);
        }

        return $output;
    }

    /**
     * @param int $limit
     * @param array|null $categoryId
     * @param int|null $nodeId
     * @param int|null $minUses
     *
     * @return array|\XF\Mvc\Entity\Entity[]
     */
    public function getTagsForCloudWidget($limit, array $categoryId = [], $nodeId = null, $minUses = null)
    {
        $db = $this->db();
        $innerJoins = '';

        if ($minUses === null)
        {
            $minUses = $this->options()->tagCloudMinUses;
        }

        if ($categoryId)
        {
            $moreWhere = 'AND tagess_category_id IN (' . $db->quote($categoryId) . ')';
        }
        else
        {
            $moreWhere = "AND tagess_category_id != '' ";
        }

        if ($nodeId)
        {
            $innerJoins = '
                INNER JOIN xf_tag_content AS tag_content
                    ON (tag_content.tag_id = tag.tag_id)
                INNER JOIN xf_thread AS thread
                    ON (thread.thread_id = tag_content.content_id)';

            $moreWhere .= ' AND  tag_content.content_type = ' . $db->quote('thread') . ' AND thread.node_id = ' . $db->quote($nodeId);
        }

        $ids = $db->fetchAllColumn($db->limit("
			SELECT tag.tag_id
			FROM xf_tag AS tag
			{$innerJoins}
			WHERE tag.use_count >= ?
			{$moreWhere}
			ORDER BY tag.use_count DESC
		", $limit), $minUses);
        if (!$ids)
        {
            return [];
        }

        return $this->finder('XF:Tag')
            ->where('tag_id', $ids)
            ->order('tag')
            ->with('TagCategory')
            ->fetch()->toArray();
    }

    /**
     * @param array $tagIds
     * @param string $contentType
     * @param int $contentId
     * @param int $contentDate
     * @param bool $contentVisible
     * @param int $addUserId
     *
     * @return array
     */
    protected function addTagIdsToContent(array $tagIds, $contentType, $contentId, $contentDate, $contentVisible, $addUserId)
    {
        $insertedIds = parent::addTagIdsToContent($tagIds, $contentType, $contentId, $contentDate, $contentVisible, $addUserId);

        if ($insertedIds)
        {
            $tagContentIds = array_keys($insertedIds);
            $tagContents = $this->finder('XF:TagContent')
                ->where('tag_content_id', $tagContentIds)
                ->with(['Tag', 'AddUser'], true)
                ->fetch();

            if ($tagContents->count())
            {
                $content = null;
                $handler = null;

                $tagContentCombos = [];

                /** @var \AVForums\TagEssentials\XF\Entity\TagContent $tagContent */
                foreach ($tagContents AS $tagContent)
                {
                    if ($content === null)
                    {
                        $content = $tagContent->getContent();
                    }

                    if ($handler === null)
                    {
                        $handler = $tagContent->getHandler();
                    }

                    $tagContentCombos[$tagContent->tag_id] = $tagContent;
                }

                if (!$handler instanceof \XF\Tag\AbstractHandler)
                {
                    $e = new \LogicException("No tag handler provided for sending notifications.");
                    \XF::logException($e);
                    if (\XF::$debugMode)
                    {
                        throw $e;
                    }
                    return $insertedIds;
                }

                if (!$content instanceof \XF\Mvc\Entity\Entity)
                {
                    $e = new \LogicException("No content provided for sending notifications");
                    \XF::logException($e);
                    if (\XF::$debugMode)
                    {
                        throw $e;
                    }
                    return $insertedIds;
                }

                $tagWatchers = $this->finder('AVForums\TagEssentials:TagWatch')
                    ->where('tag_id', $tagIds)
                    ->where('user_id', '<>', $addUserId)
                    ->with(['Tag', 'User'], true)
                    ->fetchColumns(['tag_id', 'user_id']);

                if ($tagWatchers)
                {
                    $usersWatchingTags = [];

                    foreach ($tagWatchers AS $tagWatcher)
                    {
                        $usersWatchingTags[$tagWatcher['tag_id']][] = $tagWatcher['user_id'];
                    }

                    $addonId = $this->getDependsOnAddOnIdForTagEss($contentType);
                    if ($addonId === null)
                    {
                        return $insertedIds;
                    }

                    foreach ($usersWatchingTags AS $tagId => $userIds)
                    {
                        if (empty($tagContentCombos[$tagId]))
                        {
                            $e = new \LogicException('Tag content missing.');
                            \XF::logException($e);
                            if (\XF::$debugMode)
                            {
                                throw $e;
                            }
                            continue;
                        }

                        /** @var \AVForums\TagEssentials\XF\Entity\TagContent $tagContent */
                        $tagContent = $tagContentCombos[$tagId];

                        /** @var \AVForums\TagEssentials\Service\Tag\Notifier $notifier */
                        $notifier = $this->app()->service('AVForums\TagEssentials:Tag\Notifier', $tagContent->Tag, $handler, $content, $tagContent, $addonId);
                        $notifier->addNotifications('tagWatch', $usersWatchingTags[$tagId]);
                        $notifier->enqueueJobIfNeeded();
                    }
                }


            }
        }

        return $insertedIds;
    }

    /**
     * @param $contentType
     *
     * @return string|null
     */
    protected function getDependsOnAddOnIdForTagEss($contentType)
    {
        if ($contentType === 'thread')
        {
            return 'AVForums/TagEssentials';
        }

        if (\XF::$debugMode)
        {
            throw new \LogicException('Could not determine dependable add-on; please override');
        }

        return null;
    }

    /**
     * @param array $tagIds
     * @param string $contentType
     * @param int $contentId
     */
    protected function removeTagIdsFromContent(array $tagIds, $contentType, $contentId)
    {
        parent::removeTagIdsFromContent($tagIds, $contentType, $contentId);
    }
}