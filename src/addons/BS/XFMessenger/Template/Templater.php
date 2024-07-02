<?php

namespace BS\XFMessenger\Template;

class Templater
{
    public static function createRoomFormPreRender(
        \XF\Template\Templater $templater,
        &$type,
        &$template,
        &$name,
        array &$arguments,
        array &$globalVars
    ) {
        $arguments['maxRecipients'] = \XF::em()->create('XF:ConversationMaster')
            ->getMaximumAllowedRecipients();

        $arguments['draft'] = \XF\Draft::createFromKey('conversation');
    }
}
