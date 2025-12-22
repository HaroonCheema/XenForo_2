<?php

namespace XenBulletins\VideoPages\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XenBulletins\VideoPages\Entity;
use XF\Mvc\ParameterBag;

//controller
class AddVideo extends AbstractController {

    public function actionIndex() {

        $sites = $this->Finder('XenBulletins\VideoPages:AddVideo')->order('video_link');
        $sites = $sites->fetch();
        $viewParams = [
            'data' => $sites
        ];
        return $this->view('XenBulletins\VideoPages:AddVideo', 'brand', $viewParams);
    }

    public function actionAdd() {
        $fnc = $this->em()->create('XenBulletins\VideoPages:AddVideo');
        return $this->view('XenBulletins\VideoPages:AddVideo', 'brand_addvideo');
        return $this->functionAddEdit($site);
    }

    public function actionSave(ParameterBag $params) {
        $this->assertPostOnly();

        if ($params->video_id) {
            $video = $this->assertFunctionExists($params->video_id);
            $this->videoSaveProcess($video)->run();
        } else {
            $video = $this->em()->create('XenBulletins\VideoPages:AddVideo');
            $this->videoSaveProcess($video)->run();
            $latest_id = \XF::db()->query('select video_id from xf_videopages order by video_id desc limit 1')->fetch();

            // $video->username = \XF::visitor()->username;
        }
        $value_intro = $video->video_intro;
        $value_des = $video->video_desc;
        if ($video->intro_ph_id or $video->desc_ph_id) {
            $intro = $this->assertPhraseExists($video->intro_ph_id);
            $desc = $this->assertPhraseExists($video->desc_ph_id);
            
            
            $intro->phrase_text = $value_intro;
            $desc->phrase_text = $value_des;
            
            
            $intro->save();
            $desc->save();

//            $video->intro_ph_id = $intro->phrase_id;
//            $video->desc_ph_id = $desc->phrase_id;
//            $video->video_intro = $value_intro;
//            $video->video_desc = $value_des;
//            $video->save();
        } else {
            $intro_title = $latest_id['video_id'] . 'intro';
            $disc_title = $latest_id['video_id'] . 'des';
            $phrase_intro = $this->em()->create('XF:Phrase');
            $this->phraseSaveProcess($phrase_intro, $intro_title, $value_intro)->run();
            $phrase_desc = $this->em()->create('XF:Phrase');
            $this->phraseSaveProcess($phrase_desc, $disc_title, $value_des)->run();
            $intro_title = $latest_id['video_id'] . 'intro';
            $disc_title = $latest_id['video_id'] . 'des';
            $db = \XF::db();
            $db->update('xf_videopages', ['intro_ph_id' => $phrase_intro->phrase_id, 'desc_ph_id' => $phrase_desc->phrase_id], 'video_id  = ?', $latest_id['video_id']);
            $video->video_intro = $intro_title;
            $video->video_desc = $disc_title;

            $video->save();
        }
        if ($this->isPost()) {
            $uploads['video_logo'] = $this->request->getFile('video_logo', false, false);
            $uploads['video_sideimg'] = $this->request->getFile('video_sideimg', false, false);
            $uploads['video_img'] = $this->request->getFile('video_img', false, false);

            if ($uploads['video_logo']or $uploads['video_sideimg']or $uploads['video_img']) {
                $i = 0;
                $uploadService = $this->service('XenBulletins\VideoPages:Upload', $video);

                while ($i < 3) {


                    if ($i == 0) {
                        $upload = $uploads['video_logo'];
                        $type = 'video_logo';
                    } else if ($i == 1) {
                        $upload = $uploads['video_sideimg'];
                        $type = 'video_sideimg';
                    } else if ($i == 2) {
                        $upload = $uploads['video_img'];
                        $type = 'video_img';
                    }

                    if ($upload) {
                        if (!$uploadService->setImageFromUpload($upload)) {
                            return $this->error($uploadService->getError());
                        }
                        if (!$uploadService->updateBrandImage($upload, $type)) {
                            return $this->error(\XF::phrase('new_image_could_not_be_processed'));
                        }
                    }
                    $i++;
                }
            }
        }

        return $this->redirect($this->buildLink('brand'));
    }

