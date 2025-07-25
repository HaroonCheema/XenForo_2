<?php

namespace FS\SendMailFromTable\XF\Entity;

class Option extends XFCP_Option
{
    public function getEmailTemplates()
    {
        $finder = \XF::app()->finder('FS\SendMailFromTable:EmailTemplates')->order('id', 'DESC')->fetch();

        return $finder ?? [];
    }
}
