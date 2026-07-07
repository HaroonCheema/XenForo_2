<?php

namespace xenMade\LAU\XF\Repository;

class Thread extends XFCP_Thread
{
    public function markThreadReadByVisitor(\XF\Entity\Thread $thread, $newRead = null)
    {
        $session = \XF::app()->session();

        if(!$session->exists())
        {
            parent::markThreadReadByVisitor($thread, $newRead);
        }

        if(
            $session->offsetExists('lau_id') &&
            $session->offsetExists('lau_stealth')
        )
        {
            return;
        }

        parent::markThreadReadByVisitor($thread, $newRead);
    }
}