<?php

namespace FS\CreateZoomMeeting\XF\Admin\Controller;

use XF\Entity\OptionGroup;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Util\Arr;

class Option extends XFCP_Option
{
        public function actionzoomMeetingAuthSetup(ParameterBag $params)
        {
                $option = $this->assertOptionExists($params->option_id);

                if ($this->isPost()) {
                        $input = $this->filter([
                                'client_id' => 'str',
                                'client_secret' => 'str',
                        ]);

                        if (!$input['client_id'] || !$input['client_secret']) {

                                throw $this->exception("Client Id and Client Secret must required to further porcess.");
                        }

                        $session = \XF::app()['session.public'];

                        $session->set('fsZoomCredentials', [
                                'client_id' => $input['client_id'],
                                'client_secret' => $input['client_secret'],

                        ]);
                        $session->save();

                        $zoom_meeting_client_id = $this->assertOptionExists("zoom_meeting_client_id");

                        $zoom_meeting_client_id->option_value = $input['client_id'];

                        $zoom_meeting_client_id->save();

                        $zoom_meeting_client_secret = $this->assertOptionExists("zoom_meeting_client_secret");

                        $zoom_meeting_client_secret->option_value = $input['client_secret'];

                        $zoom_meeting_client_secret->save();

                        // $redirectUri="https://99dd-2400-adc7-1123-3200-d9fb-99f5-217b-ac8e.ngrok-free.app/xen226/admin.php?misc/zoom-oauth-setup";
                        $redirectUri = "http://localhost/xenforo/admin.php?misc/zoom-meeting-oauth-setup";

                        $url = "https://zoom.us/oauth/authorize?response_type=code&client_id=" . $input['client_id'] . "&redirect_uri=" . $redirectUri;

                        header("Location: $url");
                        exit;
                }

                $viewParams = [
                        'option' => $option,
                        'redirectUri' => $this->buildLink('canonical:misc/zoom-meeting-oauth-setup')
                ];


                return $this->view('XF:Option\ZoomAuthSetupt', 'fs_option_zoom_transport_auth', $viewParams);
        }
}
