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

use AL\FilterFramework\Service\FieldCreator;
use AL\LocationField\Constants;
use AL\TestFramework\Helper\Rebuilder;
use AL\TestFramework\NoTransactionTestCase;
use AL\TestFramework\Service\FakeUserCreatorService;
use AL\TestFramework\TestHelper;
use XF\Entity\AbstractField;
use XF\Mvc\Entity\Entity;
use function PHPUnit\Framework\assertNotEmpty;

abstract class BaseFilterFixtureTest extends NoTransactionTestCase
{
    use BaseTestTrait;

    protected abstract function _getCategoryClassName();

    protected abstract function _getFieldClassName();

    protected abstract function _getFieldShortName();

    protected abstract function _getRepositoryShortName();

    protected function _assert_location_field_available()
    {
        if (TestHelper::isAddOnActive('AL/LocationField'))
        {
            assertNotEmpty(\XF::options()->allf_google_api_key, 'Please run location field tests to setup the API key.');
        }
        else
        {
            $this->assertTrue(true);
        }
    }

    public function test_location_field_option()
    {
        $this->_assert_location_field_available();
    }

    public function testInitEs()
    {
        if (!TestHelper::isAddOnActive('XFES'))
        {
            self::markTestSkipped('XFES is not installed');
        }

        TestHelper::setupElasticSearchServer();
    }

    public function testDeleteCustomFields()
    {
        self::markTestSkipped('Custom field deletion is skipped');
        /** @var AbstractField[] $fields */
        $fields = \XF::finder($this->_getFieldShortName())->fetch();
        foreach ($fields as $field)
        {
            $field->delete();
        }
        $fields = \XF::finder($this->_getFieldShortName())->fetch();
        self::assertSame(0, $fields->count());
    }

    public function testRandomUsers()
    {
        $userCount = \XF::finder('XF:User')->total();

        if ($userCount > 10)
        {
            self::assertTrue(true);
            return;
        }

        /** @var FakeUserCreatorService $service */
        $service = \XF::service('AL\TestFramework:FakeUserCreatorService');
        $users = [];

        for ($i = 0; $i < 10; $i++)
        {
            $users[] = $service->createUser();
        }

        \XF::triggerRunOnce();

        self::assertCount(10, $users);
    }

    /**
     * @throws \XF\PrintableException
     *
     * @depends testRandomUsers
     */
    public function testCreateCustomFields()
    {
        $category = static::assertTestCategory();
        if ($category !== null)
        {
            self::assertInstanceOf($this->_getCategoryClassName(), $category);
            $subCategories = static::getSubCategories($category);
            self::assertCount(5, $subCategories);
            $categoryIds = array_merge(array_keys($subCategories), [$category->getEntityId()]);
        }

        $requireRebuild = [];
        $index = 0;

        /** @var FieldCreator $fieldCreator */
        $fieldCreator = \XF::service('AL\FilterFramework:FieldCreator');

        foreach (static::getFields() as $field_id => $fieldDef)
        {
            $index++;
            $displayOrder = $index * 10;

            $field = $fieldCreator->setupFieldEntity(
                $field_id,
                $fieldDef,
                $this->_getFieldShortName()
            );

            $field->display_order = $displayOrder;

            if ($fieldDef['field_type'] === 'location')
            {
                $field->location_options = [
                    'field_format' => $fieldDef['field_format'],
                ];
            }

            $isInsert = $field->isInsert();

            try
            {
                $field->save();
            }
            catch (\Exception $e)
            {
                $test = 0;
            }

            if ($isInsert)
            {
                /** @var \XF\Entity\Phrase $titlePhrase */
                $titlePhrase = $field->getMasterPhrase(true);
                $descriptionPhrase = $field->getMasterPhrase(false);

                $titlePhrase->phrase_text = $fieldDef['title'];

                $descriptionPhrase->phrase_text = '';

                $titlePhrase->save();
                $descriptionPhrase->save();
            }

            self::assertInstanceOf($this->_getFieldClassName(), $field);

            if ($category !== null)
            {
                /** @var \XF\Repository\AbstractFieldMap $repo */
                $repo = \XF::repository($this->_getRepositoryShortName());
                $repo->updateFieldAssociations($field, $categoryIds);
            }
        }

        // run the scheduled tasks
        Rebuilder::rebuildData();
    }

