<?php

namespace FS\MapEmails\XF\Admin\Controller;

class User extends XFCP_User
{
    public function actionEmail()
    {
        $parent = parent::actionEmail();

        $emailTemplates = $this->finder('FS\SendMailFromTable:EmailTemplates')->order('id', 'DESC')->fetch();

        $parent->setParam('emailTemplates', $emailTemplates);

        return $parent;
    }

    public function actionEmailSend()
    {
        $parent = parent::actionEmail();

        $this->setSectionContext('emailUsers');

        $this->assertPostOnly();

        $data = $this->prepareEmailData();

        if (!$data['criteria']['email_template']) {
            return $parent;
        }

        $emailTemplate = \xf::app()->em()->find('FS\SendMailFromTable:EmailTemplates', $data['criteria']['email_template']);

        if (!$emailTemplate) {
            return $parent;
        }

        $data['email']['email_title'] = $emailTemplate->title;
        $data['email']['email_body'] = $emailTemplate->email_body;
        $data['email']['email_format'] = "html";

        if ($this->filter('test', 'bool')) {
            $this->app->job('XF:UserEmail', null, [
                'userIds' => [\XF::visitor()->user_id],
                'email' => $data['email']
            ])->run(0);

            $this->request->set('tested', '1');

            return $this->rerouteController(__CLASS__, 'emailConfirm');
        }

        $this->app->jobManager()->enqueueUnique('userEmailSend', 'XF:UserEmail', [
            'criteria' => $data['criteria'],
            'email' => $data['email']
        ]);

        return $this->redirect($this->buildLink(
            'users/email',
            null,
            ['sent' => $data['total']]
        ));
    }
}
