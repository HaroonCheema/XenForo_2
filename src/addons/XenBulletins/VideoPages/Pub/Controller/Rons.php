<?php
namespace XenBulletins\VideoPages\Pub\Controller;
use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\Finder;
use XF\Pub\Controller\AbstractController;
class Rons extends AbstractController {
   public function actionIndex(ParameterBag $params)
    {
           $options = \XF::options();
           $page = $this->filterPage();
           $perPage = $options->ronspage;

            $sites = $this->Finder('XenBulletins\VideoPages:Iframe')->where(['rons'=>'1']);
           
            $total = $sites->total();
            $this->assertValidPage($page, $perPage, $total, 'Rons');
            $sites->limitByPage($page, $perPage);
            $feature = "select iframe_URL ,thumbnail ,feature_embed from xf_iframe where rons_featured = 1 order by date desc LIMIT 1";
             $db= \XF::db();
$featurevideo = $db->query($feature)->fetchAll();
         
          $iframes =  $this->em()->create('XenBulletins\VideoPages:Iframe');
         

          $video = $this->finder('XenBulletins\VideoPages:AddVideo')->fetch();

        $viewParams = [
        'rons' => $sites->fetch(),
        'video' => $video,
        'iframes'=>$iframes,
        'page' => $page,
        'perPage' => $perPage,
        'total' => $total,
         'featurevideo' => isset($featurevideo[0])?$featurevideo[0]:'',    
      	];
 
          return $this->view('XenBulletins\VideoPages:AddVideo', 'rons', $viewParams);
    }
}
