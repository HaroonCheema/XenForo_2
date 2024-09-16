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


use AL\LocationField\Entity\City;
use AL\TestFramework\TestHelper;
use XF\Entity\AbstractField;
use XF\Mvc\Entity\Finder;

class FilterFrameworkFixture
{
    public static function getCustomHandlers(
        array &$fieldCache,
        $shortName,
        $countryCode = 'US'
    )
    {
        if (!TestHelper::isAddOnActive('AL/LocationField'))
        {
            $fieldCache = array_filter($fieldCache, function ($fieldId) use ($shortName)
            {
                /** @var AbstractField $field */
                $field = \XF::finder($shortName)->whereId($fieldId)->fetchOne();

                return $field && $field->field_type !== 'location';

            });

            return [];
        }
        /** @var City[] $cities */
        static $cities = null;
        if ($cities === null)
        {
            $cities = \XF::finder('AL\LocationField:City')
                ->with('Area')
                ->where('country_code', $countryCode)
                ->order(Finder::ORDER_RANDOM)->fetch(100)
                ->toArray();
        }

        $customHandlers = [];

        foreach ($fieldCache as $field_id)
        {
            /** @var AbstractField $field */
            $field = \XF::finder($shortName)->whereId($field_id)->fetchOne();

            if ($field->field_type === 'location')
            {
                $customHandlers[$field->field_id] = static function () use ($cities, $countryCode)
                {
                    $city = $cities[array_rand($cities)];
                    $areaId = $city->area_id;
                    $cityId = $city->city_id;
                    $city_name = $city->city_name;
                    $area_name = $city->Area->area_name;
                    return [
                        'country_code' => $countryCode,
                        'city_id' => $cityId,
                        'state_id' => $areaId,
                        'state' => $area_name,
                        'city' => $city_name,
                        'google_api_address' => "$city_name, $area_name $countryCode",
                    ];
                };
            }
        }

        return $customHandlers;
    }
}