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


namespace AL\ThreadFilter\XFES\Search\Source;

use AL\FilterFramework\Field\AbstractField;
use AL\ThreadFilter\App;
use AL\ThreadFilter\ThreadSearchInterface;
use XF\Search\Query;

class Elasticsearch extends XFCP_Elasticsearch implements ThreadSearchInterface
{
    /**
     * @param \XF\Search\Query\Query $query
     * @param array $filters
     * @param array $filtersNot
     * This runs before the actual elastic search query,
     * we use it to find all threads matching field criteria and apply these as criteria for elastic search
     */
    protected function applyDslFilters(Query\Query $query, array &$filters, array &$filtersNot)
    {
        parent::applyDslFilters($query, $filters, $filtersNot);

        if ($queryConstrains = App::getContextProvider()->getQueryConstrains())
        {
            // detect the category IDs we are searching in to narrow-down the rows parsed
            $discussionIds = App::getContextProvider()->getDiscussionIdsByCategoryMetadata(
                $queryConstrains,
                $query->getMetadataConstraints()
            );
            if ($discussionIds !== false)
            {
                // apply the discussion IDs as a filter
                $this->applyMetadataConstraint(
                    new Query\MetadataConstraint('discussion_id', $discussionIds),
                    $filters, $filtersNot
                );
            }
        }
    }

    /**
     * @param AbstractField[] $fieldList
     * @return array|bool|\XF\Mvc\Entity\ArrayCollection
     * @throws \XF\PrintableException
     */
    public function searchThreadIdsByCustomFields(array $fieldList, array $metadata)
    {
        return App::getElasticSearcher()->search($fieldList, $metadata);
    }

    public function countFacetsByThreadIds(array $threadIds, array $fieldIds)
    {
        return App::getElasticSearcher()->countFacets($threadIds, $fieldIds);
    }


}