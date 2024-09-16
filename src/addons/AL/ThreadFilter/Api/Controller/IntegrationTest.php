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


namespace AL\ThreadFilter\Api\Controller;

use AL\FilterFramework\Service\FieldCreator;
use \XF\Api\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class IntegrationTest extends AbstractController
{
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertSuperUserKey();
    }

    public function actionPostCreateField()
    {
        // TODO work in progress
        $field_id = $this->filter('field_id', 'str');
        $title = $this->filter('title', 'str');

        /** @var FieldCreator $fieldCreator */
        $fieldCreator = \XF::service('AL\FilterFramework:FieldCreator');

        $field = $fieldCreator->setupFieldEntity(
            $field_id, [
                'field_type' => $this->filter('field_type', 'str'),
                'match_type' => $this->filter('match_type', 'str'),
                'match_params' => $this->filter('match_type', 'array'),
                'field_choices'=> $this->filter('field_choices', 'array'),
            ],
            'XF:ThreadField'
        );

        $isInsert = $field->isInsert();

        $field->save();

        if ($isInsert)
        {
            /** @var \XF\Entity\Phrase $titlePhrase */
            $titlePhrase = $field->getMasterPhrase(true);
            $descriptionPhrase = $field->getMasterPhrase(false);

            $titlePhrase->phrase_text = $title;

            $descriptionPhrase->phrase_text = '';

            $titlePhrase->save();
            $descriptionPhrase->save();
        }

        return $this->apiResult([
            'success' => true,
        ]);
    }
}

