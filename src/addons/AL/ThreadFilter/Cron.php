<?php
/** 
* @package [AddonsLab] Thread Filter
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 3.9.2
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

use AL\ThreadFilter\Licensing\Engine\Xf2;

class Cron
{
    public static function hourlyCron()
    {
        Xf2::installDrivers();
        $licenseKey = App::getOptionProvider()->getOption('altf_license_key');
        $licenseValidationService = App::getLicenseValidationService('\AL\ThreadFilter\Licensing\Engine\Xf2');
        try {
            $licenseValidationService->licenseLocalReValidation(
                $licenseKey
            );
        } catch (\Exception $ex) {
            // failed to check the integrity or we are out of tries
            $licenseValidationService->disableAddon('AL/ThreadFilter', $ex->getMessage());
        }

        $cache = \XF::finder('AL\FilterFramework:SearchCache')->where('creation_date', '<', time() - 3600)->fetch();
        foreach ($cache AS $item) {
            try {
                $item->delete();
            } catch (\Exception $exception) {
                // can be lock timeout, just skip deleting the cache
            }
        }
    }
}