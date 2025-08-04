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


    protected function prepareEmailData()
    {

        $email = $this->filter([
            'list_only' => 'bool',
            'from_name' => 'str',
            'from_email' => 'str',

            'email_title' => 'str',
            'email_format' => 'str',
            'email_body' => 'str',
            'email_wrapped' => 'bool',
            'email_unsub' => 'bool'
        ]);

        $data = $this->plugin('XF:UserCriteriaAction')->getInitializedSearchData([
            'no_empty_email' => true
        ]);

        if (!$data['criteria']['email_template']) {
            return parent::prepareEmailData();
        }

        $emailTemplate = \xf::app()->em()->find('FS\SendMailFromTable:EmailTemplates', $data['criteria']['email_template']);

        if (!$emailTemplate) {
            return parent::prepareEmailData();
        }

        $email['email_title'] = $emailTemplate->title;
        $email['email_body'] = $emailTemplate->email_body;
        $email['email_format'] = "html";

        if (!$email['list_only'] && (!$email['from_name'] || !$email['from_email'] || !$email['email_title'] || !$email['email_body'])) {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        if (strpos($email['email_body'], '{unsub}') !== false) {
            $email['email_unsub'] = false;
        }

        $data['email'] = $email;

        return $data;
    }
}
