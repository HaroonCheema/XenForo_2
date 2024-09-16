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


namespace AL\ThreadFilter\XF\Search\Data;

use AL\ThreadFilter\App;
use XF\Search\Query\Query;

class  Post extends XFCP_Post
{
    /**
     * @param Query $query
     * @param \XF\Http\Request $request
     * @param array $urlConstraints
     * Set custom field data submitted as a property to the query object to use later
     */
    public function applyTypeConstraintsFromInput(\XF\Search\Query\Query $query, \XF\Http\Request $request, array &$urlConstraints)
    {
        parent::applyTypeConstraintsFromInput($query, $request, $urlConstraints);

        App::getContextProvider()->setupUrlConstraints($urlConstraints);
    }
}