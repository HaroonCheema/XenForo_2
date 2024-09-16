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

use AL\FilterFramework\Entity\FieldData;
use AL\FilterFramework\FilterApp;
use AL\ThreadFilter\App;
use XF\Mvc\Entity\Structure;

/**
 * Class ThreadField
 * @package AL\ThreadFilter\XF\Entity
 * @property FieldData $FieldData
 */
class  ThreadField extends XFCP_ThreadField
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        App::getContextProvider()->setupFieldStructure($structure);

        return $structure;
    }

    public function getIsSortable()
    {
        $typeProvider = FilterApp::getTypeProvider();
        if (!$typeProvider->getIndexSortingColumnName($this))
        {
            return false;
        }

        return true;
    }

    public function getRelation($key)
    {
        if ($key === 'FieldData')
        {
            return $this->getRelationOrDefault($key);
        }

        return parent::getRelation($key);
    }

    public function __get($key)
    {
        $value = parent::__get($key);
        
        if ($key === 'field_value' && $this->field_id)
        {
            $value = App::getContextProvider()->fixFieldValueType($this->field_id, $value);
        }
        return $value;
    }


    protected function _postDelete()
    {
        parent::_postDelete();

        App::getFieldIndexer()->deleteFieldIndex($this->field_id);
    }

    public function toArray($allowGetters = true)
    {
        return parent::toArray($allowGetters);
    }
}