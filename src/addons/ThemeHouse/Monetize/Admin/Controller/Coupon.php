<?php

namespace ThemeHouse\Monetize\Admin\Controller;


use XF\Mvc\Entity\Entity;

use XF\Mvc\ParameterBag;

/**
 * Class Coupon
 * @package ThemeHouse\Monetize\Admin\Controller
 */
class Coupon extends AbstractEntityManagement
{
    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        if ($params['coupon_id']) {
            $coupon = $this->assertEntityExits($params['coupon_id']);
            return $this->redirect($this->buildLink('thmonetize-coupons/edit', $coupon));
        }

        /** @var \ThemeHouse\Monetize\Repository\Coupon $couponRepo */
        $couponRepo = $this->getEntityRepo();
        $couponList = $couponRepo->findCouponsForList()->fetch();
        $coupons = $couponList;

        $viewParams = [
            'coupons' => $coupons,
            'totalCoupons' => $coupons->count(),
        ];
        return $this->view('ThemeHouse\Monetize:Coupon\Listing', 'thmonetize_coupon_list', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\Coupon|Entity $entity
     * @return \XF\Mvc\Reply\View
     */
    protected function entityAddEdit(Entity $entity)
    {
        $userCriteria = $this->app->criteria('XF:User', $entity->user_criteria);

        $viewParams = [
            'coupon' => $entity,
            'userCriteria' => $userCriteria,
        ];
        return $this->view('ThemeHouse\Monetize:Coupon\Edit', 'thmonetize_coupon_edit', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\Coupon|Entity $entity
     * @return \XF\Mvc\FormAction
     */
    protected function entitySaveProcess(Entity $entity)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'title' => 'str',
            'code' => 'str',
            'type' => 'str',
            'value' => 'int',
            'active' => 'bool',
            'user_criteria' => 'array',
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
        $this->assertAdminPermission('thMonetize_coupons');
    }

    /**
     * @return string
     */
    protected function getEntityKey()
    {
        return 'ThemeHouse\Monetize:Coupon';
    }

    /**
     * @return string
     */
    protected function getContentIdKey()
    {
        return 'coupon_id';
    }

    /**
     * @return string
     */
    protected function getRoute()
    {
        return 'thmonetize-coupons';
    }
}
