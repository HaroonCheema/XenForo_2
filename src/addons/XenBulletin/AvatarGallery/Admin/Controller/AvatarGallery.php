<?php

namespace XenBulletin\AvatarGallery\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XenBulletin\AvatarGallery\Entity;
use XF\Mvc\ParameterBag;


class AvatarGallery extends AbstractController
{


    public function actionIndex()
    {
        $page = $this->filterPage();
        $perPage = 10;

        $avatars = $this->Finder('XenBulletin\AvatarGallery:AvatarGallery');

        $total = $avatars->total();
        $this->assertValidPage($page, $perPage, $total, 'ag');
        $avatars->limitByPage($page, $perPage);

        $viewParams = [

            'avatars' => $avatars->order('img_id', 'DESC')->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $total
        ];
        return $this->view('XenBulletin\AvatarGallery:AvatarGallery', 'xb_avatar_gallery', $viewParams);
    }

    public function actionAdd()
    {
        $avatar = $this->em()->create('XenBulletin\AvatarGallery:AvatarGallery');

        $viewParams = [
            'avatar' => $avatar
        ];

        return $this->view('XenBulletin\AvatarGallery:AvatarGallery\Add', 'xb_avatar_gallery_edit', $viewParams);
    }

    //************************Save avatar**********************************************
    protected function avatarSaveProcess(\XenBulletin\AvatarGallery\Entity\AvatarGallery $avatar)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'img_path' => 'STR'
        ]);

        $form->basicEntitySave($avatar, $input);
        return $form;
    }

    public function actionSave(ParameterBag $params)
    {

        $avatar = $this->em()->create('XenBulletin\AvatarGallery:AvatarGallery');

        if ($this->isPost()) {
            $upload = $this->request->getFile('img_path', false, false);

            if ($upload) {
                $uploadService = $this->service('XenBulletin\AvatarGallery:Upload', $avatar);

                if (!$uploadService->setImageFromUpload($upload)) {

                    return $this->error($uploadService->getError());
                }
            }
        }

        $this->avatarSaveProcess($avatar)->run();

        if ($this->isPost()) {
            if ($upload) {
                if (!$uploadService->uploadAvatarImage()) {
                    return $this->error(\XF::phrase('new_image_could_not_be_processed'));
                }
            }
        }

        return $this->redirect($this->buildLink('ag'));
    }

    //*******************Delete avatar**************************************************

    public function actionDelete(ParameterBag $params)
    {

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

            return $this->view('', 'xb_avatar_gallery_delete', $viewParams);
        }
    }

    public function getAbstractAvatrImgPath($imgId)
    {
        return sprintf('/data/gallery_avatars/%d.jpg', $imgId);
    }

    protected function assertFunctionExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('XenBulletin\AvatarGallery:AvatarGallery', $id, $with, $phraseKey);
    }
}
