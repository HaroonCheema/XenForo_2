<?php

namespace FS\IframeVideoChanges\XB\VideoPages\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;


class Iframe extends XFCP_Iframe
{
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
            'display_day' => 'array-uint',
            // 'display_day' => 'UINT',
            // 'for_days' => 'UINT',
        ]);

        $dayMap = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Unknown'
        ];

        $selectedDays = array_diff($input['display_day'] ?? [7], [7]);

        if ($selectedDays && $input['feature']) {

            $finder = $this->finder('XenBulletins\VideoPages:Iframe');

            if (!empty($function->iframe_id)) {
                $finder->where('iframe_id', '!=', $function->iframe_id);
            }

            /** @var \XF\Mvc\Entity\ArrayCollection $existingItems */
            $existingItems = $finder->fetch();

            foreach ($existingItems as $existing) {

                foreach ($selectedDays as $day) {

                    if (!in_array($day, $existing->display_day, true)) {
                        continue;
                    }

                    if ($existing->feature) {

                        $dayName = $dayMap[$day] ?? ('Day ' . $day);

                        throw $this->exception(
                            $this->error(
                                sprintf(
                                    '%s is already featured on %s.',
                                    $existing->iframe_title,
                                    $dayName
                                )
                            )
                        );
                    }

                    $days = array_diff($existing->display_day, [$day]);

                    if (!$days) {
                        $days = [7];
                    }

                    $existing->fastUpdate('display_day', $days);
                }
            }
        }


        // if ($input['display_day'] != 7) {

        //     $displaydayExit = $this->finder('XenBulletins\VideoPages:Iframe')->where('display_day', $input['display_day']);

        //     if ($function->iframe_id) {
        //         $displaydayExit->where('iframe_id', '!=', $function->iframe_id);
        //     }

        //     $displaydayExit = $displaydayExit->fetchOne();

        //     if ($displaydayExit && $displaydayExit->feature) {

        //         throw $this->exception($this->error($displaydayExit->iframe_title . " Already Added on that day.....!"));
        //     }

        //     if ($displaydayExit && !$displaydayExit->feature) {


        //         $displaydayExit->fastUpdate('display_day', 7);
        //     }
        // }


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
        // $function->for_days = $input['for_days'] ?? 1;
        $function->thumbNail = $thumbnail;
        $function->feature_embed = $feature;
        $iframe_URL = $function->iframe_URL;

        //        var_dump($iframe_id);exit;s

        $form->basicEntitySave($function, $input);
        return $form;
    }
}
