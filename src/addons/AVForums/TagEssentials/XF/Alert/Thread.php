<?php

namespace AVForums\TagEssentials\XF\Alert;



use XF\Entity\UserAlert;
use XF\Mvc\Entity\Entity;

/**
 * Extends \XF\Alert\Thread
 */
class Thread extends XFCP_Thread
{
    public function getTemplateData($action, UserAlert $alert, Entity $content = null)
    {
        $data = parent::getTemplateData($action, $alert, $content);

        if ($action === 'new_tagged_content')
        {
            $data['contentTypePhrase'] = \XF::app()->getContentTypePhrase($alert->content_type);
            $data['contentTitle'] = $content->get('title');
            $data['contentLink'] = \XF::app()->router('public')->buildLink('threads', $content);
        }

        return $data;
    }
}