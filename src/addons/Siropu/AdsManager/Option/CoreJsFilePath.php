<?php

namespace Siropu\AdsManager\Option;

use XF\Option\AbstractOption;
use XF\Util\File;

class CoreJsFilePath extends AbstractOption
{
	public static function verifyOption(&$value, \XF\Entity\Option $option)
	{
          $prevValue = $option->getPreviousValue('option_value');

          if ($value && $value != $prevValue && strpos($value, 'http') === false)
          {
               File::copyFile('js/siropu/am/core.min.js', "js/{$value}");
          }

		return true;
	}
}
