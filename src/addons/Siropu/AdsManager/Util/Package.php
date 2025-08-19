<?php

namespace Siropu\AdsManager\Util;

class Package
{
     public static function sortAdsByPackageOrder($a, $b)
     {
          $order = $a->Package->ad_display_order;

          switch ($order)
          {
               default:
               case 'dateAsc':
               case 'dateDesc':
                    $f = 'create_date';
                    break;
               case 'orderAsc':
               case 'orderDesc':
                    $f = 'display_order';
                    break;
               case 'viewAsc':
               case 'viewDesc':
                    $f = 'view_count';
                    break;
               case 'clickAsc':
               case 'clickDesc':
                    $f = 'click_count';
                    break;
               case 'ctrAsc':
               case 'ctrDesc':
                    $f = 'ctr';
                    break;
          }

          if ($a->{$f} == $b->{$f})
          {
               return 0;
          }

          return strpos($order, 'Desc') ? (($a->{$f} > $b->{$f}) ? -1 : 1) : (($a->{$f} < $b->{$f}) ? -1 : 1);
     }
     public static function getRandomWeightedElement(array $priorityValues)
     {
          array_walk($priorityValues, function(&$value)
          {
               $value = max(1, $value);
          });

          $rand = mt_rand(1, max(1, array_sum($priorityValues)));

          foreach ($priorityValues as $key => $value)
          {
               $rand -= $value;

               if ($rand <= 0)
               {
                    return $key;
               }
          }
     }
}
