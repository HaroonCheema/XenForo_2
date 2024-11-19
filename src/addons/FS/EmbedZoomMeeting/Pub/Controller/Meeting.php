<?php

namespace FS\EmbedZoomMeeting\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class Meeting extends AbstractController
{

    public function preDispatchController($action, ParameterBag $params)
    {
        $visitor = \xf::visitor();

        if (!$visitor->canViewMeeting()) {
            throw $this->exception($this->noPermission());
        }
    }

    public function actionIndex(ParameterBag $params)
    {

        $finder = $this->finder('FS\EmbedZoomMeeting:Meeting')->fetchOne();

        $viewParams = [
            'meeting' => $finder,
            'total' => $finder ? 1 : '',
        ];

        return $this->view('FS\Meeting:Meeting', 'fs_zoom_meeting', $viewParams);
    }

    protected function assertMeetingExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('FS\EmbedZoomMeeting:Meeting', $id, $with, $phraseKey);
    }

    public function actionStartMeeting(ParameterBag $params)
    {

        $meeting = $this->assertMeetingExists($params->meeting_id);

        $visitor = \xf::visitor();

        if ($meeting->user_id != $visitor->user_id) {

            throw $this->exception($this->noPermission());
        }

        if ($meeting->status == 1) {

            throw new \XF\PrintableException("Meeting is already in progress...!");
        }

        $meetingSdkService = $this->service('FS\EmbedZoomMeeting:MeetingSdk');

        $meetingService = $this->service('FS\EmbedZoomMeeting:Meeting');

        list($id, $starttime, $joinUrl, $startUrl) = $meetingService->getMeeting($meeting->z_meeting_id, \xf::options()->fs_zoom_access_token);

        if (!$id) {

            throw new \XF\PrintableException(\xf::phrase('fs_need_to_validate_you_have_meeting_on_zoom_portal'));
        }

        $query = parse_url($meeting->z_join_url, PHP_URL_QUERY);
        parse_str($query, $params);

        $meetingPassWord = $params['pwd'];

        $sdkKey = \xf::options()->fs_zoom_client_id;
        $sdkSecret = \xf::options()->fs_zoom_client_secret;
        $signature = $meetingSdkService->generateSignature($sdkKey, $sdkSecret, $meeting->z_meeting_id, 1);

        $viewParams = [
            'sdkKey' => $sdkKey,
            'meetingNumber' => $meeting->z_meeting_id,
            'role' => 1,
            'username' => $visitor->username,
            'meeting' => $meeting,
            'email' => $visitor->email ?: "",
            'passWord' => $meetingPassWord,
            'signature' => $signature,
            'redirectUrl' => $this->buildLink('canonical:zoom-meeting'),
        ];

        $meeting->fastUpdate('start_time', \xf::$time);

        return $this->view('FS\EmbedZoomMeeting:Meeting', 'fs_host_meeting_start', $viewParams);
    }

    public function actionjoinMeeting(ParameterBag $params)
    {

        $meeting = $this->assertMeetingExists($params->meeting_id);

        $visitor = \xf::visitor();

        if ($meeting->status != 1) {

            throw new \XF\PrintableException(\xf::phrase('fs_need_to_wait_wait_for_start_meeting_by_host'));
        }

        if ($meeting->user_id == $visitor->user_id) {

            throw $this->exception($this->noPermission());
        }

        if (!$visitor->isMemberOf($meeting->join_usergroup_ids)) {

            throw $this->exception($this->noPermission());
        }

        if (!$visitor->user_id && !$this->isPost()) {

            $viewParams = [
                'meeting' => $meeting,
            ];
            return $this->view('', 'fs_zoom_meeting_guest_joiners', $viewParams);
        }

        if (!$visitor->user_id && $this->isPost()) {

            $guestUsername = $this->filter('guest_username', 'str');

            if (!$guestUsername) {

                throw new \XF\PrintableException(\xf::phrase('fs_unique_username_must_required'));
            }

            $alreadyUsername = $this->finder('FS\EmbedZoomMeeting:Register')->where('username', $guestUsername)->where('meeting_id', $meeting->z_meeting_id)->fetchOne();

            $usernameNormal = $this->finder('XF:User')->where('username', $guestUsername)->fetchOne();

            if ($alreadyUsername || $usernameNormal) {

                throw new \XF\PrintableException(\xf::phrase('fs_unique_username_must_required'));
            }
        }

        $query = parse_url($meeting->z_join_url, PHP_URL_QUERY);
        parse_str($query, $params);

        $meetingPassWord = $params['pwd'];

        $meetingSdkService = $this->service('FS\EmbedZoomMeeting:MeetingSdk');

        $sdkKey = \xf::options()->fs_zoom_client_id;
        $sdkSecret = \xf::options()->fs_zoom_client_secret;
        $signature = $meetingSdkService->generateSignature($sdkKey, $sdkSecret, $meeting->z_meeting_id, 0);

        $viewParams = [
            'sdkKey' => $sdkKey,
            'meetingNumber' => $meeting->z_meeting_id,
            'role' => 0,
            'username' => $visitor->user_id ? $visitor->username : $guestUsername,
            'meeting' => $meeting,
            'email' => $visitor->email ?: "",
            'passWord' => $meetingPassWord,
            'signature' => $signature,
            'redirectUrl' => $this->buildLink('canonical:zoom-meeting'),
        ];

        return $this->view('FS\EmbedZoomMeeting:Meeting', 'fs_join_meeting_start', $viewParams);
    }
}
