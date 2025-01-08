<?php

namespace FS\ThreadMultiTag\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{

    public function rebuildThreadFieldValuesCache()
    {

        $customFields = $this->custom_fields_;

        $thread_multi_tag = \xf::options()->thread_multi_tag;

        $parent = parent::rebuildThreadFieldValuesCache();

        if (!isset($thread_multi_tag) || !isset($this->custom_fields_[$thread_multi_tag])  || $customFields[$thread_multi_tag] == "") {

            return $parent;
        }

        $threadTags = null;
        if (count($this->tags)) {

            $threadTags = array_column($this->tags, 'tag');
        }

        $multiTags = $customFields[$thread_multi_tag];

        $multiTags = $this->clearTags($multiTags);

        $tagger = \XF::service('XF:Tag\Changer', 'thread', $this);

        if (is_array($threadTags)) {

            $multiTags = array_merge(($threadTags), $multiTags);
        }
        $tagger->setEditableTags($multiTags);
        if ($tagger->hasErrors()) {
            return $this->error($tagger->getErrors());
        }

        $tagger->saveMultiTags();

        return $parent;
    }

    protected function clearTags($multiTags)
    {
        $step1 = str_replace(' ', '_', $multiTags);

        $step2 = preg_replace('/[^a-zA-Z0-9_\n]/', '', $step1);

        $result = explode("\n", $step2);

        return array_reverse($result);
    }
}
