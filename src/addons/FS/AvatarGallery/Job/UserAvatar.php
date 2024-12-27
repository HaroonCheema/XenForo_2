<?php

namespace FS\AvatarGallery\Job;

use XF\Finder\ConversationUserFinder;
use XF\Finder\UserAlertFinder;
use XF\Repository\ConnectedAccountRepository;
use XF\Job\AbstractRebuildJob;

class UserAvatar extends AbstractRebuildJob
{

    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn($db->limit(
            "
				SELECT user_id
				FROM xf_user
				WHERE user_id > ?
				ORDER BY user_id
			",
            $batch
        ), $start);
    }

    protected function rebuildById($id)
    {

        $tmp = tempnam(\xf::options()->fs_change_the_path_to_the_tmp_file, 'php');
        $avatarType = $this->data['type'];

        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        if (!count($files)) {

            return;
        }

        /** @var \XF\Entity\User $user */
        $user = $this->app->em()->find('XF:User', $id, ['Profile']);

        if (!$user) {
            return;
        }

        $randomAvatars = \xf::app()->service('FS\AvatarGallery:AvatarGallery');

        $gallery_avatar = $randomAvatars->getRandomAvatar();

        if ($avatarType == 1) {

            $this->changeAvatar($user, $gallery_avatar, $tmp);
        }

        if ($avatarType == 2 && !$user->avatar_date) {

            $this->changeAvatar($user, $gallery_avatar, $tmp);
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('users');
    }

    public function changeAvatar($user, $gallery_avatar, $tmp)
    {

        if (\XF::app()->fs()->has('data://' . $gallery_avatar)) {

            $image = \XF::app()->applyExternalDataUrl($gallery_avatar, true);

            $data = \XF::app()->fs()->readStream('data://' . $gallery_avatar);

            file_put_contents($tmp, $data);

            $avatarService = \xf::app()->service('XF:User\Avatar', $user);

            $avatarService->setImage($tmp);
            $avatarService->updateAvatar();

            //            unlink($tmp);
        }
    }
}
