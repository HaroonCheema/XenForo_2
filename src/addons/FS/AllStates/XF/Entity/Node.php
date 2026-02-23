<?php

namespace FS\AllStates\XF\Entity;

use XF\Mvc\Entity\Structure;

class Node extends XFCP_Node
{
    public function getStateIcon()
    {
        $icon = 'data://stateIcons/' . $this->node_id . '.jpg';

        if (\XF\Util\File::abstractedPathExists($icon)) {
            return $this->app()->applyExternalDataUrl('stateIcons/' . $this->node_id . '.jpg?' . (time() + rand(1, 9999)), true);
        }

        return;
    }

    // protected function _preSave()
    // {
    //     $parent = parent::_preSave();

    //     $this->icon_time = \XF::$time;

    //     return $parent;
    // }

    protected function _postSave()
    {
        if ($upload = \xf::app()->request->getFile('stateIcon', false, false)) {
            \xf::app()->repository('FS\AllStates:Node')->setIconFromUpload($this, $upload);
        }
    }

    protected function _postDelete()
    {
        $parent = parent::_postDelete();

        \XF\Util\File::deleteFromAbstractedPath('data://stateIcons/' . $this->node_id . '.jpg');

        return $parent;
    }
}
