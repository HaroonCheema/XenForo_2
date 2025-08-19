<?php

namespace Siropu\AdsManager\Option;

use XF\Option\AbstractOption;
use XF\Util\File;

class AdsTxt extends AbstractOption
{
     public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
	{
          return self::getTemplate('admin:siropu_ads_manager_option_template_adsTxt', $option, $htmlParams);
	}
     public static function verifyOption(&$value, \XF\Entity\Option $option)
	{
          $adsTxt = \XF::getRootDirectory() . '/ads.txt';

          if ($value)
          {
               $written = File::writeFile($adsTxt, $value, false);

               if (!$written)
               {
                    $option->error('Could not write ads.txt file.', $option->option_id);
                    return false;
               }
          }
          else if (file_exists($adsTxt))
          {
               @unlink($adsTxt);
          }

		return true;
	}
}
