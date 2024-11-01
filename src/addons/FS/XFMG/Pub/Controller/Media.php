<?php

namespace FS\XFMG\Pub\Controller;

use XF\Mvc\ParameterBag;

class Media extends XFCP_Media
{

    public function actionSavingImage(ParameterBag $params)
    {

        if ($params->media_id) {
            $mediaItem = $this->assertViewableMediaItem($params->media_id);
        }

        if ($this->isPost()) {

            $mediaItem->Album->fastUpdate('media_id', $params->media_id);

            return $this->redirect($this->buildLink('media', $mediaItem));
        } else {
            $viewParams = [
                'mediaItem' => $mediaItem
            ];

            return $this->view('XFMG:Media\SavingImage', 'xfmg_set_image_confirm', $viewParams);
        }
    }

    public function actionUnsetImage(ParameterBag $params)
    {
        if ($params->media_id) {
            $mediaItem = $this->assertViewableMediaItem($params->media_id, ['Attachment']);
        }

        if ($this->isPost()) {

            $mediaItem->Album->fastUpdate('media_id', 0);

            return $this->redirect($this->buildLink('media', $mediaItem));
        } else {
            $viewParams = [
                'mediaItem' => $mediaItem
            ];

            return $this->view('XFMG:Media\UnsetImage', 'xfmg_unset_image_confirm', $viewParams);
        }
    }
}
