<?php

namespace Siropu\AdsManager\Util;

class Arr
{
     public static function filterByKey(array $arr, $key)
     {
          return array_filter($arr, function($k) use ($key) { return $k != $key; }, ARRAY_FILTER_USE_KEY);
     }
     public static function filterEmpty(array $arr)
     {
          return array_filter($arr, function($val) { return empty($val); });
     }
     public static function filterNotEmpty(array $arr)
     {
          return array_filter($arr, function($val) { return !empty($val); });
     }
     public static function mapPregQuote(array $arr, $delimiter = '/')
     {
          return array_map(function($val) use ($delimiter) { return preg_quote($val, $delimiter); }, $arr);
     }
     public static function getItemArray($items, $strToLower = false, $delimiter = ',')
     {
          if (empty($items))
          {
               return [];
          }

          if ($strToLower)
          {
               $items = utf8_strtolower($items);
          }

          return array_filter(array_map('trim', explode($delimiter, $items)));
     }
     public static function getItemsForRegex($items, $strToLower = false, $delimiter = "\n")
     {
          $itemArray = self::getItemArray($items, $strToLower, $delimiter);

          usort($itemArray, function($a, $b)
          {
               return strlen($b) - strlen($a);
          });

          return implode('|', self::mapPregQuote($itemArray));
     }
}
