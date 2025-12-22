<?php

namespace EWR\Porta\Listener;

class UserManagement
{
    public static function userContentChangeInit(\XF\Service\User\ContentChange $changeService, array &$updates)
    {
		$updates['ewr_porta_authors'] = ['user_id'];
    }
	
    public static function userDeleteCleanInit(\XF\Service\User\DeleteCleanUp $deleteService, array &$deletes)
    {
		$deletes['ewr_porta_authors'] = 'user_id = ?';
    }
}