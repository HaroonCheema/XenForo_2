<?php

namespace FS\AvatarGallery\XF\Pub\Controller;

class Register extends XFCP_Register
{

    public function actionIndex()
    {
        if (\XF::visitor()->user_id) {
            return $this->redirect($this->getDynamicRedirectIfNot($this->buildLink('register')), '');
        }

        $parent = parent::actionIndex();
        if ($parent instanceof \XF\Mvc\Reply\View) {
            $option = \xf::options();
            $randomAvatarsServ = \xf::app()->service('FS\AvatarGallery:AvatarGallery');

            if ($option->fs_use_random) {

                $parent->setParam('random_avatar', $randomAvatarsServ->getRandomAvatars());
                return $parent;
            } elseif ($option->fs_enable) {

                $parent->setParam('gallery_images', $randomAvatarsServ->getGalleryImagesRegister());
                return $parent;
            }

            $parent->setParam('gallery_images', false);
        }

        return $parent;
    }

    public function actionRandomAvatar()
    {
        $randomAvatars = \xf::app()->service('FS\AvatarGallery:AvatarGallery');

        $viewParams = $randomAvatars->getRandomAvatars();

        $this->setResponseType('json');
        $view = $this->view();
        $view->setJsonParam('randomImage', $viewParams);
        return $view;

        return $randomImage;
    }

    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $parent = parent::finalizeRegistration($user);
        $option = \xf::options();
        $app = \xf::app();
        if ($option->fs_enable || $option->fs_use_random) {

            $gallery_avatar = $this->filter('gallery_avatar', 'str');

            $upload = $this->request->getFile('img_avatar', false, false);

            /** @var \XF\Service\User\Avatar $avatarService */
            $avatarService = $app->service('XF:User\Avatar', $user);
            // $avatarService = $this->service(Avatar::class, $user);
            if ($upload) {

                if (!$avatarService->setImageFromUpload($upload)) {
                    return $this->error($avatarService->getError());
                }

                if (!$avatarService->updateAvatar()) {
                    return $this->error(\XF::phrase('new_avatar_could_not_be_processed'));
                }

                // $randomAvatarLimit = $this->request->filter('fs_random_avatar_limit', 'uint');

                // if ($randomAvatarLimit) {
                //     $user->fastUpdate('random_avatar_limit', $randomAvatarLimit);
                // }

                return $parent;
            }
            if (!$gallery_avatar) {

                $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

                if (count($files)) {


                    $randomKey = array_rand($files);
                    $gallery_avatar = $files[$randomKey]['path'];
                }
            }
            if (\XF::app()->fs()->has('data://' . $gallery_avatar)) {
                $tmp = tempnam($option->fs_change_the_path_to_the_tmp_file, 'php');
                $data = \XF::app()->fs()->readStream('data://' . $gallery_avatar);

                file_put_contents($tmp, $data);

                $avatarService = $this->service('XF:User\Avatar', $user);

                $avatarService->setImage($tmp);
                $avatarService->updateAvatar();

                unlink($tmp);
            }
        }
    }
}
