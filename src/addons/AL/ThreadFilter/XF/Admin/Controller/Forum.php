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


namespace AL\ThreadFilter\XF\Admin\Controller;

use AL\ThreadFilter\App;
use AL\ThreadFilter\Setup;
use XF\Mvc\FormAction;

class  Forum extends XFCP_Forum
{
    /**
     * @param FormAction $form
     * @param \XF\Entity\Node $node
     * @param \AL\ThreadFilter\XF\Entity\Forum $data
     */
    protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
    {
        parent::saveTypeData($form, $node, $data);

        $form->setup(function () use ($node)
        {
            $node->filter_location = $this->filter('filter_location', 'str');
        });

        $field_column_cache = $this->filter('field_column_cache', 'array-array');
        $form->complete(function () use ($node, $data, $field_column_cache)
        {
            App::getContextProvider()->postSaveNode($node);
            
            $data->field_column_cache = $field_column_cache;
            $data->saveIfChanged();
        });
    }
}