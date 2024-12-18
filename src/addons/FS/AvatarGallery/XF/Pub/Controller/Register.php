<?php

namespace FS\AvatarGallery\XF\Pub\Controller;

use XF\Service\User\AvatarService;

class Register extends XFCP_Register {

    public function actionIndex() {
        if (\XF::visitor()->user_id) {
            return $this->redirect($this->getDynamicRedirectIfNot($this->buildLink('register')), '');
        }

        $parent = parent::actionIndex();
        if ($parent instanceof \XF\Mvc\Reply\View) {
            $option = \xf::options();

            if ($option->fs_enable) {
                $parent->setParam('gallery_images', $this->getGalleryImages());
                return $parent;
            }

            $parent->setParam('gallery_images', false);
        }

        return $parent;
    }

    private function getGalleryImages() {
        $valid_extensions = [
            'jpg',
            'jpeg',
            'gif',
            'png'
        ];

        $files = \XF::app()->fs()->listContents('data://gallery_avatars', true);

        $formatted = [];

        foreach ($files as $file) {
            $category = preg_replace('/gallery_avatars\/?/', '', $file['dirname']);

            if (empty($category)) {
                $category = \XF::phrase('fs_uncategorized')->render();
            }

            if ($file['type'] === 'file' && in_array(strtolower($file['extension']), $valid_extensions)) {
                $formatted[$category][] = [
                    'url' => $this->app()->applyExternalDataUrl($file['path']),
                    'data-path' => $file['path']
                ];
            }
        }

        ksort($formatted);

        return $formatted;
    }

    public function actionRegister() {
        $option = \xf::options();
//        $avatarInput = $this->request->filter('gallery_avatar', 'str');
//        if (
//                !$avatarInput &&
//                $option->fs_enable
//        ) {
//            return $this->error(\XF::phrase('fs_required_error'));
//        }

        return parent::actionRegister();
    }

    protected function finalizeRegistration(\XF\Entity\User $user) {
        $parent = parent::finalizeRegistration($user);
        $option = \xf::options();
        if ($option->fs_enable) {

            $gallery_avatar = $this->filter('gallery_avatar', 'str');

            $upload = $this->request->getFile('img_avatar', false, false);

            $avatarService = $this->service(AvatarService::class, $user);
            if ($upload) {

                if (!$avatarService->setImageFromUpload($upload)) {
                    return $this->error($avatarService->getError());
                }

                if (!$avatarService->updateAvatar()) {
                    return $this->error(\XF::phrase('new_avatar_could_not_be_processed'));
                }

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
