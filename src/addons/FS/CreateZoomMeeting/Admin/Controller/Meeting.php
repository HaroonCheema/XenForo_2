<?php

namespace FS\CreateZoomMeeting\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class Meeting extends AbstractController
{


    public function preDispatchController($action, ParameterBag $params)
    {

        $zoom_meeting_access_token = \xf::options()->zoom_meeting_access_token;
        $zoom_meeting_refresh_token = \xf::options()->zoom_meeting_refresh_token;

        if (!$zoom_meeting_access_token || !$zoom_meeting_refresh_token) {

            throw new \XF\PrintableException("Need To full Zoom Meeting Option Setting");
        }
    }
    public function actionIndex(ParameterBag $params)
    {


        $finder = $this->finder('FS\CreateZoomMeeting:Meeting');


        $page = $this->filterPage($params->page);
        $perPage = 15;
        $finder->limitByPage($page, $perPage);

        $viewpParams = [
            'page' => $page,
            'total' => $finder->total(),
            'perPage' => $perPage,
            'meetings' => $finder->order('created_date', 'DESC')->fetch(),

        ];

        return $this->view('FS\CreateZoomMeeting:Meeting', 'fs_zoom_meetings', $viewpParams);
    }

    public function meetingAddEdit($meeting)
    {

        $nodeTree = $this->getNodeTree();
        $viewParams = [
            'meeting' => $meeting,
            'nodeTree' => $nodeTree,
            'userGroups' => $this->getUserGroupRepo()->findUserGroupsForList()->fetch(),
        ];

        return $this->view('FS\CreateZoomMeeting:Meeting', 'fs_edit_zoom_meeting', $viewParams);
    }

    public function actionEdit(ParameterBag $params)
    {

        $meeting = $this->assertMeetingExists($params->meetingId);

        return $this->meetingAddEdit($meeting);
    }

    public function actionAdd()
    {

        $meeting = $this->em()->create('FS\CreateZoomMeeting:Meeting');

        return $this->meetingAddEdit($meeting);
    }

    protected function meetingSaveProcess(\FS\CreateZoomMeeting\Entity\Meeting $meeting)
    {

        $form = $this->formAction();

        $input = $this->filter([
            'topic' => 'str',
            'start_date' => 'str',
            'start_time' => 'str',
            'duration' => 'int',
            'thread_title' => 'str',
            'forum_id' => 'int',
            'alert_duration' => 'int',
            'join_usergroup_ids' => 'array',

        ]);


        $this->filterValidation();

        $startDate = $input['start_date'];
        $startTime = $input['start_time'];



        $input['description'] = $this->plugin('XF:Editor')->fromInput('description');

        if (!$input['description']) {

            throw new \XF\PrintableException('Description Must Required....!');
        }


        $meetingService = $this->service('FS\CreateZoomMeeting:Meeting');



        $input['start_time'] = $meetingService->meetingStartDateTime($startDate, $startTime);



        $topic = $input['topic'];

        $duration = $input['duration'];

        if ($input['start_time'] && $duration) {

            $input['end_time'] = $input['start_time'] + ($duration * 60);
        }

        $zoomStartTime = $meetingService->zoomMeetingTime($startDate, $startTime);


        if (!$meeting->z_meeting_id) {

            list($z_meetingId, $z_start_time, $z_start_url, $z_join_url) = $meetingService->createZoomMeeting($topic, $zoomStartTime, $duration, "UTC", \xf::options()->zoom_meeting_access_token);

            $input['z_meeting_id'] = $z_meetingId;
            $input['z_start_time'] = $z_start_time;
            $input['z_start_url'] = $z_start_url;
            $input['z_join_url'] = $z_join_url;
        }



        if ($meeting->z_meeting_id && ($meeting->start_time != $input['start_time'] ||  $meeting->duration != $input['duration'])) {

            list($z_meetingId, $z_start_time, $z_start_url, $z_join_url) = $meetingService->updateZoomMeeting($meeting->z_meeting_id, $topic, $zoomStartTime, $duration, "UTC", \xf::options()->zoom_meeting_access_token);

            $input['z_meeting_id'] = $z_meetingId;
            $input['z_start_time'] = $z_start_time;
            $input['z_start_url'] = $z_start_url;
            $input['z_join_url'] = $z_join_url;
        }



        if (!$meeting->thread_id) {

            if ($input['forum_id']) {

                $threadTitle = $input['thread_title'] ?  $input['thread_title'] : $topic;

                $thread = $meetingService->createDisuccion($input['forum_id'], $threadTitle, $input['description']);

                if ($thread) {

                    $input['thread_id'] = $thread->thread_id;
                }
            }
        }

        if ($meeting->thread_id) {

            $threadTitle = $input['thread_title'] ?  $input['thread_title'] : $topic;

            $thread = $meetingService->UpdateDisuccion($input['forum_id'], $threadTitle, $input['description'], $meeting->Thread);

            if ($thread) {

                $input['thread_id'] = $thread->thread_id;
            }
        }


        $this->beforeSave($input);

        $form->basicEntitySave($meeting, $input);

        return $form;
    }

