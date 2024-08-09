<?php
/** 
* @package [AL] Filter Framework
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 1.2.1
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

namespace AL\FilterFramework;

use AL\FilterFramework\Field\AbstractField;

/**
 * Interface DataSourceInterface
 * @package AL\FilterFramework
 * Execute the search against the database
 */
interface DataSourceInterface
{
    /**
     * @param AbstractField[] $fieldList
     * @param array $metadata Any additional data provided to different searchers should be provided here
     * @return int[] Array of content IDs matching the search criteria 
     */
    public function search(array $fieldList, array $metadata=[]);

    public function countFacets(array $discussionIds, array $fieldIds);
}