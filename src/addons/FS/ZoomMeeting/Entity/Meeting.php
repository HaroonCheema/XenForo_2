<?php

namespace FS\ZoomMeeting\Entity;

use XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use function floatval,
             in_array;

class Meeting extends Entity {

    public function getBreadcrumbs($includeSelf = true) {
        $breadcrumbs = $this->Category ? $this->Category->getBreadcrumbs() : [];
        if ($includeSelf) {
            $breadcrumbs[] = [
                'href' => $this->app()->router()->buildLink('meetings', $this),
                'value' => $this->topic
            ];
        }

        return $breadcrumbs;
    }

    public function _postSave() {

        $category = $this->Category;

        $meetings = $this->finder('FS\ZoomMeeting:Meeting')->where('category_id', $category->category_id)->fetch();

        if (count($meetings)) {


            $category->fastUpdate('meeting_count', count($meetings));
        }

        $thread = $this->Thread;

        if ($thread) {

            $thread->fastUpdate('meeting_id', $this->meeting_id);
        }
    }
    
    public function getMeetingUserCount(){
        
       
     $count=$this->finder('FS\ZoomMeeting:Register')->where('left_date',0)->where('meeting_id',$this->z_meeting_id)->fetch();
     
    
     return count($count);
        
    }

//    public function isJoined() {
//        return isset($this->Join[\XF::visitor()->user_id]);
//    }

    public static function getStructure(Structure $structure) {

        $structure->table = 'zoom_meetings';
        $structure->shortName = 'FS\ZoomMeeting:Meeting';
        $structure->primaryKey = 'meeting_id';
        $structure->contentType = 'zoom_meeting';
        $structure->columns = [
            'meeting_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'category_id' => ['type' => self::UINT, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true, 'default' => \xf::visitor()->user_id],
            'topic' => ['type' => self::STR, 'maxLength' => 250],
            'description' => ['type' => self::STR, 'default' => null],
            'start_time' => ['type' => self::UINT, 'required' => true],
            'end_time' => ['type' => self::UINT, 'required' => true],
            'duration' => ['type' => self::UINT, 'required' => true],
            'timezone' => ['type' => self::STR, 'default' => ''],
            'z_meeting_id' => ['type' => self::STR, 'default' => null],
            'z_start_time' => ['type' => self::STR, 'default' => null],
            'z_start_url' => ['type' => self::STR, 'default' => null],
            'z_join_url' => ['type' => self::STR, 'default' => null],
            'forum_id' => ['type' => self::UINT],
            'thread_id' => ['type' => self::UINT],
            'join_usergroup_ids' => [
                'type' => self::LIST_COMMA,
                'list' => ['type' => 'posint', 'sort' => SORT_NUMERIC], 'default' => []
            ],
            'alert_duration' => ['type' => self::UINT, 'default' => 0],
            'is_alerted' => ['type' => self::UINT, 'default' => 0],
            'created_date' => ['type' => self::UINT, 'default' => \xf::$time],
        ];

        $structure->relations = [
            'Category' => [
                'entity' => 'FS\ZoomMeeting:Category',
                'type' => self::TO_ONE,
                'conditions' => 'category_id',
                'primary' => true,
                'api' => true
            ],
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true,
                'api' => true
            ],
            'Forum' => [
                'entity' => 'XF:Forum',
                'type' => self::TO_ONE,
                'conditions' => 'forum_id',
                'primary' => true,
                'api' => true
            ],
            'Thread' => [
                'entity' => 'XF:Thread',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary' => true,
                'api' => true
            ],
            'Join' => [
                'entity' => 'FS\ZoomMeeting:Register',
                'type' => self::TO_MANY,
                'conditions' => 'meeting_id',
                'key' => 'user_id'
            ],
            'Registers' => [
                'entity' => 'FS\ZoomMeeting:Register',
                'type' => self::TO_MANY,
                'conditions' => 'meeting_id',
            ],
        ];

        return $structure;
    }

    public function getMeetingEnd() {


        return $this->start_time + ($this->duration * 60);
    }

    public function getStartDate($format = "M d, Y") {

        $tz = new \DateTimeZone("UTC");
        $date = new \DateTime('@' . $this->start_time, $tz);
        return $date->format($format);
    }

    public function getStartTimeConvert() {


        $tz = new \DateTimeZone("UTC");

        $date = new \DateTime('@' . $this->start_time, $tz);

        return $date->format("H:i");
    }

    public function getStartTime($format = "g:i A") {


        $tz = new \DateTimeZone("UTC");

        $date = new \DateTime('@' . $this->start_time, $tz);

        return $date->format($format);
    }
}