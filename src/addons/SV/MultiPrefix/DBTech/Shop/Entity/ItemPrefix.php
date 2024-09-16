<?php

namespace SV\MultiPrefix\DBTech\Shop\Entity;

class ItemPrefix extends XFCP_ItemPrefix
{
    protected function _postDelete()
    {
        parent::_postDelete();

        $this->db()->delete('xf_sv_dbtech_shop_item_prefix_link', 'prefix_id = ?', $this->prefix_id);
    }
}