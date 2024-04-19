<?php

namespace FS\InfoText\XF\Entity;

class Post extends XFCP_Post
{
    public function getAttachTextInfo()
    {
        $message = $this->message;

        $wordsArray = $this->finder('FS\InfoText:InfoText')->fetch();

        if (count($wordsArray) > 0) {

            foreach ($wordsArray as $value) {
                $message = str_replace($value->word, '[fsinfotext=' . $value->link . ']' . $value->word . '[/fsinfotext]', $message);
            }
        }
        return $message;
    }
}
