<?php

namespace FS\IframeVideoChanges\XB\VideoPages\Entity;

use XF\Mvc\Entity\Structure;

class Iframe extends XFCP_Iframe
{

  public static function getStructure(Structure $structure)
  {
    $structure = parent::getStructure($structure);

    // $structure->columns['for_days'] =  ['type' => self::UINT, 'default' => 1];

    $structure->columns['display_day'] = [
      'type' => self::LIST_COMMA,
      'default' => [],
      'list' => ['type' => 'int', 'unique' => true, 'sort' => SORT_NUMERIC]
    ];

    return $structure;
  }

  public function getDaysFrom(): string
  {
    $dayNames = [
      0 => \XF::phrase('Sunday'),
      1 => \XF::phrase('Monday'),
      2 => \XF::phrase('Tuesday'),
      3 => \XF::phrase('Wednesday'),
      4 => \XF::phrase('Thursday'),
      5 => \XF::phrase('Friday'),
      6 => \XF::phrase('Saturday'),
      7 => \XF::phrase('Unknown')
    ];

    $days = $this->display_day;

    if (!$days) {
      return (string)$dayNames[7];
    }

    $days = array_unique(array_map('intval', $days));
    sort($days, SORT_NUMERIC);

    if ($days === [7]) {
      return (string)$dayNames[7];
    }

    $days = array_diff($days, [7]);

    $labels = [];
    foreach ($days as $day) {
      if (isset($dayNames[$day])) {
        $labels[] = (string)$dayNames[$day];
      }
    }

    return implode(', ', $labels);
  }

  protected function _preSave()
  {
    $parent = parent::_preSave();

    return $parent;
  }
}
