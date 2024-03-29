<?php

namespace XenBulletins\BrandHub\Pub\View\Item;

class ItemReview extends \XF\Mvc\View
{
//	public function renderHtml()
//	{
//            $templater = $this->renderer->getTemplater();
//               
//                
//            $this->params['templateHtml'] = $templater->renderMacro('public:bh_item_review_macros', 'review_simple', [
//                                                'review' => $this->params['itemReview'],
//                                                'item' => $this->params['item']
//                                            ]);
//	}
        
        
        public function renderJson()
	{
            $visitor = \XF::visitor();
            $params = $this->getParams();
            $templater = $this->renderer->getTemplater();
            
            
            $html = '<span></span>';
            
            if(isset($params['itemReview']) 
                    && $params['itemReview']
                    && $visitor->hasPermission('bh_brand_hub','viewDeleted')
                    )
            {
                $html = $this->renderTemplate($this->getTemplateName(), $params);
            }
            
            
            if( ! isset($params['itemReview'])) 
            {
                $html = '<span class="js-itemReview-' . $params['item']->item_id . '-' . $visitor->user_id . '"></span>';
            }
            
            
            return [
                    'html' => $this->renderer->getHtmlOutputStructure($html)
            ];
            
	}
        
}