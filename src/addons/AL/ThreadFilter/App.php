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


namespace AL\ThreadFilter;

use AddonsLab\Core\Xf2\AppTrait;
use AL\FilterFramework\ContentTypeProviderInterface;
use AL\FilterFramework\FilterApp;
use AL\FilterFramework\Service\ElasticSource;
use AL\FilterFramework\Service\FacetedSearchProvider;
use AL\FilterFramework\Service\FieldSaver;
use AL\FilterFramework\Service\MySqlSource;
use AL\FilterFramework\Service\RequestHelper;
use AL\ThreadFilter\Service\ForumRequestHelper;

class App extends \AddonsLab\Core\App
{
    use AppTrait;

    /**
     * @return ContentTypeProviderInterface
     * @testable
     */
    public static function getContentTypeProvider()
    {
        return \XF::service('AL\ThreadFilter:ContentTypeProvider');
    }

    /**
     * @return \AL\FilterFramework\Service\CachedSearchProvider
     * @testable
     */
    public static function getCachedSearchProvider()
    {
        return FilterApp::getCachedSearchProvider(static::getContentTypeProvider());
    }
    
    /**
     * @return \AL\FilterFramework\Service\DisplayFormatter
     * @testable
     */
    public static function getDisplayFormatter()
    {
        return FilterApp::getDisplayFormatter(static::getContentTypeProvider());
    }

    /**
     * @return ElasticSource
     * @testable
     */
    public static function getElasticSearcher()
    {
        return FilterApp::getElasticSource(static::getContentTypeProvider());
    }

    /**
     * @return MySqlSource
     * @testable
     */
    public static function getMySqlSource()
    {
        return FilterApp::getMySqlSource(static::getContentTypeProvider());
    }

    /**
     * @return \AL\FilterFramework\Service\FieldIndexer
     * @testable
     */
    public static function getFieldIndexer()
    {
        return FilterApp::getFieldIndexer(static::getContentTypeProvider());
    }

    /**
     * @return FieldSaver
     * @testable
     */
    public static function getFieldSaver()
    {
        return FilterApp::getFieldSaver(self::getContentTypeProvider());
    }

    /**
     * @return RequestHelper
     */
    public static function getRequestHelper()
    {
        return FilterApp::getRequestHelper(self::getContentTypeProvider());
    }

    /**
     * @return ForumRequestHelper
     */
    public static function getForumRequestHelper()
    {
        return \XF::service('AL\ThreadFilter:ForumRequestHelper');
    }

    public static function getContextProvider()
    {
        return FilterApp::getContextProvider(
            self::getContentTypeProvider()
        );
    }

    /**
     * @return FacetedSearchProvider
     */
    public static function getFacetedSearchProvider()
    {
        return \XF::service('AL\FilterFramework:FacetedSearchProvider', self::getContentTypeProvider());
    }
}