<?php

namespace XenGenTr\XGTForumistatistik\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class Option extends XFCP_Option
{
    public function actionGroup(ParameterBag $params)
    {
        if ($params->group_id === 'xgtForumistatistik_Secenekleri') 
        {
            $this->setSectionContext('xgt_forumistatistik');
        }

        return parent::actionGroup($params);
    }
}