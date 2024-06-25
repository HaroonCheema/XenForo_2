<?php

namespace ThemeHouse\Monetize\Admin\Controller;


use XF\Mvc\Entity\Entity;

use XF\Mvc\ParameterBag;

/**
 * Class Sponsor
 * @package ThemeHouse\Monetize\Admin\Controller
 */
class Sponsor extends AbstractEntityManagement
{
    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        if ($params['th_sponsor_id']) {
            $sponsor = $this->assertEntityExits($params['th_sponsor_id']);
            return $this->redirect($this->buildLink('thmonetize-sponsors/edit', $sponsor));
        }

        /** @var \ThemeHouse\Monetize\Repository\Sponsor $sponsorRepo */
        $sponsorRepo = $this->getEntityRepo();
        $sponsorList = $sponsorRepo->findSponsorsForList()->fetch();
        $sponsors = $sponsorList;

        $options = $this->em()->findByIds('XF:Option', [
            'thmonetize_enableSponsorsDirectory',
        ]);

        $viewParams = [
            'sponsors' => $sponsors,
            'totalSponsors' => $sponsors->count(),
            'options' => $options,
        ];
        return $this->view('ThemeHouse\Monetize:Sponsor\Listing', 'thmonetize_sponsor_list', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\Sponsor|Entity $entity
     * @return \XF\Mvc\Reply\View
     */
    protected function entityAddEdit(Entity $entity)
    {
        $viewParams = [
            'sponsor' => $entity,
        ];
        return $this->view('ThemeHouse\Monetize:Sponsor\Edit', 'thmonetize_sponsor_edit', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\Sponsor|Entity $entity
     * @return \XF\Mvc\FormAction
     */
    protected function entitySaveProcess(Entity $entity)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'title' => 'str',
            'active' => 'bool',
            'featured' => 'bool',
            'url' => 'str',
            'image' => 'str',
            'width' => 'int',
            'height' => 'int',
            'directory' => 'bool',
            'notes' => 'str',
        ]);

        $form->basicEntitySave($entity, $input);

        return $form;
    }

    /**
     * @param $action
     * @param ParameterBag $params
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertAdminPermission('thMonetize_sponsors');
    }

    /**
     * @return string
     */
    protected function getEntityKey()
    {
        return 'ThemeHouse\Monetize:Sponsor';
    }

    /**
     * @return string
     */
    protected function getContentIdKey()
    {
        return 'th_sponsor_id';
    }

    /**
     * @return string
     */
    protected function getRoute()
    {
        return 'thmonetize-sponsors';
    }
}
