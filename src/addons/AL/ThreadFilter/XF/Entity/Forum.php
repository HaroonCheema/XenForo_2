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


namespace AL\ThreadFilter\XF\Entity;

use AL\ThreadFilter\App;
use XF\Mvc\Entity\Structure;

/**
 * Class Forum
 * @package AL\ThreadFilter\XF\Entity
 * @property array field_column_cache
 */
class  Forum extends XFCP_Forum
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['field_column_cache'] = ['type' => self::SERIALIZED_ARRAY, 'default' => []];

        $structure->getters['display_fields'] = true;

        return $structure;
    }

    /**
     * @return array
     * Based on admin panel configuration, creates and returns grouped list of custom fields
     */
    public function getDisplayFields()
    {
        return App::getContextProvider()->getPreparedFieldCache(
            $this->field_column_cache ?: []
        );
    }

}
