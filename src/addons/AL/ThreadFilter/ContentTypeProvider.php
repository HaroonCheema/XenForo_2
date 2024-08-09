<?php
/** 
* @package [AddonsLab] Thread Filter
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 3.9.2
This software is furnished under a license and may be used and copied
only  in  accordance  with  the  terms  of such  license and with the
inclusion of the above copyright notice.  This software  or any other
copies thereof may not be provided or otherwise made available to any
other person.  No title to and  ownership of the  software is  hereby
transferred.                                                         
                                                                     
You may not reverse  engineer, decompile, defeat  license  encryption
mechanisms, or  disassemble this software product or software product
license.  AddonsLab may terminate this license if you don't comply with
any of these terms and conditions.  In such event,  licensee  agrees 
to return licensor  or destroy  all copies of software  upon termination 
of the license.
*/


namespace AL\ThreadFilter;

use AL\FilterFramework\AbstractContentTypeProvider;
use AL\FilterFramework\Entity\BaseFieldIndexEntity;
use AL\FilterFramework\FilterApp;
use AL\ThreadFilter\Entity\ThreadFieldIndex;
use AL\ThreadFilter\XF\Entity\Forum;
use AL\ThreadFilter\XF\Entity\User;
use AL\ThreadFilter\XF\Search\Search;
use XF\Entity\Node;
use XF\Entity\Thread;
use XF\Mvc\Controller;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Finder;
use XF\Search\MetadataStructure;
use XF\Search\Query\Query;

class ContentTypeProvider extends AbstractContentTypeProvider
{
    public function getContentEntityName()
    {
        return 'XF:Thread';
    }

    public function getCategoryEntityName()
    {
        throw new \RuntimeException('The method does not apply to thread filters.');
    }


    public function getContentType()
    {
        return 'thread';
    }

    public function getContentPrimaryKeyName()
    {
        return 'thread_id';
    }

    public function getCategoryContentType()
    {
        return 'node';
    }


    public function getIndexContentType()
    {
        return 'thread_field';
    }

    public function getFieldEntityName()
    {
        return 'XF:ThreadField';
    }


    public function getIndexEntityName()
    {
        return 'AL\ThreadFilter:ThreadFieldIndex';
    }


    public function getColorSimilarityIndex()
    {
        return App::getOptionProvider()->getOption('altf_color_similarity_index');
    }

    public function getPhraseForOption($field, $option)
    {
        return 'thread_field_choice.' . $field['field_id'] . '_' . $option;
    }

    public function getFieldEntityPrimaryKeyName()
    {
        return 'field_id';
    }

    public function getPrefixMetadataName()
    {
        return 'prefix';
    }

    public function getFieldDefinitions($onlyInclude = null)
    {
        $contextParams = App::getContextProvider()->getContextParams();

        $forum = $contextParams['forum'] ?? null;
        /** @var User $user */
        $user = \XF::visitor();

        if (($forum instanceof Forum) && !$user->canUseThreadFilter($forum))
        {
            return [];
        }

        return \XF::app()->getCustomFields('threads', null, $onlyInclude)->getFieldDefinitions();
    }

    public function getContainerKey()
    {
        return 'customFields.threads';
    }

    public function executeSearch(array $fieldList, array $metadata = [])
    {
        // run a new search and cache the results
        /** @var Search $search */
        $search = \XF::app()->search();
        return $search->searchThreadIdsByCustomFields($fieldList, $metadata);
    }

    public function countFacetsByDiscussionIds(array $discussionIds, array $fieldIds)
    {
        // run a new search and cache the results
        /** @var Search $search */
        $search = \XF::app()->search();
        return $search->countFacetsByThreadIds($discussionIds, $fieldIds);
    }


    public function setupElasticDsl(array &$dslCondition, array $metadata)
    {
        if (!empty($metadata['__metadata_primary_key_ids']))
        {
            $termKey = is_array($metadata['__metadata_primary_key_ids']) ? 'terms' : 'term';
            $dslCondition[] = [
                $termKey => ['discussion_id' => $metadata['__metadata_primary_key_ids']]
            ];
        }

        // if we have node IDs specified, get from specific nodes only
        if (!empty($metadata['category_ids']))
        {
            $termKey = is_array($metadata['category_ids']) ? 'terms' : 'term';
            $dslCondition[] = [
                $termKey => ['node' => $metadata['category_ids']]
            ];
        }
    }

    public function setupParentFinder(Finder $finder, array $metadata)
    {
        if (!empty($metadata['category_ids']))
        {
            $finder->where('node_id', $metadata['category_ids']);
        }

        if (!empty($metadata['__metadata_primary_key_ids']))
        {
            if (is_array($metadata['__metadata_primary_key_ids']))
            {
                $finder->whereIds($metadata['__metadata_primary_key_ids']);
            }
            else
            {
                $finder->whereId($metadata['__metadata_primary_key_ids']);
            }

        }
    }

    public function getItemBatch($start, $batch)
    {
        $db = \XF::db();

        return $db->fetchAllColumn($db->limit('
				SELECT thread.thread_id
				FROM xf_thread AS thread
				INNER JOIN xf_thread_field_value AS field_value ON field_value.thread_id=thread.thread_id
				WHERE thread.thread_id > ?
				GROUP BY thread.thread_id
				ORDER BY thread.thread_id
			', $batch
        ), $start);
    }

    public function getRebuildStatusMessage()
    {
        return \XF::phrase('altf_thread_field_cache');
    }

    public function getEntityWith($forView = false)
    {
        return ['ContentEntity', 'FieldEntity'];
    }

    /**
     * @param ThreadFieldIndex|Entity $entity
     * @return int
     */
    public function getContentUserId(Entity $entity)
    {
        return $entity->ContentEntity->user_id;
    }