    public static function getFields()
    {
        $fields = [
            'field_1' => [
                'title' => 'Simple text field',
                'field_type' => 'textbox',
                'item_value' => 'massa bibendum',
                'search_query_not' => 'efficitur',
            ],
            'field_3' => [
                'title' => 'Multi-line text',
                'field_type' => 'textarea',
                'item_value' => 'Some test text efficitur turpis in it.',
                'search_query' => 'efficitur turpis',
                'search_query_not' => 'bibendum',
            ],
            'field_4' => [
                'title' => 'Rich Textbox',
                'field_type' => 'bbcode',
                'item_value' => 'Test with BBCode [B]dolor lobortis[/B] in it',
                'search_query' => 'dolor lobortis',
                'search_query_not' => 'turpis',
            ],
            'field_5' => [
                'title' => 'Drop-down selection',
                'field_type' => 'select',
                'field_choices' => array(
                    'option_1' => 'Option 1 value',
                    'option_2' => 'Option 2 value',
                ),
                'item_value' => 'option_1',
                'search_query_not' => 'option_2',
            ],
            'field_6' => [
                'title' => 'Radio buttons',
                'field_type' => 'radio',
                'item_value' => 'option_2',
                'search_query_not' => 'option_1',
                'field_choices' => array(
                    'option_1' => 'Option 1 value',
                    'option_2' => 'Option 2 value',
                ),
            ],
            'field_7' => [
                'title' => 'Check boxes',
                'field_type' => 'checkbox',
                'field_choices' => array(
                    'option_1' => 'Option 1 value',
                    'option_2' => 'Option 2 value',
                    'option_3' => 'Option 3 value',
                    'option_4' => 'Option 4 value',
                ),
                'item_value' => ['option_1', 'option_2'],
                'search_query_not' => ['option_3'],
            ],
            'field_8' => [
                'title' => 'Star rating',
                'field_type' => 'stars',
                'item_value' => 4,
                'search_query_not' => 1,
            ], // real value is 1,
            'field_1_2' => [
                'title' => 'Numeric value',
                'field_type' => 'textbox',
                'match_type' => 'number',
                'match_params' => array(
                    'number_min' => '1000',
                    'number_max' => '5000',
                ),
                'item_value' => 1004,
                'search_query' => ['from' => 1003, 'to' => 1005],
                'search_query_not' => ['from' => 1007, 'to' => 1010],
            ],
            'field_1_3' => [
                'title' => 'Positive integer',
                'field_type' => 'textbox',
                'match_type' => 'number',
                'match_params' => array(
                    'number_min' => '0',
                    'number_max' => '100',
                    'number_integer' => '1',
                ),
                'item_value' => 10,
                'search_query' => ['from' => 1, 'to' => 11],
                'search_query_not' => ['from' => 50, 'to' => 100],
            ],
            'field_1_4' => [
                'title' => 'Date field',
                'field_type' => 'textbox',
                'match_type' => 'date',
                'item_value' => '2016-01-22',
                'search_query' => ['from' => '2016-01-21', 'to' => '2016-01-23'],
                'search_query_not' => ['from' => '2015-01-21', 'to' => '2016-01-20'],
            ], // real value is 2016-01-08
            'field_1_5' => [
                'title' => 'Color field',
                'field_type' => 'textbox',
                'match_type' => 'color',
                'search_query' => 'rgb(161, 141, 102)',
                'search_query_not' => 'rgb(20, 20, 20)',
                'item_value' => 'rgb(161, 141, 101)',
            ],
            'select_partial_match' => [
                'title' => 'Select with partial match issue',
                'field_type' => 'select',
                'field_choices' => array(
                    'option_1' => 'Option 1 value',
                    'option_2' => 'Option 2 value',
                    'option_1_partial_match' => 'Option 1 partial match',
                ),
                'item_value' => 'option_1_partial_match',
                'search_query_not' => 'option_1',
            ],
        ];

        if (TestHelper::isAddOnActive('AL/LocationField'))
        {
            $fields += [
                'location' => [
                    'title' => 'Location',
                    'field_type' => 'location',
                    'field_format' => Constants::FIELD_FORMAT_API,
                    'item_value' => [
                        'country_code' => 'US',
                        'state' => 'Texas',
                        'state_id' => 4160,
                        'city' => 'Rio Hondo',
                        'city_id' => 9245,
                        'zip_code' => '',
                        'street_address' => '',
                    ],
                ]
            ];
        }

        return $fields;
    }

    public static function getRandomCategory()
    {
        $category = static::assertTestCategory();

        /** @var Entity[] $subCategories */
        $subCategories = static::getSubCategories($category);

        $randomId = array_rand($subCategories);

        return $subCategories[$randomId];
    }

    public static function getTestItemData($fieldOverride = array())
    {
        $fieldValues = array_map(function ($field)
        {
            return $field['item_value'];
        }, static::getFields());

        return array_merge($fieldValues, $fieldOverride);
    }

    public static function getTestItemDataForSearch($fieldOverride = array())
    {
        $data = self::getTestItemData($fieldOverride);

        if (TestHelper::isAddOnActive('AL/LocationField'))
        {
            $data['location'] = [
                'address' => $data['location']['state'] . ' ' . $data['location']['city'],
                'range' => 100,
                'unit' => 'km',
                'country_code' => $data['location']['country_code'],
            ];
        }

        return $data;
    }

    public static function getNegativeTestData()
    {
        $negativeData = array_map(function ($field)
        {
            if (isset($field['search_query_not']))
            {
                return $field['search_query_not'];
            }
            return false;
        }, static::getFields());

        $negativeData = array_filter($negativeData, function ($item)
        {
            return $item !== false;
        });

        return $negativeData;
    }
}
