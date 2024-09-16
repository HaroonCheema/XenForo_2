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


namespace AL\ThreadFilter\Job;

use AL\ThreadFilter\App;
use XF\Job\AbstractRebuildJob;

class ThreadField extends AbstractRebuildJob
{
    /**
     * @param int $start
     * @param int $batch
     * @return array
     * @testable
     */

    public function getItemBatch($start, $batch)
    {
        if ($start === 0)
        {
            App::getFieldIndexer()->deleteOrphanedIndex();
        }

        return App::getContentTypeProvider()->getItemBatch($start, $batch);
    }
    
    protected function getNextIds($start, $batch)
    {
        return $this->getItemBatch($start, $batch);
    }

    protected function rebuildById($id)
    {
        return App::getContextProvider()->runRebuildById($id);
    }

    protected function getStatusType()
    {
        return App::getContentTypeProvider()->getRebuildStatusMessage();
    }
}