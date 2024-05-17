<?php

namespace FS\DisableBbCodes\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Thread extends XFCP_Thread
{
    public function actionIndex(ParameterBag $params)
    {
        $parent = parent::actionIndex($params);

        if ($parent instanceof \XF\Mvc\Reply\View) {

            $customBbCodes = $this->finder('XF:BbCode')->where("usergroup_ids", "!=", '')->fetch();
            $builtInBbCodes = $this->finder('FS\DisableBbCodes:DisableBbCodes')->where("usergroup_ids", "!=", '')->fetch();

            if (count($customBbCodes) > 0) {

                $this->disabledBbCodes($parent->getParam('posts'), $customBbCodes);
            }

            if (count($builtInBbCodes) > 0) {

                $this->disabledBbCodes($parent->getParam('posts'), $builtInBbCodes);
            }
        }

        return $parent;
    }

    protected function disabledBbCodes($posts, $disBbCodes)
    {
        $visitor = \XF::visitor();

        $visitorGroupIds = $visitor->secondary_group_ids;

        $visitorGroupIds[] = $visitor->user_group_id;

        foreach ($disBbCodes as $bbCode) {

            $difGroupsIds = array_diff($visitorGroupIds, $bbCode->usergroup_ids);

            if (count($difGroupsIds) < 1) {

                foreach ($posts as $post) {
                    $message = $post->message;

                    $replacementString = \XF::phrase('fs_disable_bb_codes_phrase');

                    $pattern = '/\[(\w+)[^\]]*\].*?\[\/\1\]/';

                    preg_match_all($pattern, $message, $matches);

                    $tags = array_unique($matches[1]);

                    $tag = $bbCode->bb_code_id;

                    if (in_array($tag, $tags)) {
                        $patternWithoutTag = '/\[' . preg_quote($tag, '/') . '[^\]]*\].*?\[\/' . preg_quote($tag, '/') . '\]/';

                        $patternWithTag = '/\[' . $tag . '=[^\]]*\].*?\[\/' . $tag . '\]/';

                        $message = preg_replace($patternWithoutTag, $replacementString, $message);
                        $message = preg_replace($patternWithTag, $replacementString, $message);

                        $post->message = $message;
                    }
                }
            }
        }
    }
}
