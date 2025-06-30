<?php

namespace FS\Limitations\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['daily_discussion_count']     = ['type' => self::UINT, 'max' => 65535, 'default' => 0];
        $structure->columns['conversation_message_count'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['daily_ads'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['daily_repost'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['last_repost'] = ['type' => self::UINT, 'default' => \XF::$time];
        // $structure->columns['media_storage_size']         = ['type' => self::UINT, 'default' => 0, 'max' => PHP_INT_MAX];


        return $structure;
    }

    // public function getPermissionCombinationId()
    // {
    // 	if($this->account_type==1)
    // 	{
    // 	return $this->getValue('permission_combination_id');
    // 	}
    //     return ($this->user_id && $this->user_state == 'moderated' && $this->user_group_id == 16)
    //         ? $this->getValue('permission_combination_id')
    //         : \XF\Repository\User::$guestPermissionCombinationId;


    //     return $this->user_state == 'valid'
    //         ? $this->getValue('permission_combination_id')
    //         : \XF\Repository\User::$guestPermissionCombinationId;
    // }

    public function getAdsAllowed()
    {
        $user_group_ids = $this->secondary_group_ids;
        $user_group_ids[] = $this->user_group_id;

        if ($this->account_type == 2) {
            if (in_array(10, $user_group_ids) || in_array(12, $user_group_ids)) {
                return true;
            }
        }
        return false;
    }

    public function getCheckPrivateReviews()
    {
        $user_group_ids = $this->secondary_group_ids;
        $user_group_ids[] = $this->user_group_id;

        if ($this->account_type == 1) {
            if (in_array(6, $user_group_ids) && (count($user_group_ids) == 1)) {
                return true;
            }
        }

        if ($this->account_type == 2) {
            $applyOnGroups = [5, 7];
            $groupsAnother = array_diff($user_group_ids, $applyOnGroups);

            if (count($groupsAnother) == 0) {
                return true;
            }
        }

        return false;
    }

    public function getLeftBoxes($total)
    {

        $emptyBoxesArr = array();

        $len = 20 - $total;

        for ($i = 0; $i < $len; $i++) {
            array_push($emptyBoxesArr, ($i + 1));
        }

        return $emptyBoxesArr;
    }
}
