<?php

namespace ThemeHouse\Monetize\Admin\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

/**
 * Class AbstractCommunication
 * @package ThemeHouse\Monetize\Admin\Controller
 */
class Communication extends AbstractEntityManagement
{
    /**
     * @param $action
     * @param ParameterBag $params
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertAdminPermission('thMonetize_communication');
    }

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        if ($params['communcation_id']) {
            $communication = $this->assertEntityExits($params['communcation_id']);
            return $this->redirect($this->buildLink('thmonetize-communications/edit',
                $communication));
        }

        /** @var \ThemeHouse\Monetize\Repository\Communication $comRepo */
        $comRepo = $this->getEntityRepo();
        $communications = $comRepo->findForList()->fetch();

        $viewParams = [
            'communications' => $communications,
            'total' => $communications->count()
        ];
        return $this->view('ThemeHouse\Monetize:Communcations\Listing',
            'thmonetize_communication_list', $viewParams);
    }

    /**
     * @param Entity $entity
     * @return FormAction
     */
    protected function entitySaveProcess(Entity $entity)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'send_rules' => 'array',
            'title' => 'str',
            'active' => 'bool',
            'body' => 'str',
            'user_upgrade_criteria' => 'array',
            'user_criteria' => 'array',
            'limit' => 'int',
            'limit_days' => 'int',
            'type' => 'str'
        ]);

        $typeExtra = $this->filter('type_options', 'array-array');
        $input['type_options'] = empty($typeExtra[$input['type']]) ? [] : $typeExtra[$input['type']];

        $username = $this->filter('username', 'str');
        /** @var \XF\Entity\User $user */
        $user = $this->em()->findOne('XF:User', ['username' => $username]);

        $input['user_id'] = $user ? $user->user_id : 0;

        $form->validate(function(FormAction $form) use ($input)
        {
            if ($input['user_id'] === 0 && $input['type'] == 'message')
            {
                $form->logError(\XF::phrase('thmonetize_communication_from_user_required_type_message'), 'username');
            }
        });

        $form->basicEntitySave($entity, $input);

        return $form;
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\Communication|Entity $entity
     * @return \XF\Mvc\Reply\View
     */
    protected function entityAddEdit(Entity $entity)
    {
        $userUpgradeCriteria = $this->app->criteria('ThemeHouse\Monetize:UserUpgrade',
            $entity->user_upgrade_criteria);
        $userCriteria = $this->app->criteria('XF:User', $entity->user_criteria);

        $viewParams = [
            'communication' => $entity,
            'userUpgradeCriteria' => $userUpgradeCriteria,
            'userCriteria' => $userCriteria,
        ];
        return $this->view('ThemeHouse\Monetize:Communication\Edit',
            'thmonetize_communication_edit', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Message|\XF\Mvc\Reply\View
     * @throws \XF\PrintableException
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionSend(ParameterBag $params)
    {
        /** @var \ThemeHouse\Monetize\Entity\Communication $communication */
        $communication = $this->assertEntityExits($params[$this->getContentIdKey()]);

        if ($this->isPost()) {
            if ($communication->active) {
                $communication->save();
            }

            \XF::app()->jobManager()->enqueueUnique(
                'ThMonetize_SendCommunication',
                'ThemeHouse\Monetize:SendCommunication',
                [
                    'communication_id' => $communication->communication_id
                ],
                false
            );
            return $this->message(\XF::phrase('thmonetize_communication_sent_successfully'));
        } else {
            $viewParams = [
                'communication' => $communication,
                'sendRoute' => $this->buildLink($this->getRoute() . '/send'),
                'editRoute' => $this->buildLink($this->getRoute() . '/edit'),
                'confirmation' => \XF::phrase('thmonetize_please_confirm_that_you_want_to_send_following_communication:')
            ];
            return $this->view('ThemeHouse\Monetize:Communication\Send',
                'thmonetize_communication_send', $viewParams);
        }
    }

    /**
     * @return string
     */
    protected function getEntityKey()
    {
        return 'ThemeHouse\Monetize:Communication';
    }

    /**
     * @return string
     */
    protected function getContentIdKey()
    {
        return 'communication_id';
    }

    /**
     * @return string
     */
    protected function getRoute()
    {
        return 'thmonetize-communications';
    }
}