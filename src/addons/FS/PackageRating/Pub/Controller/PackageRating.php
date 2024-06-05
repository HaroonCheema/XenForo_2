<?php

namespace FS\PackageRating\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class PackageRating extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\PackageRating:PackageRating');

        $finder->order('rating_id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'reviews' => $finder->fetch(),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
            'totalReturn' => count($finder->fetch()),
        ];

        return $this->view('FS\PackageRating:PackageRating\Index', 'fs_rating_reviews_all', $viewParams);
    }

    public function actionReply(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->rating_id);

        if (!\XF::visitor()->is_admin) {
            return $this->noPermission();
        }

        $message = $this->filter('message', 'str');

        if (!empty($message)) {
            $replyExists->fastUpdate('author_response', $message);
        }

        // echo "<pre>";
        // var_dump($message);
        // exit;

        return $this->redirect($this->buildLink('package-rating'));
    }

    public function actionAdd()
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

            return $this->redirect($this->buildLink('package-rating'));
        }

        $viewParams = [
            "userUpgrades" => count($userUpgrades) ? $userUpgrades : '',
        ];

        return $this->view('FS\PackageRating:PackageRating\Add', 'fs_package_rating_add', $viewParams);
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

        if ($input['rating'] < 1 || $input['rating'] > 5 || !strlen($input['message']) || $input['userUpId'] == 0) {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        return $input;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->rating_id);

        if (!(\XF::visitor()->is_admin || \XF::visitor()->user_id == $replyExists->user_id)) {
            return $this->noPermission();
        }

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('package-rating/delete', $replyExists),
            null,
            $this->buildLink('package-rating'),
            "{$replyExists->Upgrade->title}"
        );
    }

    public function actionReplyDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->rating_id);

        if (!\XF::visitor()->is_admin) {
            return $this->noPermission();
        }

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('package-rating/delete', $replyExists),
            null,
            $this->buildLink('package-rating'),
            "{$replyExists->Upgrade->title}"
        );
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\PackageRating\Entity\PackageRating
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\PackageRating:PackageRating', $id, $extraWith, $phraseKey);
    }
}
