<?php

namespace FS\IframeVideoChanges\XB\VideoPages\Entity;

use XF\Mvc\Entity\Structure;

class Iframe extends XFCP_Iframe
{

  public static function getStructure(Structure $structure)
  {
    $structure = parent::getStructure($structure);

    $structure->columns['for_days'] =  ['type' => self::UINT, 'default' => 1];

    return $structure;
  }

  public function getDaysFrom()
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

    $start = intval($this->display_day);
    $length = max(1, intval($this->for_days));

    if ($start === 7) {
      return (string)$dayNames[7];
    }

    if ($length === 1) {
      return (string)$dayNames[$start];
    }

    $end = ($start + $length - 1) % 7;

    return sprintf(
      "%s - %s",
      (string)$dayNames[$start],
      (string)$dayNames[$end]
    );
  }


  protected function _preSave()
  {
    $parent = parent::_preSave();

    if ($this->feature != 1) {
      return $parent;
    }

    $start = intval($this->display_day);
    $length = intval($this->for_days);
    $id = $this->iframe_id ?: 0;

    if ($start == 7) {
      return $parent;
    }

    $dayNames = [
      0 => 'Sunday',
      1 => 'Monday',
      2 => 'Tuesday',
      3 => 'Wednesday',
      4 => 'Thursday',
      5 => 'Friday',
      6 => 'Saturday',
      7 => 'Unknown'
    ];

    $days = [];
    for ($i = 0; $i < $length; $i++) {
      $days[] = ($start + $i) % 7;
    }

    $db = \XF::db();

    foreach ($days as $checkDay) {

      $conflict = $db->fetchRow("
            SELECT iframe_id
            FROM xf_iframe
            WHERE feature = 1
              AND iframe_id != ?
              AND (
                    (display_day <= ? AND (display_day + for_days - 1) >= ?)
                    OR
                    (display_day > (display_day + for_days - 1)
                        AND (? >= display_day OR ? <= ((display_day + for_days - 1) % 7))
                    )
                  )
            LIMIT 1
        ", [$id, $checkDay, $checkDay, $checkDay, $checkDay]);

      if ($conflict) {
        $dayName = $dayNames[$checkDay];
        $this->error("A featured video already exists for day: {$dayName}", "display_day");
        return;
      }
    }

    return $parent;
  }
}
