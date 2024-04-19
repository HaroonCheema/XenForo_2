<?php

namespace FS\InfoText\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Thread extends XFCP_Thread
{
    public function actionIndex(ParameterBag $params)
    {
        $parent = parent::actionIndex($params);

        if ($parent instanceof \XF\Mvc\Reply\View) {

            $wordsArray = $this->finder('FS\InfoText:InfoText')->fetch();

            $posts = $parent->getParam('posts');

            foreach ($posts as $post) {
                $message = $post->message;

                if (count($wordsArray) > 0) {

                    foreach ($wordsArray as $value) {
                        $message = str_replace($value->word, $value->word . ' ' . '[fsinfotext=' . $value->link . '](' . $value->agency . ')[/fsinfotext]', $message);
                        $post->message = $message;
                    }
                }
            }
        }

        return $parent;
    }
}
