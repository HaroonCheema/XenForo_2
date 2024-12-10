<?php
namespace XenBulletins\VideoPages\Pub\Controller;
use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\Finder;
use XF\Pub\Controller\AbstractController;
class Brand extends AbstractController {
    public function actionIndex(ParameterBag $params)
    {
           $options = \XF::options();
           $page = $this->filterPage();
           $perPage =  $options->brand_page;
           $brand = 'SELECT * FROM xf_videopages WHERE video_id='.$params->video_id;
           $iframes = $this->finder('XenBulletins\VideoPages:Iframe')->where(['video_id'=>$params->video_id]);
          

          $db=\XF::db();
	  $brand = $db->query($brand)->fetchAll();

          $video = $this->finder('XenBulletins\VideoPages:AddVideo')->fetch();
          $brand_logo     = $this->getDepositImgUrl($canonical = True,'video_logo',$brand[0]["video_id"]);

          $brand_sideimg  = $this->getDepositImgUrl($canonical = True,'video_sideimg',$brand[0]["video_id"]);
          $brand_img      = $this->getDepositImgUrl($canonical = True,'video_img',$brand[0]["video_id"]);
       
          $desc = \XF::phrase($brand[0]['video_desc']);
          $intro = \XF::phrase($brand[0]['video_intro']);
          
           $total = $iframes->total();
           $perPage=9;
           $this->assertValidPage($page, $perPage, $total, 'brand');
           $iframes->limitByPage($page, $perPage);

            $link = 'brand/'.$params->video_id.'/';
          
        $viewParams = [
        'brand' => $brand[0],
        'link'=>$link,
        'video' => $video,
        'intro'=>$intro,
        'desc'=>$desc,
        'logo'  => $brand_logo,
        'side'  => $brand_sideimg,
        'brand_img'=>$brand_img,
        'iframes'=>$iframes->fetch(),
       // 'videos'=>$videos->fetch(),
        'page' => $page,
        'perPage' => $perPage,
        'total' => $total
      	];
         
          return $this->view('XenBulletins\VideoPages:AddVideo', 'brand_videopage', $viewParams);
    }
    
        protected function assertPhraseExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('XF:Phrase', $id, $with, $phraseKey);
	}
        
    public function getDepositImgUrl($canonical = true,$type,$id)
    {
       
        if($type == 'video_logo'){
            $fn = 'video_logo';
        }
        else if($type == 'video_sideimg'){
            $fn = 'video_sideimg';
        }
        else{
            $fn = 'video_img';
        }
        $VideoId = $id;
        $path = sprintf('brand_img/'.$fn.'/%d/%d.jpg', floor($VideoId / 1000), $VideoId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }
    
}


