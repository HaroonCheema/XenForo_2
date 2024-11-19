<?php

namespace FS\EmbedZoomMeeting\Entity;

use XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use function floatval,
    in_array;

class Meeting extends Entity
{

    public function getBreadcrumbs($includeSelf = true)
    {

        return [];
    }

    public function getMeetingUserCount()
    {

        $count = $this->finder('FS\EmbedZoomMeeting:Register')->where('meeting_id', $this->z_meeting_id)->fetch();


        return count($count);
    }

    public static function getStructure(Structure $structure)
    {

        $structure->table = 'fs_zoom_meeting';
        $structure->shortName = 'FS\EmbedZoomMeeting:Meeting';
        $structure->primaryKey = 'meeting_id';
        $structure->contentType = 'fs_zoom_meeting';
        $structure->columns = [
            'meeting_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT, 'required' => true, 'default' => \xf::visitor()->user_id],
            'topic' => ['type' => self::STR, 'maxLength' => 250],
            'start_time' => ['type' => self::UINT, 'required' => true],
            'end_time' => ['type' => self::UINT, 'required' => true],
            'duration' => ['type' => self::UINT, 'required' => true],
            'timezone' => ['type' => self::STR, 'default' => ''],
            'z_meeting_id' => ['type' => self::STR, 'default' => null],
            'z_start_time' => ['type' => self::STR, 'default' => null],
            'z_start_url' => ['type' => self::STR, 'default' => null],
            'z_join_url' => ['type' => self::STR, 'default' => null],
            'join_usergroup_ids' => [
                'type' => self::LIST_COMMA,
                'list' => ['type' => 'posint', 'sort' => SORT_NUMERIC],
                'default' => []
            ],
            'status' => ['type' => self::UINT, 'default' => 0],
            'created_date' => ['type' => self::UINT, 'default' => \xf::$time],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true,
                'api' => true
            ],
            'Registers' => [
                'entity' => 'FS\EmbedZoomMeeting:Register',
                'type' => self::TO_MANY,
                'conditions' => 'meeting_id',
            ],
        ];

        return $structure;
    }

    public function getMeetingEnd()
    {


        return $this->start_time + ($this->duration * 60);
    }

    public function getStartDate($format = "M d, Y")
    {

        $tz = new \DateTimeZone("UTC");
        $date = new \DateTime('@' . $this->start_time, $tz);
        return $date->format($format);
    }

    public function getStartTimeConvert()
    {


        $tz = new \DateTimeZone("UTC");

        $date = new \DateTime('@' . $this->start_time, $tz);

        return $date->format("H:i");
    }

    public function getStartTime($format = "g:i A")
    {


        $tz = new \DateTimeZone("UTC");

        $date = new \DateTime('@' . $this->start_time, $tz);

        return $date->format($format);
    }
}
