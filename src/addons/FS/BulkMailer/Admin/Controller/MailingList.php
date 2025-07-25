<?php

namespace FS\BulkMailer\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class MailingList extends AbstractController {

    public function actionIndex() {

        $mailingLists = $this->finder('FS\BulkMailer:MailingList')
                ->order('mailing_list_id', 'DESC')
                ->fetch();

        $viewParams = [
            'mailingLists' => $mailingLists
        ];

        return $this->view('FS\BulkMailer:List', 'fs_bulk_mailer_list', $viewParams);
    }

    public function actionAdd() {

        $userGroups = $this->repository('XF:UserGroup')->findUserGroupsForList()->fetch();

        $viewParams = [
            'userGroups' => $userGroups,
            'mailingList' => $this->em()->create('FS\BulkMailer:MailingList')
        ];

        return $this->view('FS\BulkMailer:Add', 'fs_bulk_mailer_edit', $viewParams);
    }

    public function actionEdit(ParameterBag $params) {

        $mailingList = $this->assertMailingListExists($params->mailing_list_id);
        $userGroups = $this->repository('XF:UserGroup')->findUserGroupsForList()->fetch();

        $viewParams = [
            'mailingList' => $mailingList,
            'userGroups' => $userGroups
        ];

        return $this->view('FS\BulkMailer:Edit', 'fs_bulk_mailer_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params) {
        $this->assertPostOnly();

        if ($params->mailing_list_id) {
            $mailingList = $this->assertMailingListExists($params->mailing_list_id);
            $oldUserGroups = $mailingList->usergroup_ids;
        } else {
            $mailingList = $this->em()->create('FS\BulkMailer:MailingList');
            $oldUserGroups = [];
        }

        $input = $this->filter([
            'title' => 'str',
            'subject' => 'str',
            'description' => 'str',
            'from_email' => 'str',
            'from_name' => 'str',
            'type' => 'uint',
            'usergroup_ids' => 'array-uint',
            'emails_per_hour' => 'uint',
            'active' => 'bool'
        ]);

        $editorPlugin = $this->plugin('XF:Editor');
        $input['description'] = $editorPlugin->fromInput('description');

        $this->validateMailingList($input, $mailingList);
        $mailingList->bulkSet($input);

        if ($input['type'] == 0) {
            $upload = $this->request->getFile('email_file');
            if ($upload && $upload->isValid()) {
                $filePathSave = \XF::$time . ".xlsx";
                $filePath = sprintf('data://email-lists/%s', $filePathSave);
                \XF\Util\File::copyFileToAbstractedPath($upload->getTempFile(), $filePath);
                $mailingList->file_path = $filePathSave;
            }
        } else {
            $mailingList->file_path = "";
        }

        $mailingList->save();

        if ($input['type'] == 0 && $upload && $mailingList->file_path) {
            
            $jobID = \xf::$time . "_mail_files";
            $this->app()->jobManager()->enqueueUnique($jobID, 'FS\BulkMailer:ProcessFile', [
                'mailing_list_id' => $mailingList->mailing_list_id
                    ], false);
         //   $this->app()->jobManager()->runUnique($jobID, 120);
            
            
        } else if ($input['type'] == 1 && $mailingList->usergroup_ids) {
            
            $shouldRunJob = false;

            if ($mailingList->isInsert()) {
                
                $shouldRunJob = true;
            } else if ($mailingList->isUpdate()) {
                
                // Check if usergroups have changed
                $newUserGroups = $mailingList->usergroup_ids;
                $diff = array_diff($newUserGroups, $oldUserGroups);
                if (!empty($diff)) {
                    $shouldRunJob = true;
                }
            }

            if ($shouldRunJob) {
                
                $jobID = \xf::$time . "_mail_usergroups";
                $this->app()->jobManager()->enqueueUnique($jobID, 'FS\BulkMailer:ProcessUserGroups', [
                    'mailing_list_id' => $mailingList->mailing_list_id
                        ], false);
            }
        }

        return $this->redirect($this->buildLink('mailing-lists'));
    }

    protected function validateMailingList(array $input, $mailingList) {
        $errors = [];

        if (empty($input['title'])) {
            throw $this->exception($this->error(\XF::phrase('please_enter_valid_title')));
        }

        if (empty($input['subject'])) {
            throw $this->exception($this->error(\XF::phrase('please_enter_valid_subject')));
        }

        if (empty($input['description'])) {
            throw $this->exception($this->error(\XF::phrase('please_enter_valid_description')));
        }

        if ($input['type'] == 1) {

            if (empty($input['usergroup_ids'])) {
                throw $this->exception($this->error(\XF::phrase('please_select_at_least_one_usergroup')));
            }
        } elseif (!$mailingList->file_path) {

            $upload = $this->request->getFile('email_file');

            if (!$mailingList->file_path) {
                if (!$upload || !$upload->isValid()) {
                    throw $this->exception($this->error(\XF::phrase('please_upload_valid_file')));
                }

                $allowedExtensions = ['xlsx', 'xls'];
                $extension = strtolower(pathinfo($upload->getFileName(), PATHINFO_EXTENSION));

                if (!in_array($extension, $allowedExtensions)) {
                    throw $this->exception($this->error(\XF::phrase('please_upload_valid_excel_file')));
                }
            }
        }
    }

    public function actionDelete(ParameterBag $params) {

        $mailingList = $this->assertMailingListExists($params->mailing_list_id);

        if ($this->isPost()) {

            \xf::db()->delete('xf_fs_mail_queue', 'mailing_list_id = ?', $mailingList->mailing_list_id);

            if ($mailingList->file_path) {
                \XF\Util\File::deleteFromAbstractedPath('data://email-lists/' . $mailingList->file_path);
            }
        }

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
                        $mailingList,
                        $this->buildLink('mailing-lists/delete', $mailingList),
                        $this->buildLink('mailing-lists/edit', $mailingList),
                        $this->buildLink('mailing-lists'),
                        $mailingList->title
                );
    }

