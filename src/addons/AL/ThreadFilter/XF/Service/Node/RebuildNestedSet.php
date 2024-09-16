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


namespace AL\ThreadFilter\XF\Service\Node;

use AL\FilterFramework\FilterApp;
use AL\FilterFramework\RebuildNestedSetTrait;
use AL\ThreadFilter\App;

/**
 * Class RebuildNestedSet
 * @package AL\ThreadFilter\XF\Service\Node
 * Overridden to include effective setting for filter location for child nodes
 */
class  RebuildNestedSet extends XFCP_RebuildNestedSet
{
    use RebuildNestedSetTrait;

    public function __construct(\XF\App $app, $entityType, array $config = [])
    {
        parent::__construct($app, $entityType, $config);


        $logger = FilterApp::getFilterLogger(App::getContentTypeProvider());

        // Enable this line to see the log messages in the file
        // $logger->setForceLogToFile(true);

        $this->setLogger($logger);
        $logger->logMessage(\Monolog\Logger::DEBUG, 'RebuildNestedSet: ' . $entityType);
    }
}