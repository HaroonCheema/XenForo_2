<?php

namespace FS\AvatarGallery\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use FS\AvatarGallery\Entity;
use XF\Mvc\ParameterBag;

class AvatarGallery extends AbstractController {

    public function actionIndex() {
        $page = $this->filterPage();
        $perPage = 10;

        $avatars = $this->Finder('FS\AvatarGallery:AvatarGallery');

        $total = $avatars->total();
        $this->assertValidPage($page, $perPage, $total, 'ag');
        $avatars->limitByPage($page, $perPage);

        $viewParams = [
            'avatars' => $avatars->order('img_id', 'DESC')->fetch(),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total
        ];
        return $this->view('FS\AvatarGallery:AvatarGallery', 'fs_avatar_gallery', $viewParams);
    }

    public function actionAdd() {
        $avatar = $this->em()->create('FS\AvatarGallery:AvatarGallery');

        $viewParams = [
            'avatar' => $avatar
        ];

        return $this->view('FS\AvatarGallery:AvatarGallery\Add', 'fs_avatar_gallery_edit', $viewParams);
    }

    protected function avatarSaveProcess(\FS\AvatarGallery\Entity\AvatarGallery $avatar) {
        $form = $this->formAction();

        $input = $this->filter([
            'img_path' => 'STR'
        ]);

        $form->basicEntitySave($avatar, $input);
        return $form;
    }

    public function actionSave(ParameterBag $params) {



        if ($this->isPost()) {

            $uploads = $this->request->getFile('img_path', true, false);

            if (count($uploads)) {

                foreach ($uploads as $upload) {

                    $avatar = $this->em()->create('FS\AvatarGallery:AvatarGallery');

                    $uploadService = $this->service('FS\AvatarGallery:Upload', $avatar);

                    if (!$uploadService->setImageFromUpload($upload)) {

                        return $this->error($uploadService->getError());
                    }
                    
                    $this->avatarSaveProcess($avatar)->run();

                    if (!$uploadService->uploadAvatarImage()) {


                        return $this->error(\XF::phrase('new_image_could_not_be_processed'));
                    }



                    
                }
            }
        }



        return $this->redirect($this->buildLink('ag'));
    }

    public function actionQuickDelete() {

        $this->assertPostOnly();

        $img_ids = $this->filter('img_ids', 'array-uint');

        $avatar_ids = $this->filter('avatar_ids', 'str');

        if ($avatar_ids) {

            $avatar_ids = explode(",", $avatar_ids);
        }


        if ($this->isPost() && $avatar_ids) {
            $avatars = $this->Finder('FS\AvatarGallery:AvatarGallery')->where('img_id', $avatar_ids)->fetch();

            foreach ($avatars as $avatar) {
                $avatar->delete();
                $path = \XF::getRootDirectory() . $this->getAbstractAvatrImgPath($avatar->img_id);
                if (file_exists($path)) {
                    $this->App()->fs()->delete($avatar->getAbstractedCustomAvatartImgPath());
                }
            }

            return $this->redirect($this->buildLink('ag'));
        } else {

            $viewParams = [
                'images' => $this->Finder('FS\AvatarGallery:AvatarGallery')->where('img_id', $img_ids)->fetch(),
                'img_ids' => implode(",", $img_ids),
            ];

            return $this->view('FS\AvatarGallery:QuickSet', 'quick_delete_imgs', $viewParams);
        }
    }

    public function actionDelete(ParameterBag $params) {

        $avatar = $this->assertFunctionExists($params->img_id);

        if ($this->isPost()) {

            if ($avatar) {
                $avatar->delete();
                $path = \XF::getRootDirectory() . $this->getAbstractAvatrImgPath($params->img_id);
                if (file_exists($path)) {
                    $this->App()->fs()->delete($avatar->getAbstractedCustomAvatartImgPath());
                }
            }

            return $this->redirect($this->buildLink('ag'));
        } else {
            $viewParams = [
                'avatar' => $avatar
            ];

            return $this->view('', 'fs_avatar_gallery_delete', $viewParams);
        }
    }

    public function getAbstractAvatrImgPath($imgId) {
        return sprintf('/data/gallery_avatars/%d.jpg', $imgId);
    }

    protected function assertFunctionExists($id, $with = null, $phraseKey = null) {
        return $this->assertRecordExists('FS\AvatarGallery:AvatarGallery', $id, $with, $phraseKey);
    }
}
