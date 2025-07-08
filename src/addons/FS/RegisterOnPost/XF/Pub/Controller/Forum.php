<?php

namespace FS\RegisterOnPost\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
    public function actionPostThread(ParameterBag $params)
    {
        if (!$params->node_id && !$params->node_name) {
            return $this->rerouteController('XF:Forum', 'postThreadChooser');
        }

        $forum = $this->assertViewableForum($params->node_id ?: $params->node_name, ['DraftThreads|' . \XF::visitor()->user_id]);

        if (!$forum->canRegisterUsingPost()) {
            return parent::actionPostThread($params);
        }

        if ($this->isPost()) {

            $title = $this->filter('title', 'str');
            $message = $this->plugin('XF:Editor')->fromInput('message');

            if ($title === '') {
                throw $this->exception(
                    $this->error(\XF::phrase('please_enter_valid_title'))
                );
            } elseif ($message === '') {
                throw $this->exception(
                    $this->error(\XF::phrase('please_enter_valid_message'))
                );
            }

            $this->assertPostOnly();
            $this->assertRegistrationActive();

            /** @var \XF\Service\User\RegisterForm $regForm */
            $regForm = $this->service('XF:User\RegisterForm', $this->session());
            if (!$regForm->isValidRegistrationAttempt($this->request(), $error)) {
                // they failed something that a legit user shouldn't fail, redirect so the key is different
                $regForm->clearStateFromSession($this->session());
                return $this->redirect($this->buildLink('register'));
            }

            $privacyPolicyUrl = $this->app->container('privacyPolicyUrl');
            $tosUrl = $this->app->container('tosUrl');

            if (($privacyPolicyUrl || $tosUrl) && !$this->filter('accept', 'bool')) {
                if ($privacyPolicyUrl && $tosUrl) {
                    return $this->error(\XF::phrase('please_read_and_accept_our_terms_and_privacy_policy_before_continuing'));
                } else if ($tosUrl) {
                    return $this->error(\XF::phrase('please_read_and_accept_our_terms_and_rules_before_continuing'));
                } else {
                    return $this->error(\XF::phrase('please_read_and_accept_our_privacy_policy_before_continuing'));
                }
            }

            // if (!$this->captchaIsValid()) {
            //     return $this->error(\XF::phrase('did_not_complete_the_captcha_verification_properly'));
            // }

            $input = $this->getRegistrationInput($regForm);

            $registration = $this->setupRegistration($input);
            $registration->checkForSpam();

            if (!$registration->validate($errors)) {
                return $this->error($errors);
            }

            $user = $registration->save();

            $preRegContent = $registration->getPreRegContent();
            if ($preRegContent instanceof \XF\Entity\LinkableInterface) {
                $this->session()->preRegContentUrl = $preRegContent->getContentUrl();
            }

            $this->finalizeRegistration($user);

            $parent =  parent::actionPostThread($params);

            return $parent;
        } else {
            /** @var \XF\Service\User\RegisterForm $regForm */
            $regForm = $this->service('XF:User\RegisterForm');
            $regForm->saveStateToSession($this->session());
            $parent =  parent::actionPostThread($params);

            $parent->setParam('regForm', $regForm);
        }

        return $parent;
    }

    protected function createNewUser()
    {
        $this->assertPostOnly();
        $this->assertRegistrationActive();

        /** @var \XF\Service\User\RegisterForm $regForm */
        $regForm = $this->service('XF:User\RegisterForm', $this->session());
        // if (!$regForm->isValidRegistrationAttempt($this->request(), $error)) {
        //     // they failed something that a legit user shouldn't fail, redirect so the key is different
        //     $regForm->clearStateFromSession($this->session());
        //     return $this->redirect($this->buildLink('register'));
        // }

        $privacyPolicyUrl = $this->app->container('privacyPolicyUrl');
        $tosUrl = $this->app->container('tosUrl');

        // if (($privacyPolicyUrl || $tosUrl) && !$this->filter('accept', 'bool')) {
        //     if ($privacyPolicyUrl && $tosUrl) {
        //         return $this->error(\XF::phrase('please_read_and_accept_our_terms_and_privacy_policy_before_continuing'));
        //     } else if ($tosUrl) {
        //         return $this->error(\XF::phrase('please_read_and_accept_our_terms_and_rules_before_continuing'));
        //     } else {
        //         return $this->error(\XF::phrase('please_read_and_accept_our_privacy_policy_before_continuing'));
        //     }
        // }

        if (!$this->captchaIsValid()) {
            return $this->error(\XF::phrase('did_not_complete_the_captcha_verification_properly'));
        }

        $input = $this->getRegistrationInput($regForm);

        // echo "<pre>";
        // var_dump($input);
        // exit;

        $registration = $this->setupRegistration($input);
        $registration->checkForSpam();

        if (!$registration->validate($errors)) {
            return $this->error($errors);
        }

        $user = $registration->save();

        $preRegContent = $registration->getPreRegContent();
        if ($preRegContent instanceof \XF\Entity\LinkableInterface) {
            $this->session()->preRegContentUrl = $preRegContent->getContentUrl();
        }

        $this->finalizeRegistration($user);

        return $user;
    }

    protected function setupRegistration(array $input)
    {
        /** @var \XF\Service\User\Registration $registration */
        $registration = $this->service('XF:User\Registration');
        $registration->setFromInput($input);

        $registration->setPreRegActionKey($this->session()->preRegActionKey);

        return $registration;
    }


    protected function finalizeRegistration(\XF\Entity\User $user)
    {
        $preRegContentUrl = $this->session()->preRegContentUrl;

        $this->session()->changeUser($user);

        if ($preRegContentUrl) {
            $this->session()->preRegContentUrl = $preRegContentUrl;
        }

        \XF::setVisitor($user);

        /** @var \XF\ControllerPlugin\Login $loginPlugin */
        $loginPlugin = $this->plugin('XF:Login');
        $loginPlugin->createVisitorRememberKey();
    }


    protected function assertRegistrationActive()
    {
        if (!$this->options()->registrationSetup['enabled']) {
            throw $this->exception(
                $this->error(\XF::phrase('new_registrations_currently_not_being_accepted'))
            );
        }

        // prevent discouraged IP addresses from registering
        if ($this->options()->preventDiscouragedRegistration && $this->isDiscouraged()) {
            throw $this->exception(
                $this->error(\XF::phrase('new_registrations_currently_not_being_accepted'))
            );
        }
    }

    protected function getRegistrationInput(\XF\Service\User\RegisterForm $regForm)
    {
        $input = $regForm->getHashedInputValues($this->request);
        $input += $this->request->filter([
            'location' => 'str',
            'dob_day' => 'uint',
            'dob_month' => 'uint',
            'dob_year' => 'uint',
            'custom_fields' => 'array'
        ]);

        if ($this->options()->registrationSetup['requireEmailChoice']) {
            $input['email_choice'] = $this->request->filter('email_choice', 'bool');
        }

        return $input;
    }
}