    /**
     * @param ThreadFieldIndex|Entity $entity
     * @return int
     */
    public function getContentDiscussionId(Entity $entity)
    {
        return $entity->ContentEntity->thread_id;
    }

    public function setupMetadataStructure(MetadataStructure $structure)
    {
        $structure->addField('node', MetadataStructure::INT);
    }

    /**
     * @param BaseFieldIndexEntity|ThreadFieldIndex $entity
     * @param array $metadata
     * @return array
     */
    public function getMetaData(BaseFieldIndexEntity $entity, array $metadata)
    {
        $metadata['node'] = $entity->ContentEntity->node_id;

        return $metadata;
    }

    public function getFilterName()
    {
        return 'thread_fields';
    }

    public function isSupportedCustomFieldHolder(Entity $entity)
    {

        return ($entity instanceof Thread);
    }

    public function getOptionPrefix()
    {
        return 'altf';
    }

    public function getAddonId()
    {
        return 'AL/ThreadFilter';
    }

    public function getFilterLocationFromViewParams(array $params)
    {
        $defaultLocation = FilterApp::getOptionProvider()->getOption($this->getOptionPrefix() . '_filter_location');
        if (empty($params['forum']))
        {
            return $defaultLocation;
        }

        /** @var Forum $forum */
        $forum = $params['forum'];

        /** @var \AL\ThreadFilter\XF\Entity\Node $node */
        $node = $forum->Node;
        if (!$node->effective_filter_location)
        {
            return $defaultLocation;
        }

        return $node->effective_filter_location;
    }

    public function getFieldCacheFromViewParams(array $params)
    {

        if (isset($params['forum']))
        {
            return (array)$params['forum']->field_cache;
        }

        return [];
    }

    /**
     * @param Entity|Node $category
     * @return array|mixed|null
     */
    public function getFieldCacheForCategory(Entity $category)
    {
        /** @var User $user */
        $user = \XF::visitor();
        if ($category instanceof Node && $category->Data instanceof \XF\Entity\Forum)
        {
            $forum = $category->Data;
        }
        elseif ($category instanceof \XF\Entity\Forum)
        {
            $forum = $category;
        }
        else
        {
            return [];
        }

        if ($user->canUseThreadFilter($forum))
        {
            return $forum->field_cache;
        }

        return [];
    }


    public function getIncludeSubCategoryKeyName()
    {
        return 'child_nodes';
    }

    public function getCategoriesKeyName()
    {
        return 'nodes';
    }

    public function getSearchCategories(array $categoryIds, $includeChildren)
    {
        $allCategories = \XF::repository('XF:Node')->getNodeList()->toArray();
        $allCategories = \XF::repository('XF:Node')->loadNodeTypeDataForNodes($allCategories);

        if (empty($categoryIds))
        {
            $categoryIds = array_keys($allCategories);
        }
        elseif ($includeChildren)
        {
            $nodeTree = \XF::repository('XF:Node')->createNodeTree($allCategories);

            foreach ($categoryIds AS $nodeId)
            {
                $categoryIds = array_merge($categoryIds, $nodeTree->childIds($nodeId));
            }

            $categoryIds = array_unique($categoryIds);
        }

        $allCategories = array_filter($allCategories, function (Node $category) use ($categoryIds)
        {
            return in_array($category->node_id, $categoryIds, true);
        });

        $allCategories = array_map(function (Node $node)
        {
            $data = $node->Data;
            if ($data instanceof \XF\Entity\Forum)
            {
                return $data;
            }
            return null;
        }, $allCategories);

        return array_filter($allCategories);
    }

    public function getParamsForLocation($filterLocation, array $viewParams, Controller $controller, array &$filters)
    {
        $params = [];

        /** @var Forum $forum */
        $forum = $viewParams['forum'];

        // Always try to add these params, as the filter may also be shown in the canvas
        // so even if we are in popup, it will need all the params
        $params += App::getForumRequestHelper()->getFieldParams($forum, $filters);

        return $params;
    }

    public function getCategoryMetadataKey()
    {
        return 'node';
    }

    public function preSearch(Query $query, array &$metadata, array &$constraints)
    {
        // no further tweaks are needed, as both keywords and tags are handled independent of content types
    }

    public function getMaxResultCount()
    {
        return \XF::options()->altf_max_limit ? \XF::options()->altf_max_limit : null;
    }

    public function getKeywordSearchSetting()
    {
        return \XF::options()->altf_keyword_search;
    }

    public function getTagSearchSetting()
    {
        return \XF::options()->altf_tag_search;
    }

    public function getMultiPrefixEnabledSetting()
    {
        return \XF::options()->altf_multi_prefix_search;
    }

    public function getMultiCategorySearchModeSetting()
    {
        return \XF::options()->altf_multi_category_field_mode;
    }

    public function getPrefixEntityName()
    {
        return 'XF:ThreadPrefix';
    }

    public function getGoogleApiKeySetting()
    {
        // Location custom field
        $options = \XF::options();
        if ($options->offsetExists('allf_google_api_key'))
        {
            return $options->allf_google_api_key;
        }

        return '';
    }

    public function getFacetedSearchSetting()
    {
        return \XF::options()->altf_faceted_search;
    }

    public function getAutoHideIfEmptySetting()
    {
        return \XF::options()->altf_auto_hide_if_empty;
    }

    public function getTotalCountIndicatorSetting()
    {
        return \XF::options()->altf_total_count_indicator;
    }

    public function getNumberFormattingExclusionListSetting()
    {
        return \XF::options()->altf_number_formatting_exclusion_list;
    }


}