    public function filterValidation()
    {

        $input = $this->filter([
            'topic' => 'str',
            'start_date' => 'str',
            'start_time' => 'str',
            'duration' => 'int',
            'thread_title' => 'str',
            'forum_id' => 'int',
            'join_usergroup_ids' => 'array',
            'alert_duration' => 'int'

        ]);


        if (!$input['topic']) {

            throw new \XF\PrintableException("Topic must be Required....");
        }

        if (!$input['start_date']) {

            throw new \XF\PrintableException("Start Date must be Required....");
        }

        if (!$input['start_time']) {

            throw new \XF\PrintableException("Start Time must be Required....");
        }

        if (!$input['duration']) {

            throw new \XF\PrintableException("Duration must be Required....");
        }

        if (!$input['forum_id']) {

            throw new \XF\PrintableException("Forum must be Required....");
        }
    }

    public function beforeSave(&$input)
    {

        unset($input['thread_title']);
        unset($input['start_date']);
    }



    public function actionSave(ParameterBag $params)
    {


        if (!\xf::options()->zoom_meeting_access_token) {
        }

        $this->assertPostOnly();

        if ($params->meetingId) {
            $meeting = $this->assertMeetingExists($params->meetingId);
        } else {
            $meeting = $this->em()->create('FS\CreateZoomMeeting:Meeting');
        }


        $this->meetingSaveProcess($meeting)->run();

        return $this->redirect($this->buildLink('meeting'));
    }

    public function actionDelete(ParameterBag $params)
    {

        $meeting = $this->assertMeetingExists($params->meetingId);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');

        if ($this->isPost()) {


            $meetingService = $this->service('FS\CreateZoomMeeting:Meeting');

            $meetingService->deleteMeeting($meeting->z_meeting_id, \xf::options()->zoom_meeting_access_token);
        }

        return $plugin->actionDelete(
            $meeting,
            $this->buildLink('meeting/delete', $meeting),
            $this->buildLink('meetinge/edit', $meeting),
            $this->buildLink('meeting'),
            $meeting->topic
        );
    }

    protected function assertMeetingExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('FS\CreateZoomMeeting:Meeting', $id, $with, $phraseKey);
    }

    protected function getNodeTree()
    {

        $nodeRepo = \XF::repository('XF:Node');

        $nodeTree = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());

        // only list nodes that are forums or contain forums
        $nodeTree = $nodeTree->filter(null, function ($id, $node, $depth, $children, $tree) {
            return ($children || $node->node_type_id == 'Forum');
        });

        return $nodeTree;
    }



    protected function getUserGroupRepo()
    {
        return $this->repository('XF:UserGroup');
    }
}
