<?php
namespace XenBulletins\VideoPages\Pub\Controller;
use XF\Pub\Controller\AbstractController;
use XenBulletins\DepositDetail\Entity;
use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\Finder;

class FetchVideo extends AbstractController{
    
    public function actionIndex(ParameterBag $params)
        {
       
           $options = \XF::options();
        
          $sites = $this->finder('XenBulletins\VideoPages:Iframe')->with('Brand')->fetch();
   
          $video = $this->finder('XenBulletins\VideoPages:AddVideo')->fetch();
           $iframes = $this->finder('XenBulletins\VideoPages:Iframe')->where(['video_id'=>$params->video_id > 0])->order('date','desc');
          //feature video
          // $feature = $this->finder('XenBulletins\VideoPages:Iframe')->where('feature','1')->order('date','DESC')->fetch();
          $feature = "select * from xf_iframe where feature = 1 order by date desc LIMIT 1";
          $latestRecord = \XF::options()->latestRecord;
          
          $sliderVideosOption = $options->xb_slider_videos;
          //latest Record
//          $latest1 = "SELECT iframe_URL , thumbnail,iframe_title FROM `xf_iframe` WHERE FROM_UNIXTIME(date,'%Y-%m-%d') BETWEEN CURDATE() - INTERVAL $latestRecord DAY AND CURDATE() LIMIT $sliderVideosOption ";
          $latest1 = "SELECT * FROM `xf_iframe` order by date desc LIMIT $sliderVideosOption ";
          
  
//Rons Videos
          $rons = "SELECT * FROM xf_iframe where rons=1 order by date desc limit $sliderVideosOption ";
          //$rons = $this->finder('XenBulletins\VideoPages:Iframe')->where('rons','1')->order('date','DESC')->limit($options->ronsvideos)->fetch();
          
          $videobrand = $this->finder('XenBulletins\VideoPages:Iframe')->where('video_id','>',0)->order('date','desc')->limit($sliderVideosOption )->fetch();
        
          $db= \XF::db();
          
	  $ronsvideo = $db->query($rons)->fetchAll();
          $featurevideo = $db->query($feature)->fetchAll();
          $latestvideo1 = $db->query($latest1)->fetchAll();
          
          $viewParams = [
          'data' => $sites,
          'video' => $video,
          'ronsvideo' => $ronsvideo,
          'latestvideo1' => $latestvideo1,
          'featurevideo' => isset($featurevideo[0])?$featurevideo[0]:'',
          'videobrand' => $videobrand,
          'iframes'=> $iframes->fetch()
         
      	];
         
        return $this->view('XenBulletins\VideoPages:AddVideo', 'brand_view', $viewParams);
        
       
    }
    
       public function actionBrand(){
          $brand = 'SELECT * FROM xf_iframe WHERE iframe_id ='.$params->iframe_id;
          $iframes = $this->finder('XenBulletins\VideoPages:Iframe')->fetch();
    
          $options = \XF::options();
          $sliderVideosOption = $options->xb_slider_videos;
          
          $db=\XF::db();
	  $brand = $db->query($brand)->fetchAll();
          $video = $this->finder('XenBulletins\VideoPages:AddVideo')->limit($sliderVideosOption)->fetch();
         

        $viewParams = [
        'brand' => $brand[0],
        'video' => $video,
        'iframes'=>$iframes
      	];
          return $this->view('XenBulletins\VideoPages:AddVideo', 'videoslist', $viewParams);
      }
}
