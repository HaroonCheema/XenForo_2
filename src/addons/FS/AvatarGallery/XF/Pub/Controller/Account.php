<?php

namespace FS\AvatarGallery\XF\Pub\Controller;

use XF\Service\User\AvatarService;

class Account extends XFCP_Account
{
    public function actionAccountDetails()
    {
        $parent = parent::actionAccountDetails();

        $app = \xf::app();
        $user = \XF::visitor();
        $option = \xf::options();

        if ($this->isPost()) {

            if (!$user->user_id) {
                return $this->noPermission();
            }
            $gallery_avatar = $this->filter('gallery_avatar', 'str');
            $upload = $this->request->getFile('img_avatar', false, false);

            /** @var \XF\Service\User\Avatar $avatarService */
            $avatarService = $app->service('XF:User\Avatar', $user);
            if ($upload) {

                if (!$avatarService->setImageFromUpload($upload)) {
                    return $this->error($avatarService->getError());
                }

                if (!$avatarService->updateAvatar()) {
                    return $this->error(\XF::phrase('new_avatar_could_not_be_processed'));
                }
            } elseif (\XF::app()->fs()->has('data://' . $gallery_avatar)) {

                if (!$user->canUseRandomAvatar()) {
                    return $this->noPermission();
                }

                $tmp = tempnam($option->fs_change_the_path_to_the_tmp_file, 'php');
                $data = \XF::app()->fs()->readStream('data://' . $gallery_avatar);

                file_put_contents($tmp, $data);

                $avatarService = $this->service('XF:User\Avatar', $user);

                $avatarService->setImage($tmp);
                $avatarService->updateAvatar();

                unlink($tmp);

                $updateLimit = $user->random_avatar_limit + 1;

                $user->bulkSet([
                    'random_avatar_limit' => $updateLimit,
                ]);

                $user->save();
            }
        }
        return $parent;
    }

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

                    $avatarService = $this->service('XF:User\Avatar', $visitor);

                    // $avatarService = $this->service(AvatarService::class, $visitor);

                    $avatarService->setImage($tmp);
                    $avatarService->updateAvatar();

                    unlink($tmp);
                }
            }
        } else {
            $randomAvatarsServ = \xf::app()->service('FS\AvatarGallery:AvatarGallery');

            $reply->setParam('gallery_images', $randomAvatarsServ->getGalleryImagesAccount());
        }

        return $reply;
    }

    public function actionRandom()
    {
        $user = \XF::visitor();

        if (!$user->user_id) {
            return $this->noPermission();
        }

        if (!$user->canUseRandomAvatar()) {
            throw $this->exception($this->error(\XF::phrase('fs_avatar_gallery_random_limit_reached')));
        }

        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        if (!count($files)) {

            return;
        }

        $tmp = tempnam(\xf::options()->fs_change_the_path_to_the_tmp_file, 'php');

        $randomAvatars = \xf::app()->service('FS\AvatarGallery:AvatarGallery');

        $gallery_avatar = $randomAvatars->getRandomAvatar();

        $this->changeAvatar($user, $gallery_avatar, $tmp);

        $redirect = $this->getDynamicRedirect(null, true);

        $updateLimit = $user->random_avatar_limit + 1;

        $user->bulkSet([
            'random_avatar_limit' => $updateLimit,
        ]);

        $user->save();

        return $this->redirect($redirect);
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
