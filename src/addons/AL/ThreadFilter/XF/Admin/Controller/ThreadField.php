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


namespace AL\ThreadFilter\XF\Admin\Controller;

use AL\FilterFramework\Entity\FieldData;
use AL\ThreadFilter\App;
use XF\Mvc\Reply\View;

class  ThreadField extends XFCP_ThreadField
{
    protected function fieldSaveProcess(\XF\Entity\AbstractField $field)
    {
        $form=parent::fieldSaveProcess($field);

        /** @var \AL\ThreadFilter\XF\Entity\ThreadField $field */
        $form->setup(function () use ($field) {
            App::getFieldSaver()->setupFromInput($field, $this);
        });
        
        return $form;
    }
}