    protected function assertMailingListExists($id) {
        $mailingList = $this->em()->find('FS\BulkMailer:MailingList', $id);
        if (!$mailingList) {
            throw $this->exception($this->notFound());
        }
        return $mailingList;
    }

    public function actionToggle() {
        
        /** @var \XF\ControllerPlugin\Toggle $plugin */
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle('FS\BulkMailer:MailingList');
    }

    public function actionQueueList(ParameterBag $params) {

        $mailingList = $this->assertMailingListExists($params->mailing_list_id);

        $page = $this->filterPage();
        $perPage = 50;

        $queueFinder = $this->finder('FS\BulkMailer:MailQueue')
                        ->where('mailing_list_id', $mailingList->mailing_list_id)->order('send_date', 'desc');

        $total = $queueFinder->total();
        $queueItems = $queueFinder->limitByPage($page, $perPage)->fetch();

        $viewParams = [
            'queueItems' => $queueItems,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'mailingList' => $mailingList,
        ];

        return $this->view('FS\BulkMailer:QueueList', 'fs_bulk_mailer_queue_list', $viewParams);
    }

    public function actionresend() {

        $queue_id = $this->filter('queue_id', 'int');

        $mailQueue = $this->finder('FS\BulkMailer:MailQueue')->where('queue_id', $queue_id)->fetchOne();

        if (!$mailQueue) {

            throw $this->exception($this->notFound());
        }

        if ($mailQueue->status == "sent") {

            throw $this->exception($this->error("Already Send....."));
        }

        $mailingList = $mailQueue->MailList;

        $mailSender = new \FS\BulkMailer\Service\MailSender(\XF::app());

        $sended = $mailSender->sendMail(\xf::app(), $mailQueue, $mailingList);

        if ($sended) {

            $mailQueue->status = 'sent';
            $mailQueue->send_date = time();
            $mailQueue->save();

            $mailingList->sent_emails++;
        } else {

            $mailQueue->status = 'failed';
            $mailQueue->send_date = time();
            $mailQueue->attempts++;
            $mailQueue->save();

            //$mailingList->failed_emails++;
        }

        $mailingList->save();

        return $this->redirect($this->buildLink('mailing-lists/' . $mailingList->mailing_list_id . "/queue-list"));
    }
}
