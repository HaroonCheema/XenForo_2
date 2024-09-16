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


namespace AL\ThreadFilter\Service;

use AL\ThreadFilter\App;
use AL\ThreadFilter\XF\Entity\Forum;
use AL\ThreadFilter\XF\Entity\ThreadField;
use XF\CustomField\Definition;
use XF\Service\AbstractService;

class ForumRequestHelper extends AbstractService
{
    /**
     * @param \XF\Entity\Forum $forum
     * @param array $filters
     * @return array
     */
    public function getFieldParams(\XF\Entity\Forum $forum, array $filters)
    {
        if (!empty($filters['starter_id'])) {
            $starterFilter = $this->em()->find('XF:User', $filters['starter_id']);
        } else {
            $starterFilter = null;
        }

        $viewParams = [
            'forum' => $forum,
            'prefixes' => $forum->prefixes->groupBy('prefix_group_id'),
            'starterFilter' => $starterFilter,
        ];

        return $viewParams;
    }
}