<?php

namespace ThemeHouse\Monetize\Admin\Controller;

use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

/**
 * Class AffiliateLink
 * @package ThemeHouse\Monetize\Admin\Controller
 */
class AffiliateLink extends AbstractEntityManagement
{
    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        if ($params['affiliate_link_id']) {
            $affiliateLink = $this->assertEntityExits($params['affiliate_link_id']);
            return $this->redirect($this->buildLink('thmonetize-affiliate-links/edit', $affiliateLink));
        }

        /** @var \ThemeHouse\Monetize\Repository\AffiliateLink $affiliateLinkRepo */
        $affiliateLinkRepo = $this->getEntityRepo();
        $affiliateLinkList = $affiliateLinkRepo->findAffiliateLinksForList()->fetch();
        $affiliateLinks = $affiliateLinkList;

        $viewParams = [
            'affiliateLinks' => $affiliateLinks,
            'totalAffiliateLinks' => $affiliateLinks->count()
        ];
        return $this->view('ThemeHouse\Monetize:AffiliateLink\Listing', 'thmonetize_affiliate_link_list', $viewParams);
    }

    /**
     * @return \XF\Mvc\Reply\Redirect
     */
    public function actionRebuildCache()
    {

        /** @var \ThemeHouse\Monetize\Repository\AffiliateLink $repo */
        $repo = $this->getEntityRepo();
        $repo->rebuildAffiliateLinkCache();

        return $this->redirect($this->buildLink('thmonetize-affiliate-links'));
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\AffiliateLink|Entity $entity
     * @return \XF\Mvc\Reply\View
     */
    protected function entityAddEdit(Entity $entity)
    {
        $userCriteria = $this->app->criteria('XF:User', $entity->user_criteria);

        $viewParams = [
            'affiliateLink' => $entity,
            'userCriteria' => $userCriteria,
        ];
        return $this->view('ThemeHouse\Monetize:AffiliateLink\Edit', 'thmonetize_affiliate_link_edit', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\AffiliateLink|Entity $entity
     * @return \XF\Mvc\FormAction
     */
    protected function entitySaveProcess(Entity $entity)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'title' => 'str',
            'reference_link_prefix' => 'str',
            'reference_link_suffix' => 'str',
            'active' => 'bool',
            'url_cloaking' => 'bool',
            'url_encoding' => 'bool',
            'link_criteria' => 'array',
            'user_criteria' => 'array'
        ]);

        $parserTypes = $this->filter('reference_link_parser_type', 'array');
        $paramOnes = $this->filter('reference_link_parser_param_one', 'array');
        $paramTwos = $this->filter('reference_link_parser_param_two', 'array');

        $referenceLinkParser = [];
        foreach ($parserTypes as $key => $value) {
            $paramOne = $paramOnes[$key];
            $paramTwo = $paramTwos[$key];

            if (!$value || !$paramOne || !$paramTwo) {
                continue;
            }

            $referenceLinkParser[] = array(
                'type' => $value,
                'param_one' => $paramOne,
                'param_two' => $paramTwo,
            );
        }

        $input['reference_link_parser'] = $referenceLinkParser;

        $form->basicEntitySave($entity, $input);

        /** @var \ThemeHouse\Monetize\Repository\AffiliateLink $repo */
        $repo = $this->getEntityRepo();
        $repo->rebuildAffiliateLinkCache();

        return $form;
    }

    /**
     * @param $action
     * @param ParameterBag $params
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertAdminPermission('thMonetize_affiliateLinks');
    }

    /**
     * @return string
     */
    protected function getEntityKey()
    {
        return 'ThemeHouse\Monetize:AffiliateLink';
    }

    /**
     * @return string
     */
    protected function getContentIdKey()
    {
        return 'affiliate_link_id';
    }

    /**
     * @return string
     */
    protected function getRoute()
    {
        return 'thmonetize-affiliate-links';
    }
}
