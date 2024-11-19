<?php

namespace FS\EmbedZoomMeeting\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class Meeting extends AbstractController
{
    public function preDispatchController($action, ParameterBag $params)
    {
        $zoom_access_token = \xf::options()->fs_zoom_access_token;
        $zoom_refresh_token = \xf::options()->fs_zoom_refresh_token;

        if (!$zoom_access_token || !$zoom_refresh_token) {

            throw new \XF\PrintableException("Need To full Zoom Meeting Option Setting");
        }
    }

    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\EmbedZoomMeeting:Meeting');

        $viewpParams = [
            'meeting' => $finder->order('created_date', 'DESC')->fetchOne(),
        ];

        return $this->view('FS\EmbedZoomMeeting:Meeting', 'fs_zoom_meeting', $viewpParams);
    }

    public function meetingAddEdit($meeting)
    {
        $nodeTree = $this->getNodeTree();
        $viewParams = [
            'meeting' => $meeting,
            'nodeTree' => $nodeTree,
            'userGroups' => $this->getUserGroupRepo()->findUserGroupsForList()->fetch(),
        ];

        return $this->view('FS\EmbedZoomMeeting:Meeting', 'fs_edit_zoom_meeting', $viewParams);
    }

    public function actionEdit(ParameterBag $params)
    {
        $meeting = $this->assertMeetingExists($params->meeting_id);

        return $this->meetingAddEdit($meeting);
    }

    public function actionAdd()
    {
        if ($this->finder('FS\EmbedZoomMeeting:Meeting')->total()) {
            return $this->noPermission();
        }

        $meeting = $this->em()->create('FS\EmbedZoomMeeting:Meeting');

        return $this->meetingAddEdit($meeting);
    }

    protected function meetingSaveProcess(\FS\EmbedZoomMeeting\Entity\Meeting $meeting)
    {

        $form = $this->formAction();

        $input = $this->filter([
            'topic' => 'str',
            'start_date' => 'str',
            'start_time' => 'str',
            'duration' => 'int',
            'join_usergroup_ids' => 'array',

        ]);

        $this->filterValidation();

        $startDate = $input['start_date'];
        $startTime = $input['start_time'];

        $meetingService = $this->service('FS\EmbedZoomMeeting:Meeting');

        $input['start_time'] = $meetingService->meetingStartDateTime($startDate, $startTime);

        $topic = $input['topic'];

        $duration = $input['duration'];

        if ($input['start_time'] && $duration) {

            $input['end_time'] = $input['start_time'] + ($duration * 60);
        }

        $zoomStartTime = $meetingService->zoomMeetingTime($startDate, $startTime);

        if (!$meeting->z_meeting_id) {

            list($z_meetingId, $z_start_time, $z_start_url, $z_join_url) = $meetingService->createZoomMeeting($topic, $zoomStartTime, $duration, "UTC", \xf::options()->fs_zoom_access_token);

            $input['z_meeting_id'] = $z_meetingId;
            $input['z_start_time'] = $z_start_time;
            $input['z_start_url'] = $z_start_url;
            $input['z_join_url'] = $z_join_url;
        }

        if ($meeting->z_meeting_id && ($meeting->start_time != $input['start_time'] ||  $meeting->duration != $input['duration'])) {

            list($z_meetingId, $z_start_time, $z_start_url, $z_join_url) = $meetingService->updateZoomMeeting($meeting->z_meeting_id, $topic, $zoomStartTime, $duration, "UTC", \xf::options()->fs_zoom_access_token);

            $input['z_meeting_id'] = $z_meetingId;
            $input['z_start_time'] = $z_start_time;
            $input['z_start_url'] = $z_start_url;
            $input['z_join_url'] = $z_join_url;
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
            'join_usergroup_ids' => 'array',

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
    }

    public function beforeSave(&$input)
    {

        unset($input['start_date']);
    }

    public function actionSave(ParameterBag $params)
    {

        if (!\xf::options()->fs_zoom_access_token) {
        }

        $this->assertPostOnly();

        if ($params->meeting_id) {
            $meeting = $this->assertMeetingExists($params->meeting_id);
        } else {
            $meeting = $this->em()->create('FS\EmbedZoomMeeting:Meeting');
        }

        $this->meetingSaveProcess($meeting)->run();

        return $this->redirect($this->buildLink('zoom-meeting'));
    }

    public function actionDelete(ParameterBag $params)
    {

        $meeting = $this->assertMeetingExists($params->meeting_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');

        if ($this->isPost()) {

            $meetingService = $this->service('FS\EmbedZoomMeeting:Meeting');

            list($id, $starttime, $joinUrl, $startUrl) = $meetingService->getMeeting($meeting->z_meeting_id, \xf::options()->fs_zoom_access_token);

            if ($id) {

                $meetingService->deleteMeeting($meeting->z_meeting_id, \xf::options()->fs_zoom_access_token);
            }
        }

        return $plugin->actionDelete(
            $meeting,
            $this->buildLink('zoom-meeting/delete', $meeting),
            $this->buildLink('zoom-meeting/edit', $meeting),
            $this->buildLink('zoom-meeting'),
            $meeting->topic
        );
    }

    protected function assertMeetingExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('FS\EmbedZoomMeeting:Meeting', $id, $with, $phraseKey);
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
