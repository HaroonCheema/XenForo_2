<?php
/** 
* @package [AL] Filter Framework
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 1.0.0
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


namespace AL\FilterFramework\Service;

use XF\Http\Request;
use XF\Mvc\Reply\View;
use XF\Service\AbstractService;

class TotalCountCalculator extends AbstractService
{
    protected static $count;

    public function setTotalCount($count)
    {
        self::$count = $count;
    }

    public function getTotalCount($url, $param = 'total')
    {
        if (self::$count !== null)
        {
            return self::$count;
        }

        // will prevent recursive call to this method
        self::$count = 0;

        $server = $_SERVER;
        $urlInfo = parse_url($url);

        if (empty($urlInfo['path']))
        {
            return self::$count;
        }

        $server['REQUEST_URI'] = $urlInfo['path'] . (!empty($urlInfo['query']) ? '?' . $urlInfo['query'] : '');
        $request = new Request(
            \XF::app()->inputFilterer(),
            null,
            null,
            null,
            $server
        );

        $dispatcher = $this->app->dispatcher();
        $routePath = $request->getRoutePath();
        $match = $dispatcher->getRouter()->routeToController($routePath, $request);
        $testReply = $dispatcher->dispatchLoop($match);
        if ($testReply instanceof View)
        {
            self::$count = $testReply->getParam($param);
        }

        return self::$count;
    }
}
