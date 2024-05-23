<?php

namespace FS\PrivateBbcode\XF\Service\Message;

class Preparer extends XFCP_Preparer
{
    /**
     * @param $message
     *
     * @return bool
     */
    public function checkValidity($message)
    {
        parent::checkValidity($message);

        /** @var \XF\BbCode\ProcessorAction\AnalyzeUsage $usage */
        $usage = $this->bbCodeProcessor->getAnalyzer('usage');
        
        $tag = 'private';
        
        if ($usage->getTagCount($tag) && !\XF::visitor()->canUsePrivateBbcodeTag())
        {
            $this->errors[] = \XF::phraseDeferred("fs_private_bbcode_tag_no_permission");
        }

        $this->isValid = (\count($this->errors) == 0);
        return $this->isValid;
    }
}