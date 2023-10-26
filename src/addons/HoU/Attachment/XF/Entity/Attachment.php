<?php

namespace HoU\Attachment\XF\Entity;

use XF\Entity\Forum;
use XF\Entity\Post;
use XF\Entity\User;

class Attachment extends XFCP_Attachment
{
    /**
     * @param null $error
     * @return bool
     */
    public function canView(&$error = null)
    {
        if(!$this->canViewAttachment()) {
            return false;
        }
        return parent::canView($error); // TODO: Change the autogenerated stub
    }

    /**
     * Can view attachment
     * @return bool
     */
     public function canViewAttachment() {
         
    
         $acpOptions = \XF::options();
         $visitor = \XF::visitor();

         if($this->_isExcludedExtension()) {
             return true;
         }

         if(!$acpOptions->hou_attachment_require_like) {
             return true;
         }

         if($this->Data->user_id === $visitor->user_id) {
            return true;
         }

         if($visitor->hasPermission('like', 'needlike')) {
             return true;
         }

         $container = $this->getContainer();

         if($container instanceof Post) {
             if($this->_isExcludedForum($container->Thread->Forum)) {
                 return true;
             }
			 if($acpOptions->hou_attachment_require_like) {
                 return $container->_hasLikePost($visitor);
			 }
         }

         return false;
     }

    /**
     * @param Forum $forum
     * @return bool
     */
    private function _isExcludedForum(Forum $forum)
    {
        $acpOptions = \XF::options();
        if(in_array($forum->node_id, $acpOptions->hou_attachment_exclude_forum)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function _isExcludedExtension() {
        $acpOptions = \XF::options();
        $extensions = explode("\n",$acpOptions->hou_attachment_exclude_extension);
        foreach ($extensions as $key => $value) {
            $extensions[$key] = trim($value);
        }

        if(in_array($this->extension, $extensions)) {
            return true;
        }

        return false;
    }
}