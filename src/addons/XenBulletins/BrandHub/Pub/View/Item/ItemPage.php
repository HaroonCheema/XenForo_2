<?php

namespace XenBulletins\BrandHub\Pub\View\Item;

class ItemPage extends \XF\Mvc\View
{
               
        public function renderJson()
	{
            $visitor = \XF::visitor();
            $params = $this->getParams();
            $templater = $this->renderer->getTemplater();
            
//            $html = '<span class="js-itemPage-' . $params['item']->item_id . '-' . $visitor->user_id . '"></span>';$html
            
            $html = '<apan></span>';
            
            
            return [
                    'html' => $this->renderer->getHtmlOutputStructure($html)
            ];
            
	}
        
}