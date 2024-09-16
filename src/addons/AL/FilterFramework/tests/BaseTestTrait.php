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
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Finder;

trait BaseTestTrait
{
    /**
     * @return Entity
     */
    public static function assertTestCategory()
    {
        throw new \RuntimeException('The method should be overridden.');
    }

    public static function getSubCategories(Entity $category)
    {
        throw new \RuntimeException('The method should be overridden.');
    }

    public static function getRandomCategory()
    {
        $category = static::assertTestCategory();

        /** @var Entity[] $subCategories */
        $subCategories = array_merge([$category], static::getSubCategories($category));

        $randomId = array_rand($subCategories);

        return $subCategories[$randomId];
    }

    public function getCustomHandlers(array &$fieldCache, $countryCode = 'US')
    {
        return FilterFrameworkFixture::getCustomHandlers(
            $fieldCache,
            $this->_getFieldShortName(),
            $countryCode
        );
    }
}