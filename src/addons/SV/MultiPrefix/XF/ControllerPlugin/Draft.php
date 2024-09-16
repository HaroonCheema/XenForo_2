<?php

namespace SV\MultiPrefix\XF\ControllerPlugin;

use SV\MultiPrefix\Listener;


/**
 * Extends \XF\ControllerPlugin\Draft
 */
class Draft extends XFCP_Draft
{
    public function updateMessageDraft(\XF\Draft $draft, array $extraData = [], $messageInput = 'message')
    {
        if (Listener::$draftEntity && isset(Listener::$draftEntity->sv_prefix_ids))
        {
            $extraData['sv_prefix_ids'] = Listener::$draftEntity->sv_prefix_ids;
        }
        try
        {
            return parent::updateMessageDraft($draft, $extraData, $messageInput);
        }
        finally
        {
            Listener::$draftEntity = null;
        }
    }
}