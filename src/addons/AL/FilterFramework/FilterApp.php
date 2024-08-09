<?php
/** 
* @package [AL] Filter Framework
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 1.2.1
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


namespace AL\FilterFramework;

use AddonsLab\Core\App;
use AddonsLab\Core\Xf2\AppTrait;
use AL\FilterFramework\Repository\Logger;
use AL\FilterFramework\Service\ActiveFilterHelper;
use AL\FilterFramework\Service\CachedSearchProvider;
use AL\FilterFramework\Service\ContextProvider;
use AL\FilterFramework\Service\DisplayFormatter;
use AL\FilterFramework\Service\ElasticSource;
use AL\FilterFramework\Service\EsMappingHelper;
use AL\FilterFramework\Service\ExtendedAttributeSearcher;
use AL\FilterFramework\Service\FacetedSearchProvider;
use AL\FilterFramework\Service\FieldIndexer;
use AL\FilterFramework\Service\FieldSaver;
use AL\FilterFramework\Service\FieldSorter;
use AL\FilterFramework\Service\GeoLocator;
use AL\FilterFramework\Service\InputTransformer;
use AL\FilterFramework\Service\MySqlSource;
use AL\FilterFramework\Service\PrefixProvider;
use AL\FilterFramework\Service\RequestHelper;
use AL\FilterFramework\Service\TypeProvider;

class FilterApp extends App
{
    use AppTrait;

    /**
     * @return \XF\Service\AbstractService|TypeProvider
     */
    public static function getTypeProvider()
    {
        return \XF::service('AL\FilterFramework:TypeProvider');
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return \XF\Service\AbstractService|FieldSorter
     */
    public static function getFieldSorter(\AL\FilterFramework\ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::service('AL\FilterFramework:FieldSorter', $contentTypeProvider);
    }

    /**
     * @return ActiveFilterHelper
     */
    public static function getActiveFilterHelper()
    {
        return \XF::service('AL\FilterFramework:ActiveFilterHelper');
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return DisplayFormatter
     */
    public static function getDisplayFormatter(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::service('AL\FilterFramework:DisplayFormatter', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return CachedSearchProvider
     */
    public static function getCachedSearchProvider(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::service('AL\FilterFramework:CachedSearchProvider', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return FacetedSearchProvider
     */
    public static function getFacetedSearchProvider(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::service('AL\FilterFramework:FacetedSearchProvider', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface|null $contentTypeProvider
     * @return InputTransformer
     */
    public static function getInputTransformer(ContentTypeProviderInterface $contentTypeProvider = null)
    {
        return \XF::service('AL\FilterFramework:InputTransformer', $contentTypeProvider);
    }

    /**
     * @return Service\ColorConverter|\XF\Service\AbstractService
     */
    public static function getColorConverter()
    {
        return \XF::app()->service('AL\FilterFramework:ColorConverter');
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return ElasticSource
     */
    public static function getElasticSource(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::app()->service('AL\FilterFramework:ElasticSource', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return MySqlSource
     */
    public static function getMySqlSource(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::app()->service('AL\FilterFramework:MySqlSource', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return FieldIndexer
     */
    public static function getFieldIndexer(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::app()->service('AL\FilterFramework:FieldIndexer', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return ContextProvider
     */
    public static function getContextProvider(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::app()->service('AL\FilterFramework:ContextProvider', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return PrefixProvider
     */
    public static function getPrefixProvider(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::app()->service('AL\FilterFramework:PrefixProvider', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return ExtendedAttributeSearcher
     */
    public static function getExtendedAttributeHandler(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::app()->service('AL\FilterFramework:ExtendedAttributeSearcher', $contentTypeProvider);
    }

    /**
     * @return FieldSaver
     * @testable
     */
    public static function getFieldSaver(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::service('AL\FilterFramework:FieldSaver', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return RequestHelper
     */
    public static function getRequestHelper(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::service('AL\FilterFramework:RequestHelper', $contentTypeProvider);
    }

    /**
     * @param ContentTypeProviderInterface $contentTypeProvider
     * @return EsMappingHelper
     */
    public static function getEsMappingHelper(ContentTypeProviderInterface $contentTypeProvider)
    {
        return \XF::service('AL\FilterFramework:EsMappingHelper', $contentTypeProvider);
    }

    /**
     * @return GeoLocator
     */
    public static function getGeoLocator()
    {
        return \XF::service('AL\FilterFramework:GeoLocator');
    }

    /**
     * @return Logger
     */
    public static function getFilterLogger(ContentTypeProviderInterface $contentTypeProvider)
    {
        /** @var Logger $repo */
        $repo = \XF::app()->repository('AL\FilterFramework:Logger');
        $repo->setContentTypeProvider($contentTypeProvider);
        return $repo;
    }

}
