<?php

namespace FS\EmbedZoomMeeting\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;
use XF\PrintableException;
use function intval,
    is_array;

class Meeting extends Repository
{
    public function categoryMeeting($categoryId = null, $meeting)
    {
        $meetingFinder = $this->finder('FS\EmbedZoomMeeting:Meeting');

        if ($meeting) {

            $meetingFinder->where('meeting_id', '!=', $meeting->meeting_id);
        }

        $meetingFinder->order('start_time', 'DESC');

        return $meetingFinder;
    }
}
