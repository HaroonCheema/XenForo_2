<?php

namespace XenBulletins\VideoPages\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XenBulletins\VideoPages\Entity;
use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\Finder;

class Iframe extends AbstractController
{

    public function actionIndex()
    {

        $sites = $this->finder('XenBulletins\VideoPages:Iframe')->with('Brand')->order('iframe_title')->fetch();
        $viewParams = [
            'data' => $sites,
        ];

        return $this->view('XenBulletins\VideoPages:Iframe', 'iframe', $viewParams);
    }

    public function actionAdd()
    {
        $sites = $this->em()->create('XenBulletins\VideoPages:Iframe');
        $sites = $this->finder('XenBulletins\VideoPages:AddVideo');
        $sql = "SELECT * FROM `xf_videopages` ORDER BY `video_link` ASC ";
        $db = \XF::db();
        $iframeSites = $db->query($sql)->fetchAll();

        $sites = $sites->fetch();
        $viewParams = [
            'data' => $sites,
            'iframeSites' => $iframeSites
        ];
        return $this->view('XenBulletins\VideoPages:Iframe', 'add_iframevalues', $viewParams);
        return $this->functionAddEdit($sites);
    }

    //////////////////////////***save***/////////////////////////////

    public function actionSave(ParameterBag $params)
    {
        $this->assertPostOnly();

        if ($params->iframe_id) {
            $function = $this->assertFunctionExists($params->iframe_id);
        } else {
            $function = $this->em()->create('XenBulletins\VideoPages:Iframe');
        }

        $this->tagSaveProcess($function)->run();
        return $this->redirect($this->buildLink('iframe'));
    }

    public function extractVideoID($iframe_URL)
    {

        $sites = $this->finder('XenBulletins\VideoPages:Iframe')->with('video')->fetch();
        var_dump($sites);
        exit;
        $viewParams = [
            'data' => $sites
        ];

        $regExp = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";
        preg_match($regExp, $iframe_URL, $viewParams);

        return $video[7];
    }

    function getYouTubeThumbnailImage($iframe_id)
    {
        return "https://i3.ytimg.com/vi/$iframe_id/hqdefault.jpg"; //pass 0,1,2,3 for different sizes like 0.jpg, 1.jpg
    }

