<?php

namespace FS\EmbedZoomMeeting\XF\Admin\Controller;

use XF\Entity\OptionGroup;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Util\Arr;

class Option extends XFCP_Option
{

        public function actionZoomMeetingAuthSetup(ParameterBag $params)
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

                        $session->set('zoomCredentials', [
                                'client_id' => $input['client_id'],
                                'client_secret' => $input['client_secret'],

                        ]);
                        $session->save();

                        $zoom_client_id = $this->assertOptionExists("fs_zoom_client_id");

                        $zoom_client_id->option_value = $input['client_id'];

                        $zoom_client_id->save();

                        $zoom_client_secret = $this->assertOptionExists("fs_zoom_client_secret");

                        $zoom_client_secret->option_value = $input['client_secret'];

                        $zoom_client_secret->save();

                        $redirectUri = $this->buildLink('canonical:misc/zoom-meeting-oauth-setup');

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
