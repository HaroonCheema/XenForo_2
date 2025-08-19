<?php

namespace Siropu\AdsManager\Option;

use XF\Option\AbstractOption;
use XF\Util\File;

class BannerDirName extends AbstractOption
{
	public static function verifyOption(&$value, \XF\Entity\Option $option)
	{
          $prevValue = $option->getPreviousValue('option_value') ?: 'siropu/am/user';

          if ($value != $prevValue)
          {
               if (strpos($value, '/') !== false)
               {
                    $option->error('Do not use nested directories as banner directory name.', $option->option_id);
                    return false;
               }

               $newDir = "data/{$value}";
               $oldDir = "data/{$prevValue}";

               File::createDirectory($newDir);
               File::copyDirectory($oldDir, $newDir);
          }

		return true;
	}
}
