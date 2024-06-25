<?php

namespace ThemeHouse\Monetize\Admin\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Repository\UserUpgrade;

/**
 * Class UpgradePage
 * @package ThemeHouse\Monetize\Admin\Controller
 */
class UpgradePage extends AbstractEntityManagement
{
    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        if ($params['upgrade_page_id']) {
            $upgradePage = $this->assertEntityExits($params['upgrade_page_id']);
            return $this->redirect($this->buildLink('thmonetize-upgrade-pages/edit', $upgradePage));
        }

        /** @var \ThemeHouse\Monetize\Repository\UpgradePage $upgradePageRepo */
        $upgradePageRepo = $this->getEntityRepo();
        $upgradePages = $upgradePageRepo->findUpgradePagesForList()->fetch();

        $optionIds = [
            'thmonetize_requireUserUpgradeOnRegistration',
            'thmonetize_allowGuestsToViewUserUpgrades',
            'thmonetize_suggestUpgradeOnNoPermissionError',
        ];
        $options = $this->em()->findByIds('XF:Option', $optionIds)->sortByList($optionIds);

        $viewParams = [
            'upgradePages' => $upgradePages,
            'totalUpgradePages' => $upgradePages->count(),
            'options' => $options,
        ];
        return $this->view('ThemeHouse\Monetize:UpgradePage\Listing', 'thmonetize_upgrade_page_list', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\UpgradePage|Entity $entity $upgradePage
     * @return \XF\Mvc\Reply\View
     */
    protected function entityAddEdit(Entity $entity)
    {
        $userCriteria = $this->app->criteria('XF:User', $entity->user_criteria);
        $pageCriteria = $this->app->criteria('XF:Page', $entity->page_criteria);

        $relations = [];
        if ($entity->exists() && $entity->Relations) {
            foreach ($entity->Relations as $relation) {
                $relations[$relation->user_upgrade_id] = [
                    'display_order' => $relation->display_order,
                    'featured' => $relation->featured,
                ];
            }
        }

        /** @var UserUpgrade $upgradeRepo */
        $upgradeRepo = $this->repository('XF:UserUpgrade');
        /** @var \ThemeHouse\Monetize\Repository\UpgradePage $upgradePageRepo */
        $upgradePageRepo = $this->getEntityRepo();

        $upgradePageId = $entity->upgrade_page_id;
        $upgradePageList = $upgradePageRepo->findUpgradePagesForList()->fetch();
        $upgradePages = $upgradePageList->filter(
            function (\ThemeHouse\Monetize\Entity\UpgradePage $upgradePage) use ($upgradePageId) {
                return ($upgradePage->upgrade_page_id !== $upgradePageId);
            }
        );

        $viewParams = [
            'upgradePage' => $entity,
            'userCriteria' => $userCriteria,
            'pageCriteria' => $pageCriteria,
            'relations' => $relations,
            'upgradePages' => $upgradePages,
            'upgrades' => $upgradeRepo->findUserUpgradesForList()->fetch(),
        ];
        return $this->view('ThemeHouse\Monetize:UpgradePage\Edit', 'thmonetize_upgrade_page_edit', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\UpgradePage|Entity $entity $upgradePage
     * @return FormAction
     */
    protected function entitySaveProcess(Entity $entity)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'display_order' => 'int',
            'active' => 'bool',
            'user_criteria' => 'array',
            'page_criteria' => 'array',
            'page_criteria_overlay_only' => 'bool',
            'overlay' => 'bool',
            'show_all' => 'bool',
            'overlay_dismissible' => 'bool',
            'accounts_page' => 'bool',
            'error_message' => 'bool',
            'upgrade_page_links' => 'array',
            'accounts_page_link' => 'bool',
        ]);

        $form->basicEntitySave($entity, $input);

        /** @var UserUpgrade $upgradeRepo */
        $upgradeRepo = $this->repository('XF:UserUpgrade');
        $upgrades = $upgradeRepo->findUserUpgradesForList()->fetch();
        $relationMap = [];

        foreach ($this->filter('relations', 'array') as $userUpgradeId => $relation) {
            if (is_array($relation)
                && !empty($relation['selected'])
                && isset($relation['display_order'])
                && isset($upgrades[$userUpgradeId])
            ) {
                $relationMap[$userUpgradeId] = [
                    'display_order' => $this->app->inputFilterer()->filter($relation['display_order'], 'uint'),
                    'featured' => !empty($relation['featured']),
                ];
            }
        }

        $form->validate(function (FormAction $form) use ($entity, $upgrades, $relationMap) {
            if (!$entity->show_all && !count($relationMap)) {
                $form->logError(
                    \XF::phrase('thmonetize_upgrade_pages_must_have_at_least_one_user_upgrade'),
                    'relations'
                );
            }
        });
        $form->apply(function () use ($entity, $relationMap) {
            $entity->updateRelations($relationMap);
        });

        $extraInput = $this->filter([
            'title' => 'str'
        ]);
        $form->apply(function () use ($entity, $extraInput) {
            $title = $entity->getMasterPhrase();
            $title->phrase_text = $extraInput['title'];
            $title->save();
        });

        return $form;
    }

    /**
     * @param $action
     * @param ParameterBag $params
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertAdminPermission('thMonetize_upgradePages');
    }

    /**
     * @return string
     */
    protected function getEntityKey()
    {
        return 'ThemeHouse\Monetize:UpgradePage';
    }

    /**
     * @return string
     */
    protected function getContentIdKey()
    {
        return 'upgrade_page_id';
    }

    /**
     * @return string
     */
    protected function getRoute()
    {
        return 'thmonetize-upgrade-pages';
    }
}
