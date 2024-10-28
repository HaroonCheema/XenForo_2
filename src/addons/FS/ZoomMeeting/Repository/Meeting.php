<?php

namespace FS\ZoomMeeting\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;
use XF\PrintableException;
use function intval,
             is_array;

class Meeting extends Repository {

    public function categoryMeeting($categoryId = null, $meeting) {
        
        $meetingFinder = $this->finder('FS\ZoomMeeting:Meeting');

        if ($meeting) {

            $meetingFinder->where('meeting_id', '!=', $meeting->meeting_id);
        }

        if ($categoryId) {

            $meetingFinder->where('category_id', $categoryId);
        }
        $meetingFinder->order('start_time', 'DESC');

        return $meetingFinder;
    }
}
