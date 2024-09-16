<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Entity;

class ProductPrefix extends XFCP_ProductPrefix
{
    protected function _postDelete()
    {
        parent::_postDelete();

        $this->db()->delete('xf_sv_dbtech_ecommerce_product_prefix_link', 'prefix_id = ?', $this->prefix_id);
    }
}