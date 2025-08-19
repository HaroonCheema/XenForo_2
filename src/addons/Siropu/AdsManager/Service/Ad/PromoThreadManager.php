<?php

namespace Siropu\AdsManager\Service\Ad;

class PromoThreadManager extends \XF\Service\AbstractService
{
	protected $ad;
     protected $threadId = 0;
     protected $prefixId = 0;
     protected $customFields = [];
     protected $sticky = false;

	public function __construct(\XF\App $app, $ad)
	{
		parent::__construct($app);

          $this->ad = $ad;

          if ($ad->Extra)
          {
               $this->setPrefix($ad->Extra->prefix_id);
               $this->setCustomFields($ad->Extra->custom_fields);
               $this->setSticky($ad->Extra->is_sticky);
          }
	}
     public function setThreadId($threadId)
     {
          $this->threadId = $threadId;
     }
     public function setPrefix($prefixId)
     {
          $this->prefixId = $prefixId;
     }
     public function setCustomFields(array $customFields)
     {
          $this->customFields = $customFields;
     }
     public function setSticky($sticky)
     {
          $this->sticky = $sticky;
     }
     public function getThreadId()
     {
          return $this->threadId;
     }
     public function getPrefixId()
     {
          return $this->prefixId;
     }
     public function save()
     {
          if ($this->ad->Thread)
          {
               $this->ad->Extra->togglePromoThreadForum();
               $this->ad->Extra->togglePromoThreadOptions();
          }
          else if ($this->ad->isActive())
          {
               \XF::asVisitor($this->ad->User, function ()
               {
                    $creator = \XF::service('XF:Thread\Creator', $this->ad->Forum);
                    $creator->setContent($this->ad->content_2, $this->ad->content_3);
                    $creator->setPrefix($this->prefixId);
                    $creator->setCustomFields($this->customFields);
                    $creator->setSticky($this->sticky);
                    $creator->setAttachmentHash(\XF::app()->request()->filter('attachment_hash', 'str'));
                    $creator->setIsAutomated();
                    $creator->save();

                    $attachments = $this->finder('XF:Attachment')
                         ->where('content_type', 'siropu_ads_manager_ad')
                         ->where('content_id', $this->ad->ad_id)
                         ->fetch();

                    if ($attachments)
                    {
                         $firstPost = $creator->getThread()->FirstPost;

                         foreach ($attachments as $attachment)
                         {
                              $attachment->content_type = 'post';
               			$attachment->content_id = $firstPost->post_id;
                              $attachment->save();
                         }

                         $firstPost->attach_count += $attachments->count();
                         $firstPost->save();
                    }

                    $threadId = $creator->getThread()->thread_id;

                    \XF::db()->update('xf_siropu_ads_manager_ad', ['item_id' => $threadId], 'ad_id = ?', $this->ad->ad_id);

                    $this->threadId = $threadId;
               });
          }
     }
}
