<?php

namespace FS\SendMailFromTable\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class EmailTemplate extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\SendMailFromTable:EmailTemplates')->order('id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'emailTemplates' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
        ];

        return $this->view('FS\SendMailFromTable:EmailTemplate\Index', 'fs_email_template_index', $viewParams);
    }

    public function actionAdd()
    {
        $newEmailTemplate = $this->em()->create('FS\SendMailFromTable:EmailTemplates');
        return $this->emailTemplateAddEdit($newEmailTemplate);
    }

    public function actionEdit(ParameterBag $params)
    {
        /**
     
         * @var \FS\SendMailFromTable\Entity\EmailTemplates $emailTemplate
         */
        $emailTemplate = $this->assertDataExists($params->id);
        return $this->emailTemplateAddEdit($emailTemplate);
    }

    protected function emailTemplateAddEdit(\FS\SendMailFromTable\Entity\EmailTemplates $emailTemplate)
    {
        $viewParams = [
            'tempData' => $emailTemplate
        ];

        return $this->view('FS\SendMailFromTable:EmailTemplate\Add', 'fs_email_template_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $emailTemplateEditAdd = $this->assertDataExists($params->id);
        } else {
            $emailTemplateEditAdd = $this->em()->create('FS\SendMailFromTable:EmailTemplates');
        }

        $this->emailTemplateSaveProcess($emailTemplateEditAdd)->run();

        return $this->redirect($this->buildLink('email-template'));
    }

    protected function emailTemplateSaveProcess(\FS\SendMailFromTable\Entity\EmailTemplates $emailTemplate)
    {
        $input = $this->filter([
            'title' => 'str',
            'email_body' => 'str'
        ]);

        if ($input['title'] == '' || $input['email_body'] == '') {
            throw $this->exception($this->error(\XF::phrase('please_complete_required_fields')));
        }

        $form = $this->formAction();
        $form->basicEntitySave($emailTemplate, $input);

        return $form;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('email-template/delete', $replyExists),
            null,
            $this->buildLink('email-template'),
            "{$replyExists->title}"
        );
    }

    // plugin for check id exists or not 

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\SendMailFromTable\Entity\EmailTemplates
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\SendMailFromTable:EmailTemplates', $id, $extraWith, $phraseKey);
    }
}