    protected function assertPhraseExists($id, $with = null, $phraseKey = null) {
        return $this->assertRecordExists('XF:Phrase', $id, $with, $phraseKey);
    }

    protected function phraseSaveProcess(\XF\Entity\Phrase $phrase, $title, $value) {
        $form = $this->formAction();

        $input = ['language_id' => 0, 'title' => $title, 'phrase_text' => $value];

        $form->basicEntitySave($phrase, $input);
        return $form;
    }

    public function videoSaveProcess(\XenBulletins\VideoPages\Entity\AddVideo $video) {
        $form = $this->formAction();
        $input = $this->filter([
            'video_link' => 'STR',
            'video_feature' => 'STR',
            'video_logo' => 'STR',
            'video_intro' => 'STR',
            'video_desc' => 'STR',
            'video_sideimg' => 'STR',
            'video_img' => 'STR'
        ]);







        $bbCodeMediaSiteRepo = $this->repository('XF:BbCodeMediaSite');
        $sites = $bbCodeMediaSiteRepo->findActiveMediaSites()->fetch();



        $allowed = ['youtube', 'vimeo', 'facebook'];

        foreach ($sites as $key => $site) {
            if (!in_array($key, $allowed)) {
                $sites->offsetUnset($key);
            }
        }



        $match = $bbCodeMediaSiteRepo->urlMatchesMediaSiteList($input['video_link'], $sites);


        $embedDataHandler = $this->createEmbedDataHandler($match['media_site_id']);
        $thumbnailGenerator = $this->service('XenBulletins\VideoPages:Media\ThumbnailGenerator');
        $tempFile = $embedDataHandler->getTempThumbnailPath($input['video_link'], $match['media_site_id'], $match['media_id']);

        $abstractedThumbnailPath = $this->getAbstractedTempThumbnailPathProof($match);

        $thumbnailGenerator->getTempThumbnailFromImage($tempFile, $abstractedThumbnailPath);

        $thumbnail = $match['media_id'] . "-" . $match['media_site_id'] . ".jpg";









        if (preg_match('/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/', $input['video_link'])) {
            $link = $input['video_link'];

            $video_id = explode("?v=", $link);
            // For videos like http://www.youtube.com/watch?v=...
            if (empty($video_id[1]))
                $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..
//      if(empty($video_id[1]))
//            $video_id = explode("embed/", $link);
            $video_id = explode("&", $video_id[1]); // Deleting any other params
            $video_id = $video_id[0];

            // $thumbnail = "http://img.youtube.com/vi/" . $video_id . "/maxresdefault.jpg";
            $videoLink = "http://www.youtube.com/watch?v=" . $video_id;
            $feature = "https://www.youtube.com/embed/" . $video_id;
        }
        else {
            $link = $input['video_link'];
            $video_id = explode("com/", $link); // For videos like http://www.youtube.com/watch?v=...
            if (empty($video_id[1]))
                $video_id = explode("/video/", $link); // For videos like http://www.youtube.com/watch/v/..

            $video_id = explode("&", $video_id[1]); // Deleting any other params
            $video_id = $video_id[0];
            // $thumbnail = $this->getVimeoVideoThumbnailByVideoId($video_id, 'medium');
            $videoLink = 'https://player.vimeo.com/' . $video_id;
            $feature = 'https://player.vimeo.com/video/' . $video_id;
        }




        $input['video_link'] = $videoLink;
        $video->video_feature = $input['video_feature'];
        $video->video_logo = $input['video_logo'];
        $video->video_intro = $input['video_intro'];
        $video->video_desc = $input['video_desc'];
        $video->video_sideimg = $input['video_sideimg'];
        $video->video_img = $input['video_img'];
        $video->thumbnail = $thumbnail;
        $video->feature_embed = $feature;
        $video_link = $video->video_link;
        //  $video_link =   $function->video_link;
        $form->basicEntitySave($video, $input);

        return $form;
    }

