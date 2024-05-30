<?php

namespace FS\PackageRating\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class PackageRating extends AbstractController
{
    public function actionIndex()
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id) {

            return $this->noPermission();
        }

        $options = \XF::options();

        $ids = explode(',', $options->fs_pkg_rat_applicable_userGroups);

        $userUpgrades = $this->finder('XF:UserUpgrade')->where('user_upgrade_id', $ids)->fetch();

        if ($this->isPost()) {

            $input = $this->filterInputs();

            $insert = $this->finder('FS\PackageRating:PackageRating')->where('user_id', $visitor['user_id'])->where('user_upgrade_id', $input['userUpId'])->fetchOne();

            if (!$insert) {
                $insert = $this->em()->create('FS\PackageRating:PackageRating');
                $insert->user_upgrade_id = $input['userUpId'];
                $insert->user_id = $visitor['user_id'];
            }

            $insert->rating = $input['rating'];
            $insert->message = $input['message'];



            $insert->save();

            $this->saveImage($insert);

            return $this->redirect($this->buildLink('crud'));
        }

        $viewParams = [
            "userUpgrades" => count($userUpgrades) ? $userUpgrades : '',
        ];

        return $this->view('FS\PackageRating:PackageRating\Index', 'fs_package_rating_add', $viewParams);
    }

    protected function saveImage($rating)
    {
        $uploads['image'] = $this->request->getFile('image', false, false);

        if ($uploads['image']) {
            $uploadService = $this->service('FS\PackageRating:Upload', $rating);

            if (!$uploadService->setImageFromUpload($uploads['image'])) {
                return $this->error($uploadService->getError());
            }

            if (!$uploadService->uploadImage()) {
                return $this->error(\XF::phrase('new_image_could_not_be_processed'));
            }
        }
    }

    protected function filterInputs()
    {
        $input = $this->filter([
            'rating' => 'uint',
            'message' => 'str',
            'userUpId' => 'uint',
        ]);

        $uploads['image'] = $this->request->getFile('image', false, false);


        if ($input['rating'] < 1 || $input['rating'] > 5 || !strlen($input['message']) || $input['userUpId'] == 0 || !$uploads['image']) {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        return $input;
    }
}
