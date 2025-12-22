<?php

namespace XenBulletins\VideoPages\Pub\Controller;

use XF\Pub\Controller\AbstractController;
use XenBulletins\DepositDetail\Entity;
use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\Finder;

class FetchVideo extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {

        // $currentDay = date('w', \XF::$time);
        // $currentDay = 1;



        $options = \XF::options();

        //   $sites = $this->finder('XenBulletins\VideoPages:Iframe')->with('Brand')->fetch();

        $currentDay = date('w', \XF::$time);
        $video = $this->finder('XenBulletins\VideoPages:AddVideo')->order('video_feature', 'asc')->fetch();

        $nav1 = [];
        $nav2 = [];
        foreach ($video as $key => $nav) {
            if (preg_match("/^[a-lA-L]/", $nav->video_feature)) {
                $nav1[] = $nav;
            } else {
                $nav2[] = $nav;
            }
        }


        //  $iframes = $this->finder('XenBulletins\VideoPages:Iframe')->where('video_id', '>', 0)->order('date','desc');
        //feature video
        // $feature = $this->finder('XenBulletins\VideoPages:Iframe')->where('feature','1')->order('date','DESC')->fetch();
        // $feature = "SELECT * FROM xf_iframe 
        //         WHERE feature = 1 
        //         AND display_day = $currentDay 
        //         ORDER BY date DESC 
        //         LIMIT 1";
        $feature = "
    SELECT *
    FROM xf_iframe
    WHERE feature = 1
      AND (
            (display_day <= $currentDay AND (display_day + for_days - 1) >= $currentDay)
            OR
            (display_day > (display_day + for_days - 1)
                AND ($currentDay >= display_day OR $currentDay <= ((display_day + for_days - 1) % 7))
            )
          )
    ORDER BY date DESC
    LIMIT 1
";

        $latestRecord = \XF::options()->latestRecord;

        $sliderVideosOption = $options->xb_slider_videos;
        //latest Record
        //          $latest1 = "SELECT iframe_URL , thumbnail,iframe_title FROM `xf_iframe` WHERE FROM_UNIXTIME(date,'%Y-%m-%d') BETWEEN CURDATE() - INTERVAL $latestRecord DAY AND CURDATE() LIMIT $sliderVideosOption ";
        $latest1 = "SELECT * FROM `xf_iframe` order by date desc LIMIT 60 ";

        //Rons Videos
        //   $rons = "SELECT * FROM xf_iframe where rons=1 order by date desc limit $sliderVideosOption ";
        //$rons = $this->finder('XenBulletins\VideoPages:Iframe')->where('rons','1')->order('date','DESC')->limit($options->ronsvideos)->fetch();

        $videobrand = $this->finder('XenBulletins\VideoPages:AddVideo')->order('video_feature', 'asc')->limit($sliderVideosOption)->fetch();

        $db = \XF::db();

        //  $ronsvideo = $db->query($rons)->fetchAll();
        $featurevideo = $db->query($feature)->fetchAll();
        $latestvideo1 = $db->query($latest1)->fetchAll();

        if (!$featurevideo) {

            //$feature = "select * from xf_iframe where feature = 1 order by date desc LIMIT 1";
            // $featurevideo = $db->query($feature)->fetchAll();
        }


        $pieces = array_chunk($latestvideo1, 30);

        ////////////////////////////////////////////////////////////////////////////////



        $articleRepo = $this->getArticleRepo();

        $page = max(1, $params->page);
        $perPage = $this->options()->EWRporta_articles_perpage;
        $entries = $articleRepo->findArticle()->limitByPage($page, $perPage)
            ->where('Thread.discussion_state', 'visible')
            ->where('article_date', '<', \XF::$time)
            ->where('article_exclude', '0');

        $total = $entries->total();
        $maxPage = ceil($total / $perPage);

        $viewParams2 = $articleRepo->prepareViewParams($entries->fetch()) + [
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage
        ];

        //////////////////////////////////////////////////////////////////////////////



        $adverts = $this->Finder('XenBulletin\Advert:Advert')->order('advert_id', 'desc')->fetch();

        $viewParams = [
            //  'data' => $sites,
            'video' => $nav1,
            'nav2' => $nav2,
            // 'ronsvideo' => $ronsvideo,
            'latestvideo1' => isset($pieces[0]) ? $pieces[0] : [],
            'latestvideo2' => isset($pieces[1]) ? $pieces[1] : [],
            //  'latestvideo3' => isset($pieces[2]) ? $pieces[2] : [],
            'featurevideo' => isset($featurevideo[0]) ? $featurevideo[0] : '',
            'videobrand' => $videobrand,
            'iframes' => $videobrand,
            'adverts' => $adverts
        ] + $viewParams2;

        return $this->view('XenBulletins\VideoPages:AddVideo', 'brand_view', $viewParams);
    }

    protected function getArticleRepo()
    {
        return $this->repository('EWR\Porta:Article');
    }

    public function actionBrand()
    {
        $brand = 'SELECT * FROM xf_iframe WHERE iframe_id =' . $params->iframe_id;
        $iframes = $this->finder('XenBulletins\VideoPages:Iframe')->fetch();

        $options = \XF::options();
        $sliderVideosOption = $options->xb_slider_videos;

        $db = \XF::db();
        $brand = $db->query($brand)->fetchAll();
        $video = $this->finder('XenBulletins\VideoPages:AddVideo')->limit($sliderVideosOption)->fetch();

        $viewParams = [
            'brand' => $brand[0],
            'video' => $video,
            'iframes' => $iframes
        ];
        return $this->view('XenBulletins\VideoPages:AddVideo', 'videoslist', $viewParams);
    }
}
