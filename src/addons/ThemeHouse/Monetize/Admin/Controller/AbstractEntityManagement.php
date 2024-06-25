<?php

namespace ThemeHouse\Monetize\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\ControllerPlugin\Delete;
use XF\Mvc\Entity\Entity;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

/**
 * Class AbstractEntityManagement
 * @package ThemeHouse\Monetize\Admin\Controller
 */
abstract class AbstractEntityManagement extends AbstractController
{
    /**
     * @return string
     */
    abstract protected function getEntityKey();

    /**
     * @return string
     */
    abstract protected function getContentIdKey();

    /**
     * @return string
     */
    abstract protected function getRoute();

    /**
     * @param Entity $entity
     * @return mixed
     */
    abstract protected function entityAddEdit(Entity $entity);

    /**
     * @param Entity $entity
     * @return FormAction
     */
    abstract protected function entitySaveProcess(Entity $entity);

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return \XF\Mvc\Entity\Entity
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertEntityExits($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists($this->getEntityKey(), $id, $with, $phraseKey);
    }

    /**
     * @return \XF\Mvc\Entity\Repository
     */
    protected function getEntityRepo()
    {
        return $this->repository($this->getEntityKey());
    }

    /**
     * @return \XF\Mvc\Reply\View
     */
    public function actionAdd()
    {
        $entity = $this->em()->create($this->getEntityKey());
        return $this->entityAddEdit($entity);
    }

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionEdit(ParameterBag $params)
    {
        $keyword = $this->assertEntityExits($params[$this->getContentIdKey()]);
        return $this->entityAddEdit($keyword);
    }

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect
     * @throws \XF\Mvc\Reply\Exception
     * @throws \XF\PrintableException
     */
    public function actionSave(ParameterBag $params)
    {
        $this->assertPostOnly();

        if ($params[$this->getContentIdKey()]) {
            $entity = $this->assertEntityExits($params[$this->getContentIdKey()]);
        } else {
            $entity = $this->em()->create($this->getEntityKey());
        }

        $this->entitySaveProcess($entity)->run();

        return $this->redirect($this->buildLink($this->getRoute()) . $this->buildLinkHash($entity->{$this->getContentIdKey()}));
    }

    /**
     * @return \XF\Mvc\Reply\Message
     */
    public function actionToggle()
    {
        /** @var \XF\ControllerPlugin\Toggle $plugin */
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle($this->getEntityKey());
    }

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionDelete(ParameterBag $params)
    {
        /** @var \ThemeHouse\Monetize\Entity\Communication|\ThemeHouse\Monetize\Entity\AffiliateLink|\ThemeHouse\Monetize\Entity\Sponsor $entity */
        $entity = $this->assertEntityExits($params[$this->getContentIdKey()]);

        /** @var Delete $delete */
        $delete = $this->plugin('XF:Delete');
        $route = $this->getRoute();
        return $delete->actionDelete(
            $entity,
            $this->buildLink($route . '/delete', $entity),
            $this->buildLink($route . '/edit', $entity),
            $this->buildLink($route),
            $entity->title
        );
    }
}