    public function createEmbedDataHandler($bbCodeMediaSiteId)
    {
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

    protected function getEmbedDataHandlers()
    {
        $handlers = [
            'imgur' => 'XenBulletins\VideoPages:Imgur',
            'vimeo' => 'XenBulletins\VideoPages:Vimeo',
            'youtube' => 'XenBulletins\VideoPages:YouTube'
        ];

        $this->app()->fire('xfmg_embed_data_handler_prepare', [&$handlers]);

        return $handlers;
    }

    public function getAbstractedTempThumbnailPathProof($match)
    {
        $tempId = $match['media_id'];

        return sprintf(
            'data://xfvp/temp/%s-%s.jpg',
            $tempId,
            $match['media_site_id']
        );
    }

    protected function tagSaveProcess(\XenBulletins\VideoPages\Entity\Iframe $function)
    {

        $form = $this->formAction();
        $input = $this->filter([
            'iframe_title' => 'STR',
            'iframe_URL' => 'STR',
            'video_id' => 'UINT',
            'rons' => 'UINT',
            'feature' => 'UINT',
            'rons_featured' => 'UINT',
            'display_day' => 'UINT',
            'for_days' => 'UINT',
        ]);

        if ($input['display_day'] != 7) {

            $displaydayExit = $this->finder('XenBulletins\VideoPages:Iframe')->where('display_day', $input['display_day']);

            if ($function->iframe_id) {
                $displaydayExit->where('iframe_id', '!=', $function->iframe_id);
            }

            $displaydayExit = $displaydayExit->fetchOne();

            if ($displaydayExit && $displaydayExit->feature) {

                throw $this->exception($this->error($displaydayExit->iframe_title . " Already Added on that day.....!"));
            }

            if ($displaydayExit && !$displaydayExit->feature) {


                $displaydayExit->fastUpdate('display_day', 7);
            }
        }




        $bbCodeMediaSiteRepo = $this->repository('XF:BbCodeMediaSite');
        $sites = $bbCodeMediaSiteRepo->findActiveMediaSites()->fetch();

        $allowed = ['youtube', 'vimeo', 'facebook'];

        foreach ($sites as $key => $site) {
            if (!in_array($key, $allowed)) {
                $sites->offsetUnset($key);
            }
        }



        $match = $bbCodeMediaSiteRepo->urlMatchesMediaSiteList($input['iframe_URL'], $sites);

        $thumbnail = '';
        if ($match['media_site_id'] != 'facebook') {
            $embedDataHandler = $this->createEmbedDataHandler($match['media_site_id']);
            $thumbnailGenerator = $this->service('XenBulletins\VideoPages:Media\ThumbnailGenerator');
            $tempFile = $embedDataHandler->getTempThumbnailPath($input['iframe_URL'], $match['media_site_id'], $match['media_id']);

            $abstractedThumbnailPath = $this->getAbstractedTempThumbnailPathProof($match);

            $thumbnailGenerator->getTempThumbnailFromImage($tempFile, $abstractedThumbnailPath);

            $thumbnail = $match['media_id'] . "-" . $match['media_site_id'] . ".jpg";
        } else {
            //upload thumbnail for facebook

            $time = time();

            $abstractpath = sprintf('data://facebook/%d.jpg', $time);

            $thumbnail = sprintf('https://whatsbestforum.com/data/facebook/%d.jpg', $time);

            $fbthumb = $this->request->getFile('video_thumbnail', false, false);
            $imageManager = \XF::app()->imageManager();
            $image = $imageManager->imageFromFile($fbthumb->getTempFile());

            $newTempFile = \XF\Util\File::getTempFile();
            if ($newTempFile && $image->save($newTempFile, null, 95)) {
                $outputFiles['o'] = $newTempFile;
                $baseFile = $newTempFile;
                $width = $image->getWidth();
                $height = $image->getHeight();
            }

            foreach ($outputFiles as $code => $file) {

                \XF\Util\File::copyFileToAbstractedPath($file, $abstractpath);
            }
        }





        if (preg_match('/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/', $input['iframe_URL'])) {
            $link = $input['iframe_URL'];
            $video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
            if (empty($video_id[1]))
                $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..
            //      if (empty($video_id[1]))
            //      $video_id = explode("/embed/", $link);
            $provider = "youtube";
            $video_id = explode("&", $video_id[1]); // Deleting any other params
            $video_id = $video_id[0];
            $feature = "https://www.youtube.com/embed/" . $video_id;

            //    $thumbnail  =  "http://img.youtube.com/vi/".$video_id."/default.jpg";


            $iframe_URL = "http://www.youtube.com/watch?v=" . $video_id;
        } elseif (preg_match('~^https?:\/\/www\.facebook\.com.*\/(video(s)?|watch|story)(\.php?|\/).+$~', $input['iframe_URL'])) {

            if (preg_match("~(?:t\.\d+/)?(\d+)~i", $input['iframe_URL'], $matches)) {
                $provider = "facebook";
                $video_id = $matches[1];
                $iframe_URL = $input['iframe_URL'];
                $feature = "https://www.facebook.com/video/embed?video_id=$video_id";
            }
        } else {

            $link = $input['iframe_URL'];
            $video_id = explode("com/", $link); // For videos like http://www.youtube.com/watch?v=...
            //     if (empty($video_id[1]))
            //     $video_id = explode("/video/", $link); // For videos like http://www.youtube.com/watch/v/..
            //        
            $provider = "vimeo";
            $video_id = explode("&", $video_id[1]); // Deleting any other params

            $video_id = $video_id[0];
            //  $thumbnail = $this->getVimeoVideoThumbnailByVideoId($video_id, 'medium');
            $iframe_URL = 'https://player.vimeo.com/' . $video_id;
            $feature = 'https://player.vimeo.com/video/' . $video_id;
        }

        if ($input['video_id'] > 0 && $input['rons'] == 1) {
            throw $this->exception($this->error(\XF::phrase('Please select one from Brand Link or Rons Interview ')));
        } else if ($input['video_id'] == 0 && $input['rons'] == 0) {
            throw $this->exception($this->error(\XF::phrase('select one from Brand Link or Rons Interview  ')));
        }


        if (($input['rons_featured'] or $input['feature']) and $provider == "facebook") {
            throw $this->exception($this->error(\XF::phrase('facebook video can not be added as feature video')));
        }



        $input['iframe_URL'] = $iframe_URL;
        $function->iframe_title = $input['iframe_title'];
        $function->iframe_URL = $input['iframe_URL'];
        $function->video_id = $input['video_id'];
        $function->video = $video_id;
        $function->rons = $input['rons'];
        $function->feature = $input['feature'];
        $function->provider = $provider;
        $function->rons_featured = $input['rons_featured'];
        $function->for_days = $input['for_days'] ?? 1;
        $function->thumbNail = $thumbnail;
        $function->feature_embed = $feature;
        $iframe_URL = $function->iframe_URL;

        //        var_dump($iframe_id);exit;s

        $form->basicEntitySave($function, $input);
        return $form;
    }

    function getVimeoVideoThumbnailByVideoId($id = '', $thumbType = 'medium')
    {

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

    /////////////////////////////***Edit Function***//////////////////////
    public function functionAddEdit($site)
    {
        $sql = "SELECT * FROM `xf_videopages` ORDER BY `video_link` ASC ";
        $db = \XF::db();
        $iframeSites = $db->query($sql)->fetchAll();
        $viewParams = [
            'data' => $site,
            'iframeSites' => $iframeSites
        ];

        return $this->view('XenBulletins\VideoPages:Iframe\Edit', 'iframe_edit', $viewParams);
    }

    public function actionEdit(ParameterBag $params)
    {
        $site = $this->assertFunctionExists($params->iframe_id);

        return $this->functionAddEdit($site);
    }

    protected function assertFunctionExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('XenBulletins\VideoPages:Iframe', $id, $with, $phraseKey);
    }

    //*******************Delete Function**************************************************
    public function actionDelete(ParameterBag $params)
    {

        $site = $this->assertFunctionExists($params->iframe_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');

        return $plugin->actionDelete(
            $site,
            $this->buildLink('iframe/delete', $site),
            $this->buildLink('iframe/edit', $site),
            $this->buildLink('iframe'),
            $site->iframe_title
        );
    }
}