    public function createEmbedDataHandler($bbCodeMediaSiteId) {
        $handlers = $this->getEmbedDataHandlers();

        if (isset($handlers[$bbCodeMediaSiteId])) {
            $handlerClass = $handlers[$bbCodeMediaSiteId];
        } else {
            $handlerClass = 'XenBulletins\VideoPages\EmbedData\BaseData';
        }

        if (strpos($handlerClass, ':') === false && strpos($handlerClass, '\\') === false) {
            $handlerClass = "XenBulletins\VideoPages:$handlerClass";
        }
        $handlerClass = \XF::stringToClass($handlerClass, '\%s\EmbedData\%s');
        $handlerClass = \XF::extendClass($handlerClass);

        return new $handlerClass($this->app());
    }

    protected function getEmbedDataHandlers() {
        $handlers = [
            'imgur' => 'XenBulletins\VideoPages:Imgur',
            'vimeo' => 'XenBulletins\VideoPages:Vimeo',
            'youtube' => 'XenBulletins\VideoPages:YouTube'
        ];

        $this->app()->fire('xfmg_embed_data_handler_prepare', [&$handlers]);

        return $handlers;
    }

    public function getAbstractedTempThumbnailPathProof($match) {
        $tempId = $match['media_id'];

        return sprintf('data://xfvp/temp/%s-%s.jpg', $tempId, $match['media_site_id']
        );
    }

    function getVimeoVideoThumbnailByVideoId($id = '', $thumbType = 'medium') {

        $id = trim($id);

        if ($id == '') {
            return FALSE;
        }

        $apiData = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));

        if (is_array($apiData) && count($apiData) > 0) {

            $videoInfo = $apiData[0];

            switch ($thumbType) {
                case 'small':
                    return $videoInfo['thumbnail_small'];
                    break;
                case 'large':
                    return $videoInfo['thumbnail_large'];
                    break;
                case 'medium':
                    return $videoInfo['thumbnail_medium'];
                default:
                    break;
            }
        }

        return FALSE;
    }

    //************************Add, Edit Function**********************************************
    public function functionAddEdit($site) {

        $i = 0;
        $images = array();

        $site->video_sideimg = $site->getDepositImgUrl($canonical = True, 'video_sideimg');
        $site->video_img = $site->getDepositImgUrl($canonical = True, 'video_img');
        $site->video_logo = $site->getDepositImgUrl($canonical = True, 'video_logo');
        $phrase = $this->assertPhraseExists($site->desc_ph_id);
        $phrase_intro = $this->assertPhraseExists($site->intro_ph_id);
        $p_desc = $phrase->phrase_text;
        $p_intro = $phrase_intro->phrase_text;
        $viewParams = [
            'data' => $site,
            'p_desc' => $p_desc,
            'p_intro' => $p_intro
        ];

        return $this->view('XenBulletins\VideoPages:AddVideo\Edit', 'brand_edit', $viewParams);
    }

    public function actionEdit(ParameterBag $params) {
        $site = $this->assertFunctionExists($params->video_id);

        return $this->functionAddEdit($site);
    }

    protected function assertFunctionExists($id, $with = null, $phraseKey = null) {
        return $this->assertRecordExists('XenBulletins\VideoPages:AddVideo', $id, $with, $phraseKey);
    }

    //************************Delete Function**********************************************
    public function actionDelete(ParameterBag $params) {

        $site = $this->assertFunctionExists($params->video_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');

        return $plugin->actionDelete(
                        $site, $this->buildLink('brand/delete', $site), $this->buildLink('brand/edit', $site), $this->buildLink('brand'), $site->video_link
        );
    }

}

