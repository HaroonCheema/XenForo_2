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


namespace AL\ThreadFilter\XF\Template;

use AL\FilterFramework\FilterApp;
use XF\App;
use XF\Language;

class  Templater extends XFCP_Templater
{
    public function __construct(App $app, Language $language, $compiledPath)
    {
        parent::__construct($app, $language, $compiledPath);

        $this->addFilter('thread_fields_array_sub_replace', [$this, 'thread_fields_filterReplaceArraySubItem']);

    }

    public function fnPhraseDynamic($templater, &$escape, $phraseName, array $params = [])
    {
        if (strpos($phraseName, 'forum_sort.thread_fields_') === 0)
        {
            $fieldId = str_replace('forum_sort.thread_fields_', '', $phraseName);

            // Name of custom field, detect the field
            $viewParams = \AL\ThreadFilter\App::getContextProvider()->getContextParams();
            if (isset($viewParams['sortableFields'][$fieldId]))
            {
                return $viewParams['sortableFields'][$fieldId]['title'];
            }
        }
        return parent::fnPhraseDynamic($templater, $escape, $phraseName, $params);
    }


    public function thread_fields_filterReplaceArraySubItem($templater, $value, &$escape, $key, $from, $to = null, $subItemId = null)
    {
        return FilterApp::getActiveFilterHelper()->replaceSubFilter(
            $templater,
            $value,
            $escape,
            $key,
            $from,
            $to,
            $subItemId
        );
    }
}
