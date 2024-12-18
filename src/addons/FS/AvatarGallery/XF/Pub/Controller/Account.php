<?php

namespace FS\AvatarGallery\XF\Pub\Controller;

use XF\Service\User\AvatarService;

class Account extends XFCP_Account
{
    public function actionAvatar()
    {

        $reply = parent::actionAvatar();

        if ($this->isPost()) {

            if ($this->filter('delete_avatar', 'bool')) {
                return $reply;
            }
        }

        if (!$this->options()->fs_enable) {
            return $reply;
        }

        if ($this->options()->fs_use_random) {
            return $reply;
        }

        if ($this->isPost()) {

            $isAiImg = $this->filter('ai_img', 'int');

            if ($isAiImg) {

                $app = \xf::app();
                $avatarUrl = $this->filter('gallery_avatar', 'str');

                if (!$avatarUrl) {

                    throw $this->exception(
                        $this->error(\XF::phrase('ai_img_url_must_required'))
                    );
                }

                $visitor = \XF::visitor();

                $tempFile = \XF\Util\File::getTempFile();

                $app->http()->reader()->getUntrusted($avatarUrl, [], $tempFile);
                if ($app->http()->reader()->getUntrusted($avatarUrl, [], $tempFile)) {
                    /** @var \XF\Service\User\Avatar $avatarService */
                    $avatarService = $app->service('XF:User\Avatar', $visitor);
                    if (!$avatarService->setImage($tempFile)) {

                        throw $this->exception(
                            $this->error(\XF::phrase('some_thing_went_wrong_for_img_ai'))
                        );
                    }

                    $avatarService->updateAvatar();
                }

                return $reply;
            }

            if ($gallery_avatar = $this->filter('gallery_avatar', 'str')) {

                if (\XF::app()->fs()->has('data://' . $gallery_avatar)) {

                    $tmp = tempnam($this->options()->fs_change_the_path_to_the_tmp_file, 'php');
                    $data = \XF::app()->fs()->readStream('data://' . $gallery_avatar);

                    file_put_contents($tmp, $data);

                    $visitor = \XF::visitor();

                    // $avatarService = $this->service('XF:User\Avatar', $visitor);

                    $avatarService = $this->service(AvatarService::class, $visitor);

                    $avatarService->setImage($tmp);
                    $avatarService->updateAvatar();

                    unlink($tmp);
                }
            }
        } else {
            $reply->setParam('gallery_images', $this->getGalleryImages());
        }

        return $reply;
    }

    private function getGalleryImages()
    {

        $valid_extensions = [
            'jpg',
            'jpeg',
            'gif',
            'png'
        ];

        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        $formatted = [];
        $visitor = \XF::visitor();
        $userGroup = $visitor->user_group_id;
        $secondaryUserGroup = $visitor->secondary_group_ids;
        foreach ($files as $file) {
            $category = preg_replace('/gallery_avatars\/?/', '', $file['dirname']);

            if (empty($category)) {
                $category = \XF::phrase('fs_uncategorized')->render();
            }
            if ($file['type'] === 'file' && in_array(strtolower($file['extension']), $valid_extensions)) {
                $permission = '';
                if ($permission == null) {
                    $formatted[$category]['permission'] = '2';
                } else {
                    $formatted[$category]['permission'] = false;
                    if (in_array($userGroup, $permission['permission_category'])) {
                        $formatted[$category]['permission'] = true;
                    }
                    foreach ($secondaryUserGroup as $Goup) {
                        if (in_array($Goup, $permission['permission_category'])) {
                            $formatted[$category]['permission'] = true;
                        }
                    }
                }
                $formatted[$category]['dirname'][] = [
                    'url' => $this->app()->applyExternalDataUrl($file['path']),
                    'data-path' => $file['path']
                ];
            }
        }
        ksort($formatted);
        return $formatted;
    }

    public function actionRandom()
    {
        $user = \XF::visitor();

        if (!$user->user_id) {
            return $this->noPermission();
        }

        if (!$user->canUseRandomAvatar()) {
            return $this->noPermission();
        }

        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        if (!count($files)) {

            return;
        }

        $tmp = tempnam(\xf::options()->fs_change_the_path_to_the_tmp_file, 'php');

        $gallery_avatar = $this->getRandomAvatar($files);

        $this->changeAvatar($user, $gallery_avatar, $tmp);

        $redirect = $this->getDynamicRedirect(null, true);

        $updateLimit = $user->random_avatar_limit + 1;

        $user->bulkSet([
            'random_avatar_limit' => $updateLimit,
        ]);

        $user->save();

        return $this->redirect($redirect);
    }

    public function getRandomAvatar($files)
    {
        $randomKey = array_rand($files);

        $filesCount = $randomKey + 1;

        if ($filesCount == count($files)) {
            $randomKey = 0;
        }

        return $files[$randomKey]['path'];
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
