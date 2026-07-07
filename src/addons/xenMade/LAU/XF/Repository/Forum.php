<?php

namespace xenMade\LAU\XF\Repository;

class Forum extends XFCP_Forum
{
    public function markForumReadByVisitor(\XF\Entity\Forum $forum, $newRead = null)
    {
        $session = \XF::app()->session();

        if(!$session->exists())
        {
            parent::markForumReadByVisitor($forum, $newRead);
        }

        if(
            $session->offsetExists('lau_id') &&
            $session->offsetExists('lau_stealth')
        )
        {
            return;
        }

        parent::markForumReadByVisitor($forum, $newRead);
    }

    public function markForumTreeReadByVisitor(\XF\Entity\AbstractNode $baseNode = null, $newRead = null)
    {
        $session = \XF::app()->session();

        if(!$session->exists())
        {
            parent::markForumTreeReadByVisitor($baseNode, $newRead);
        }

        if(
            $session->offsetExists('lau_id') &&
            $session->offsetExists('lau_stealth')
        )
        {
            return;
        }

        parent::markForumTreeReadByVisitor($baseNode, $newRead);
    }
}