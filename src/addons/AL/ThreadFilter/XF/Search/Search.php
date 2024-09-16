<?php
/** 
* @package [AddonsLab] Thread Filter
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 3.8.0
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


namespace AL\ThreadFilter\XF\Search;

use AL\FilterFramework\Field\AbstractField;
use AL\ThreadFilter\ThreadSearchInterface;
use XF\Entity\Post;

/**
 * Class Search
 * @package AL\ThreadFilter\XF\Search
 * Re-index thread fields when a thread is being indexed
 */
class  Search extends XFCP_Search
{
    /**
     * @param AbstractField[] $fieldList
     * @return array
     */
    public function searchThreadIdsByCustomFields(array $fieldList, array $metadata)
    {
        /** @var ThreadSearchInterface $source */
        $source = $this->source;

        if (($source instanceof ThreadSearchInterface) === false) {
            // the source is not supported
            return [];
        }

        return $source->searchThreadIdsByCustomFields($fieldList, $metadata);
    }

    public function countFacetsByThreadIds(array $threadIds, array $fieldIds)
    {
        /** @var ThreadSearchInterface $source */
        $source = $this->source;

        if (($source instanceof ThreadSearchInterface) === false)
        {
            // the source is not supported
            return [];
        }

        return $source->countFacetsByThreadIds($threadIds, $fieldIds);
    }
}