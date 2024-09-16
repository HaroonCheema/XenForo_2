<?php
/** 
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
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


namespace AL\FilterFramework\tests;

use AddonsLab\Core\Xf2\SetupTrait;
use AL\FilterFramework\ContentTypeProviderInterface;
use AL\FilterFramework\FilterApp;
use AL\FilterFramework\FilterSetupInterface;
use AL\FilterFramework\Flags;
use AL\FilterFramework\Service\CachedSearchProvider;
use AL\FilterFramework\Service\FacetedSearchProvider;
use AL\FilterFramework\Service\GeoLocator;
use AL\TestFramework\TestCase;
use AL\TestFramework\TestHelper;
use XF\CustomField\Definition;
use XF\Mvc\Entity\Entity;
use XF\Search\Source\MySqlFt;
use XFES\Search\Source\Elasticsearch;
use XFES\Service\Optimizer;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

abstract class FilterTestCase extends TestCase
{
    use BaseTestTrait;

    protected static $esSource = [
        'es'
    ];

    /**
     * @param array $fieldOverride
     * @return Entity
     */
    abstract public function createTestItem($fieldOverride = array());

    /**
     * @return ContentTypeProviderInterface
     */
    abstract protected function _getContentTypeProvider();

    /**
     * @return CachedSearchProvider
     */
    protected function _getCachedSearchProvider()
    {
        return FilterApp::getCachedSearchProvider($this->_getContentTypeProvider());
    }

    /**
     * @return FacetedSearchProvider
     */
    protected function _getFacetedSearchProvider()
    {
        return FilterApp::getFacetedSearchProvider($this->_getContentTypeProvider());
    }

    abstract protected function _getFieldSetup();

    abstract protected function _getPositiveSearchData();

    abstract protected function _getNegativeSearchData();

    abstract protected function _getEntityCategoryId(Entity $entity);

    abstract protected function _getAddonId();

    public function testInstaller()
    {
        self::markTestSkipped('Installer was not tested');

        /** @var \XF\AddOn\Manager $addOnManager */
        $addOnManager = \XF::app()->container('addon.manager');
        $addOn = $addOnManager->getById($this->_getAddonId());

        self::assertNotNull($addOn);

        /** @var FilterSetupInterface|SetupTrait $setup */
        $setup = $addOn->getSetup();
        // license check should not throw any exceptions and return true
        self::assertTrue($setup->assertLicense());


        // get the mappings and change the names of tables and columns to run test installation
        $createMapping = $setup->getTestCreateMapping();
        $alterMapping = $setup->getTestAlterMapping();

        self::assertNull($setup->assertCreateTable($createMapping));
        self::assertNull($setup->assertAlterTable($alterMapping));
        self::assertNull($setup->deleteTables($createMapping));
        self::assertNull($setup->deleteColumns($alterMapping));
    }

    public function test_mysql_ft_class_extension()
    {
        // Disable the legacy extension system of Core package
        \XF::options()->al_core_legacy_extension = false;

        $addonId = $this->_getAddonId();
        $addonNamespace = str_replace('/', '\\', $addonId);

        \XF::app()->options()->xfesEnabled = 0;
        \XF::app()->container()->decache('search');
        \XF::app()->container()->decache('search.source');
        $source = \XF::app()->container('search.source');
        self::assertInstanceOf(MySqlFt::class, $source);
        self::assertInstanceOf($addonNamespace . '\\XF\\Search\\Source\\MySqlFt', $source);

        assertSame('XF\Search\Source\MySqlFt', \XF::extension()->resolveExtendedClassToRoot($source));
    }

    public function test_geocoder()
    {
        if (!\XF::options()->offsetExists('allf_google_api_key'))
        {
            self::markTestSkipped('Skipped geocoder test as location custom field is not configured . ');
        }

        /** @var GeoLocator $geocoder */
        $geocoder = \XF::service('AL\FilterFramework:GeoLocator');

        $info = $geocoder->getAddressCoordinates('48E 81st Street, New York, NY', 'US');

        self::assertSame(['lat' => round(40.777126), 'lng' => round(-73.960449)], [
            'lat' => round($info['lat']),
            'lng' => round($info['lng']),
        ]);
    }

    public function test_detect_field_id_from_input_name()
    {
        $contentTypeProvider = $this->_getContentTypeProvider();
        $contextProvider = FilterApp::getContextProvider($contentTypeProvider);
        assertSame('field_id', $contextProvider->getFieldIdFromInputName('c[' . $contentTypeProvider->getFilterName() . '][field_id]'));
        assertSame('field_id', $contextProvider->getFieldIdFromInputName($contentTypeProvider->getFilterName() . '[field_id]'));
        assertSame('field_id', $contextProvider->getFieldIdFromInputName($contentTypeProvider->getFilterName() . '[field_id][]'));
    }

    public function testDeleteOrphanedIndex()
    {
        $contentTypeProvider = $this->_getContentTypeProvider();

        $fakeContentTypeProvider = $this->prophesize(get_class($contentTypeProvider));

        $fakeContentTypeProvider->getFieldDefinitions()->willReturn([
            'field1' => [
                'field_id' => 'field1',
            ],
            'field2' => [
                'field_id' => 'field2',
            ],
            'field3' => [
                'field_id' => 'field3',
            ],
        ]);

        $fakeContentTypeProvider->getContentType()->willReturn('some_content_type');

        $indexer = FilterApp::getFieldIndexer($fakeContentTypeProvider->reveal());

        $fieldIds = $indexer->deleteOrphanedIndex();

        self::assertSame(["'field1'", "'field2'", "'field3'"], $fieldIds);
    }

    public function provideSearchSource()
    {
        // Elastic server runs on a separate docker setup on a linux container
        $sources = [
            ['default']
        ];

        if (TestHelper::isAddOnActive('XFES') && !empty($_ENV['ES_HOST']))
        {
            $sources = array_merge(
                [
                    ['elastic7', $_ENV['ES_HOST'], 9207],
                    ['elastic6', $_ENV['ES_HOST'], 9206],
                    ['elastic2', $_ENV['ES_HOST'], 9202],
                ],
                $sources
            );
        }

        return $sources;
    }

    /**
     * @dataProvider provideSearchSource
     */
    public function testFacetedSearch($source, $ip = '', $port = 9200)
    {
        if ($this->_getContentTypeProvider()->getFacetedSearchSetting() === null)
        {
            self::markTestSkipped('Faceted search is not implemneted in this product');
        }

        // Enable elastic search index
        $this->_setupSource($source, $ip, $port);

        $provider = $this->_getFacetedSearchProvider();

        // create an item with the default data
        $item1 = $this->createTestItem();

        // another item with the same data
        $item2 = $this->createTestItem();

        // get the data used an change it so we have an item with different values
        $alternativeData = array_map(function (array $field)
        {
            if (isset($field['search_query_not']))
            {
                return $field['search_query_not'];
            }
            return null;
        }, \AL\FilterFramework\tests\BaseFilterFixtureTest::getFields());

        $alternativeData = array_filter($alternativeData);

        $item3 = $this->createTestItem($alternativeData);

        self::assertNotEmpty($item1->getEntityId());
        self::assertNotEmpty($item2->getEntityId());
        self::assertNotEmpty($item3->getEntityId());

        $itemIds = [$item1->getEntityId(), $item2->getEntityId(), $item3->getEntityId()];

        $this->_preSearch($source);

        $typeProvider = FilterApp::getTypeProvider();

        $fixtureFields = BaseFilterFixtureTest::getTestItemData();

        // get all custom fields of type selection
        $fields = array_filter($this->_getContentTypeProvider()->getFieldDefinitions(), function (Definition $definition) use ($typeProvider, $fixtureFields)
        {
            if (!isset($fixtureFields[$definition->field_id]))
            {
                return false;
            }

            return $typeProvider->isSingleOption($definition) || $typeProvider->isMultipleOption($definition) || $typeProvider->isLocationField($definition);
        });

        $fieldsIds = array_keys($fields);

        $elasticSearchCounts = $provider->getFacetCounts($itemIds, $fieldsIds, true);

        // switch back to MySQL
        $this->_setupSource('default');
        $sqlCount = $provider->getFacetCounts($itemIds, $fieldsIds, true);

        self::assertEquals(
            $sqlCount,
            $elasticSearchCounts,
            "Facet counts don't match between SQL and Elasticsearch"
        );

        self::assertCount(count($fieldsIds), $elasticSearchCounts);

        $this->_cleanupSource($source);
    }

    /**
     * @dataProvider provideSearchSource
     */
    public function testSearcher($source, $ip = '', $port = 9200)
    {
        $this->_setupSource($source, $ip, $port);

        /** @var Entity $item */
        $item = $this->createTestItem();

        // test option/sub-option search
        $itemWithSubOption = $this->createTestItem(['select_partial_match' => 'option_1_partial_match']);

        $this->_preSearch($source);

        $itemId = $item->getEntityId();
        $cachedSearchProvider = $this->_getCachedSearchProvider();

        list($metadata, $filterData) = $this->_getSampleData($item);

        $cachedSearchProvider->setDisableCache(true);

        // test searching fields one by one and we should again have a item in the results
        // we will use the same metadata as before
        $data = $this->_getPositiveSearchData();
        foreach ($data as $fieldId => $datum)
        {
            $results = $cachedSearchProvider->executeSearch([$fieldId => $datum], $metadata);
            try
            {
                self::assertContainsEquals($itemId, $results, "Failed search for field $fieldId");
            }
            catch (\Exception $exception)
            {
                throw $exception;
            }

        }

        global $TEST_ITEM_ID;
        $TEST_ITEM_ID = $itemId;
        // running them all together should give the same result
        $results = $cachedSearchProvider->executeSearch($data, $metadata);

        self::assertContainsEquals($itemId, $results);


        // cache should be used this time
        $cachedSearchProvider->setDisableCache(false);
        $results = $cachedSearchProvider->executeSearch($data, $metadata);
        self::assertContainsEquals($itemId, $results);

        // disable the cache for all other operations
        $cachedSearchProvider->setDisableCache(true);

        // test that setting item IDs in metadata restriction returns correct results
        $results = $cachedSearchProvider->executeSearch($data, ['__metadata_primary_key_ids' => [$itemId, 999]] + $metadata);
        self::assertContainsEquals($itemId, $results);

        // putting item ids filters should give us result not containing the current item id
        $results = $cachedSearchProvider->executeSearch($data, $metadata + ['__metadata_primary_key_ids' => $itemId + 1]);
        self::assertNotContains($itemId, $results);

        // change the category ID and we again should not get the item back
        if ($this->_getEntityCategoryId($item))
        {
            // Only makes sense for entities that have category ID
            $results = $cachedSearchProvider->executeSearch($data, ['category_ids' => [$this->_getEntityCategoryId($item) + 1]] + $metadata);
            self::assertNotContains($itemId, $results);
        }

        // test negative searches
        $negativeData = $this->_getNegativeSearchData();

        $results = $cachedSearchProvider->executeSearch($negativeData, $metadata);
        self::assertNotContains($itemId, $results);

        // test fields one by one
        foreach ($negativeData as $fieldId => $datum)
        {
            $results = $cachedSearchProvider->executeSearch([$fieldId => $datum], $metadata);
            try
            {
                self::assertNotContains($itemId, $results);
            }
            catch (\Exception $exception)
            {
                throw $exception;
            }
        }

        // searching for the item with option1_suboption1 value should bring it back
        $results = $cachedSearchProvider->executeSearch(['select_partial_match' => 'option_1_partial_match'], ['__metadata_primary_key_ids' => [$itemWithSubOption->getEntityId()]]);
        self::assertContainsEquals($itemWithSubOption->getEntityId(), $results);

        // searching for the item with option_1 value should not bring it back
        $results = $cachedSearchProvider->executeSearch(['select_partial_match' => 'option_1'], ['__metadata_primary_key_ids' => [$itemWithSubOption->getEntityId()]]);
        self::assertNotContains($itemWithSubOption->getEntityId(), $results);

        // searching for the item with option_1 value AND allow_partial_match should bring it back
        $results = $cachedSearchProvider->executeSearch(['select_partial_match' => 'option_1'], [Flags::SINGLE_CHOICE_PARTIAL_MATCH => true, '__metadata_primary_key_ids' => [$itemWithSubOption->getEntityId()]]);
        self::assertContainsEquals($itemWithSubOption->getEntityId(), $results);
    }

    /**
     * @dataProvider provideSearchSource
     */
    public function testDiscussionIdSearch($source, $ip = '', $port = 9200)
    {
        $this->_setupSource($source, $ip, $port);

        /** @var Entity $item */
        $item = $this->createTestItem();

        $this->_preSearch($source);

        $itemId = $item->getEntityId();
        $cachedSearchProvider = $this->_getCachedSearchProvider();
        $cachedSearchProvider->setDisableCache(true);

        $categoryIds = [];
        if ($this->_getEntityCategoryId($item))
        {
            $categoryIds[] = $this->_getEntityCategoryId($item);
        }
        $results = $cachedSearchProvider->executeSearch([], [
            '__metadata_primary_key_ids' => [$itemId],
            'category_ids' => $categoryIds,
        ]);
        self::assertContainsEquals($itemId, $results);
    }

    protected function _getSampleData(Entity $entity)
    {
        return [
            ['category_ids' => [$this->_getEntityCategoryId($entity
            )]],
            array_map(function ($field)
            {
                if (isset($field['search_query']))
                {
                    return $field['search_query'];
                }

                return $field['item_value'];
            }, $this->_getFieldSetup())
        ];
    }

    protected function _setupSource($source, $ip = '', $port = 9200)
    {
        \XF::app()->container()->decache('search');
        \XF::app()->container()->decache('search.source');

        static $v;

        if ($v === null)
        {
            $v = time();
        }

        if (strpos($source, 'elastic') === 0)
        {
            if (!TestHelper::isAddOnActive('XFES'))
            {
                self::markTestSkipped("Search source not available: $source");
            }

            \XF::app()->options()->xfesEnabled = 1;
            $config = \XF::app()->options()->xfesConfig;
            $config['host'] = $ip;
            $config['port'] = $port;
            // unset($config['singleType']);
            $config['index'] = 'ci-' . $v . '-' . $source;

            \XF::app()->options()->xfesConfig = $config;

            self::assertInstanceOf(Elasticsearch::class, \XF::app()->container('search.source'));

            /** @var Optimizer $optimizer */
            $optimizer = \XF::service('XFES:Optimizer', \XFES\Listener::getElasticsearchApi());
            $optimizer->optimize([], false);

            // $api = \XFES\Listener::getElasticsearchApi();
            // $config = $api->getConfig();
            // $health = $api->request('GET', $config['index'] . '/_refresh');
        }
        else
        {
            \XF::app()->options()->xfesEnabled = 0;
            self::assertInstanceOf(MySqlFt::class, \XF::app()->container('search.source'));
        }
    }

    protected function _cleanupSource($source)
    {
        if (strpos($source, 'elastic') === 0)
        {
            // \XFES\Listener::getElasticsearchApi()->request('DELETE', '/ci-*');
            // sleep(2);
        }
    }

    protected function _preSearch($source)
    {
        if ($source !== 'default')
        {
            $api = \XFES\Listener::getElasticsearchApi();
            $config = $api->getConfig();
            $api->request('POST', $config['index'] . '/_refresh');

            // It seems it still needs some additional time to process the items
            sleep(5);
        }
    }
}
