<?php

namespace XenGenTr\XGTCoreLibrary\XF\Admin\Controller;

class Category extends XFCP_Category
{
    protected function nodeSaveProcess(\XF\Entity\Node $node)
    {
        $faicon = $this->filter(['node' => ['xgt_style_fa_ikon' => 'str'] ]);

        $formAction = parent::nodeSaveProcess($node);

        $formAction->setup(function() use ($node, $faicon)
        {
            $node->xgt_style_fa_ikon =    $faicon['node']['xgt_style_fa_ikon'];
  
        });

        return $formAction;
    }
}