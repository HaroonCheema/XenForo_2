<?php

namespace Siropu\AdsManager\Entity;

class AbstractEntity extends \XF\Mvc\Entity\Entity
{
     public function isCode()
     {
          return $this->type == 'code';
     }
     public function isBanner()
     {
          return $this->type == 'banner';
     }
     public function isText()
     {
          return $this->type == 'text';
     }
     public function isLink()
     {
          return $this->type == 'link';
     }
     public function isKeyword()
     {
          return $this->type == 'keyword';
     }
     public function isAffiliate()
     {
          return $this->type == 'affiliate';
     }
     public function isSticky()
     {
          return $this->type == 'sticky';
     }
     public function isThread()
     {
          return $this->type == 'thread';
     }
     public function isResource()
     {
          return $this->type == 'resource';
     }
     public function isPopup()
     {
          return $this->type == 'popup';
     }
     public function isBackground()
     {
          return $this->type == 'background';
     }
     public function isCustom()
     {
          return $this->type == 'custom';
     }
     public function isJavaScript()
     {
          return $this->isOfType(['popup', 'background']);
     }
     public function isOfType(array $types)
     {
          return in_array($this->type, $types);
     }
     public function isXFItem()
     {
          return $this->isOfType(['thread', 'sticky', 'resource']);
     }
     public function isEmbeddable()
     {
          return $this->isOfType(['code', 'banner', 'text', 'link']);
     }
     public function hasNoCriteria()
     {
          return $this->isOfType(['thread', 'sticky', 'resource', 'custom']);
     }
     public function getTypePhrase()
     {
          return \XF::phrase('siropu_ads_manager_ad_type.' . $this->type);
     }
     public function getUnitCssClass()
     {
          $cssClass = '';

          $options = \XF::options();

          switch ($this->type)
          {
               case 'code':
                    $cssClass .= $options->siropuAdsManagerSamCodeUnitCssClass;
                    break;
               case 'banner':
                    $cssClass .= $options->siropuAdsManagerSamBannerUnitCssClass;
                    break;
               case 'text':
                    $cssClass .= $options->siropuAdsManagerSamTextUnitCssClass;
                    break;
               case 'link':
                    $cssClass .= $options->siropuAdsManagerSamLinkUnitCssClass;
                    break;
          }

          $cssClass .= $this->getUnitAlignmentClass();

          switch ($this->getSetting('display'))
          {
               case 'block':
                    break;
               case 'iblock':
                    $cssClass .= ' samDisplayInlineBlock';
                    break;
               case 'inline':
                    $cssClass .= ' samDisplayInline';
                    break;
               case 'flexbox':
                    $cssClass .= ' samDisplayFlexbox';
                    break;
          }

          $inlineStyle = $this->getSetting('inline_style') ?: $this->settings['unit_style'];

          if (!empty($this->settings['unit_size']) || ($inlineStyle && strpos($inlineStyle, 'width:') !== false))
          {
               $cssClass .= ' samCustomSize';
          }

          return $cssClass;
     }
     public function getUnitAlignmentClass()
     {
          switch ($this->settings['unit_alignment'])
          {
               case 'left':
                    return ' samAlignLeft';
                    break;
               case 'right':
                    return ' samAlignRight';
                    break;
               case 'center':
                    return ' samAlignCenter';
                    break;
          }
     }
     public function getUnitSizeArray()
     {
          $size = array_filter(explode('x', $this->settings['unit_size']));

          if ($size)
          {
               return [
                    'width'  => $size[0],
                    'height' => $size[1]
               ];
          }
     }
     public function getUnitSize()
     {
          $attr = '';

          if ($size = $this->getUnitSizeArray())
          {
               $attr .= ' style="width: ' . $size['width'] . 'px; height: ' . $size['height'] . 'px;"';
          }

          return $attr;
     }
     public function getAdRepo()
     {
          return $this->repository('Siropu\AdsManager:Ad');
     }
     public function getPackageRepo()
     {
          return $this->repository('Siropu\AdsManager:Package');
     }
     public function getInvoiceRepo()
     {
          return $this->repository('Siropu\AdsManager:Invoice');
     }
     public function getPositionRepo()
     {
          return $this->repository('Siropu\AdsManager:Position');
     }
     protected function verifyPosition(&$position)
     {
          if ($this->isOfType(['popup', 'background']))
          {
               $position[] = 'javascript';
          }

          return true;
     }
     protected function verifyUserCriteria(&$criteria)
     {
          $userCriteria = $this->app()->criteria('XF:User', $criteria);
          $criteria = $userCriteria->getCriteria();

          return true;
     }
     protected function verifyPageCriteria(&$criteria)
     {
          $pageCriteria = $this->app()->criteria('XF:Page', $criteria);
          $criteria = $pageCriteria->getCriteria();

          return true;
     }
     protected function verifyPositionCriteria(&$criteria)
     {
          $positionCriteria = $this->app()->criteria('Siropu\AdsManager:Position', $criteria);
          $criteria = $positionCriteria->getCriteria();

          return true;
     }
     protected function verifyDeviceCriteria(&$criteria)
     {
          $deviceCriteria = $this->app()->criteria('Siropu\AdsManager:Device', $criteria);
          $criteria = $deviceCriteria->getCriteria();

          return true;
     }
     protected function verifyGeoCriteria(&$criteria)
     {
          $geoCriteria = $this->app()->criteria('Siropu\AdsManager:Geo', $criteria);
          $criteria = $geoCriteria->getCriteria();

          return true;
     }
}
