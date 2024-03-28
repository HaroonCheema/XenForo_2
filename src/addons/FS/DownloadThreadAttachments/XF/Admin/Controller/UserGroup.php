<?php

namespace FS\DownloadThreadAttachments\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class UserGroup extends XFCP_UserGroup
{         
        
    protected function userGroupSaveProcess(\XF\Entity\UserGroup $userGroup)
    {
        $form = parent::userGroupSaveProcess($userGroup);

        $inputData = $this->filter([
            'download_size_limit'     => 'uint',
            'daily_download_size_limit'     => 'uint',
            'weekly_download_size_limit'    => 'uint',
        ]);
       

        $form->setup(function() use ($userGroup, $inputData)
        {
            $userGroup->download_size_limit     = $inputData['download_size_limit'];
            $userGroup->daily_download_size_limit     = $inputData['daily_download_size_limit'];
            $userGroup->weekly_download_size_limit   = $inputData['weekly_download_size_limit'];
        });

        return $form;
    }
	
}