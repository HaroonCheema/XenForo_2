<?php

namespace FS\YtVideoSlider\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class YtVideos extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\YtVideoSlider:Video')->with('Attachment')->order('video_id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'videoitems' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            'totalReturn' => count($finder->fetch()),
        ];

        return $this->view('FS\YtVideoSlider:Video\Index', 'fs_yt_video_index', $viewParams);
    }

    public function actionAdd()
    {
        $videoitem = $this->em()->create('FS\YtVideoSlider:Video');
        return $this->noteAddEdit($videoitem);
    }


    public function actionEdit(ParameterBag $params)
    {
        if ($params->video_id) {
            $videoitem = $this->assertRecordExists('FS\YtVideoSlider:Video', $params->video_id);
            return $this->noteAddEdit($videoitem);
        } else {
            return $this->noPermission();
        }
    }

    protected function noteAddEdit(\FS\YtVideoSlider\Entity\Video $videoitem)
    {
        $viewParams = [
            'videoitem' => $videoitem
        ];
        return $this->view('FS\YtVideoSlider:Video\Create', 'fs_yt_video_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {

        if ($params->video_id) {
            $dataEditAdd = $this->assertRecordExists('FS\YtVideoSlider:Video', $params->video_id);
        } else {
            $dataEditAdd = $this->em()->create('FS\YtVideoSlider:Video');

            if ($this->filter('type', 'bool')) {

                $video = $this->request->getFile('upload');

                if (!$video) {
                    throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
                }
            }
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        if ($this->filter('type', 'bool')) {
            $this->saveVideo($dataEditAdd);
        }

        return $this->redirect($this->buildLink('yt-videos'));
    }

    protected function dataSaveProcess(\FS\YtVideoSlider\Entity\Video $data)
    {
        $input = $this->filterInputs();

        $form = $this->formAction();

        if ($input['type'] == 0) {
            $storeurl = $input['url'];
            if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]*\/\S*\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $storeurl, $matches)) {
                $youtube_id = $matches[1];
                $input['thumbnail'] = "https://img.youtube.com/vi/$youtube_id/maxresdefault.jpg";
            }
        }

        if ($data->attachment_id) {
            /** @var \XF\Entity\Attachment $attachment */
            $attachment = $this->em()->find('XF:Attachment', $data->attachment_id);
            $attachment->delete(false);

            $input['attachment_id'] = 0;
        }

        $form->basicEntitySave($data, $input);

        return $form;
    }

    protected function saveVideo(\FS\YtVideoSlider\Entity\Video $data)
    {
        $currentAttachmentId = $data->attachment_id ?: 0;
        $newAttachmentId = 0;

        $video = $this->request->getFile('upload');

        if ($video) {

            $type = 'fs_yt_video_slider';

            $context = array('video_id' => '1');
            $hash = md5(microtime(true) . \XF::generateRandomString(8, true));
            $handler = $this->repository('XF:Attachment')->getAttachmentHandler($type);

            /** @var \XF\Attachment\Manipulator $manipulator */
            $class = \XF::extendClass('XF\Attachment\Manipulator');
            $manipulator = new $class($handler, $this->getAttachmentRepo(), $context, $hash);
            $attachment = $manipulator->insertAttachmentFromUpload($video, $error);
            $newAttachmentId = $attachment->data_id;
            if ($data->thumbnail) {
                $data->fastUpdate('thumbnail', '');
                $data->fastUpdate('url', '');
            }
            $data->fastUpdate('attachment_id', $newAttachmentId);
        }

        if ($currentAttachmentId && $newAttachmentId && ($currentAttachmentId != $newAttachmentId)) {
            /** @var \XF\Entity\Attachment $attachment */
            $attachment = $this->em()->find('XF:Attachment', $currentAttachmentId);
            $attachment->delete(false);
        }

        return true;
    }

    protected function filterInputs()
    {
        $input = $this->filter([
            'title' => 'str',
            'type' => 'bool',
        ]);

        if ($input['type'] == 0) {

            $input['url'] = $this->filter(
                'url',
                'str'
            );

            if (!$this->isValidYouTubeUrl($input['url'])) {
                throw $this->exception($this->error(\XF::phraseDeferred('The URL is not a valid YouTube link.')));
            }
        }

        return $input;
    }

    protected function isValidYouTubeUrl($url)
    {
        $parsedUrl = parse_url($url);

        $validHosts = ['www.youtube.com', 'youtube.com', 'youtu.be'];
        if (isset($parsedUrl['host']) && in_array($parsedUrl['host'], $validHosts)) {
            return true;
        }

        return false;
    }

    public function actionDelete(ParameterBag $params)
    {
        $videoitem = $this->assertRecordExists('FS\YtVideoSlider:Video', $params->video_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $videoitem,
            $this->buildlink('yt-videos/delete', $videoitem),
            $this->buildlink('yt-videos/edit', $videoitem),
            $this->buildlink('yt-videos'),
            $videoitem->title
        );
    }

    protected function getAttachmentRepo()
    {
        return $this->repository('XF:Attachment');
    }
}
