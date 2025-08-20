<?php

namespace FS\TractorByNetMyThreads\Siropu\AdsManager\Template;

class Ad extends XFCP_Ad
{
    public function __construct(\XF\App $app, $reply)
    {
        $options = \XF::options();
        $visitor = \XF::visitor();

        $this->pageState['template'] = $reply->getTemplateName();

        if($this->pageState['template'] != "fs_tbn_forum_view_type_article"){

            return parent::__construct($app, $reply);
        }

        if (!method_exists($visitor, 'canViewAdsSiropuAdsManager')) {
            return;
        }

        if (!($visitor->canViewAdsSiropuAdsManager() && $reply)) {
            return;
        }

        $classes     = [];
        $actions     = [];
        $postParsing = $options->siropuAdsManagerAdParsingWhenPosting;

        if (!empty($postParsing['thread'])) {
            $classes[] = 'XF:Thread';
            $actions[] = 'AddReply';
            $actions[] = 'add-reply';
        }

        if (!empty($postParsing['conversation'])) {
            $classes[] = 'XF:Conversation';
            $actions[] = 'AddReply';
            $actions[] = 'add-reply';
        }

        if (!empty($postParsing['profile'])) {
            $classes[] = 'XF:Member';
            $actions[] = 'Post';
        }

        if (!empty($postParsing['chat'])) {
            $classes[] = 'Siropu\Chat:Chat';
            $actions[] = 'Submit';
            $actions[] = 'Update';
        }

        $controllerClass  = $reply->getControllerClass();
        $controllerAction = $reply->getAction();

        if (($app->request()->isXhr() && !(in_array($controllerClass, $classes) && in_array($controllerAction, $actions)))
            || strpos($controllerClass, 'Siropu\AdsManager') !== false
        ) {
            return;
        }

        $this->pageState = [
            'pageSection'  => $reply->getSectionContext(),
            'controller'   => $controllerClass,
            'action'       => $controllerAction,
            'containerKey' => $reply->getContainerKey(),
            'fromSearch'   => $app->request()->getFromSearch(),
            'pageStyleId'  => $app->templater()->getStyleId(),
            'classType'    => $app->container('app.classType'),
            'breadcrumbs'  => []
        ];

        if ($reply instanceof \XF\Mvc\Reply\View) {
            $this->pageState['view']     = $reply->getViewClass();
            $this->pageState['template'] = $reply->getTemplateName();
        } else if ($reply instanceof \XF\Mvc\Reply\Error || $reply->getResponseCode() >= 400) {
            $this->pageState['template'] = 'error';
        } else if ($reply instanceof \XF\Mvc\Reply\Message) {
            $this->pageState['template'] = 'message_page';
        }

        $disallowedTemplates = $options->siropuAdsManagerDisallowedTemplates;

        if (
            !empty($disallowedTemplates)
            && isset($this->pageState['template'])
            && in_array($this->pageState['template'], \Siropu\AdsManager\Util\Arr::getItemArray($disallowedTemplates, false, "\n"))
        ) {
            return;
        }

        if ($reply instanceof \XF\Mvc\Reply\View) {
            $params = $reply->getParams();

            switch ($this->pageState['template']) {
                case 'forum_view':
                case 'forum_view_type_article':
                case 'forum_view_type_question':
                case 'forum_view_type_suggestion':
                case 'fs_tbn_forum_view_type_article':
                case 'thread_view':
                case 'thread_view_type_poll':
                case 'thread_view_type_article':
                case 'thread_view_type_question':
                case 'thread_view_type_suggestion':
                case 'amp_thread_view':
                case 'amp_thread_view_type_poll':
                case 'amp_thread_view_type_article':
                case 'amp_thread_view_type_question':
                case 'amp_thread_view_type_suggestion':
                case 'xfrm_thread_view_type_resource':
                case 'xa_sc_thread_view_type_item':
                    $entity = $params['forum'];
                    break;
                case 'page_view':
                    $entity = $params['page'];
                    break;
                case 'xfrm_category_view':
                case 'xfrm_resource_view':
                    $entity = $params['category'];
                    break;
                case 'xfrm_resource_updates':
                case 'xfrm_resource_reviews':
                    $entity = $params['resource']['Category'];
                    break;
                case 'xfmg_category_view':
                    $entity = $params['category'];
                    break;
                case 'xfmg_media_view':
                    $entity = $params['mediaItem']['Category'];
                    break;
                case 'xa_ams_category_view':
                    $entity = $params['category'];
                    break;
                case 'xa_ams_article_view':
                    $entity = $params['article']['Category'];
                    break;
                case 'xa_sc_item_view':
                    $entity = $params['item']['Category'];
                    break;
                case 'dbtech_ecommerce_product_view':
                case 'dbtech_ecommerce_product_specifications':
                    $entity = $params['product'];
                    break;
                default:
                    $entity = null;
                    break;
            }

            if (!empty($entity)) {
                if (strpos($this->pageState['template'], 'forum_view') !== false) {
                    $ids = array_merge(
                        $options->siropuAdsManagerPromoThreadForums,
                        $options->siropuAdsManagerAllowedStickyForums
                    );

                    if (in_array($entity->node_id, $ids)) {
                        $this->loadAdvertisereHereForumAds = true;
                    }
                }

                foreach ($entity->getBreadcrumbs() as $breadcrumb) {
                    $attributes = array_filter($breadcrumb, function ($key) {
                        return in_array($key, ['node_id', 'category_id', 'resource_category_id']);
                    }, ARRAY_FILTER_USE_KEY);

                    $this->pageState['breadcrumbs'][] = ['attributes' => $attributes];
                }
            }

            switch ($this->pageState['controller']) {
                case 'XF:Page':
                    if (!empty($params['page'])) {
                        $this->positionParams['page'] = $params['page'];
                    }
                    break;
                case 'XF:Forum':
                case 'XF:WhatsNewPost':
                    if (!empty($params['forum'])) {
                        $this->positionParams['forum'] = $params['forum'];
                    }
                    if (!empty($params['threads'])) {
                        $this->itemCount = count($params['threads']);
                    }
                    break;
                case 'XF:Thread':
                    if (isset($params['posts'], $params['thread'])) {
                        $this->positionParams['thread'] = $params['thread'];
                        $this->itemCount = count($params['posts']);

                        $i = 0;

                        foreach ($params['posts'] as $post) {
                            $i++;

                            if (!$this->firstUnread && $post->isUnread()) {
                                $this->firstUnread = $i;
                            }

                            $this->positionParams['posts'][$i] = $post;
                        }

                        $this->loadFilterAds = true;
                    }
                    break;
                case 'XF:Conversation':
                    if (!empty($params['userConvs'])) {
                        $this->itemCount = count($params['userConvs']);
                    }
                    break;
                case 'XF\Pub\Controller\Conversation':
                    if (isset($params['messages'], $params['lastRead'])) {
                        $this->positionParams['conversation'] = $params['conversation'];
                        $this->itemCount = count($params['messages']);

                        $i = 0;

                        foreach ($params['messages'] as $message) {
                            $i++;

                            if (!$this->firstUnread && $message->isUnread($params['lastRead'])) {
                                $this->firstUnread = $i;
                            }

                            $this->positionParams['posts'][$i] = $message;
                        }

                        $this->loadFilterAds = true;
                    }
                    break;
                case 'XF:Member':
                case 'XF\Pub\Controller\Member':
                    if (!empty($params['profilePosts'])) {
                        $this->itemCount = count($params['profilePosts']);

                        $i = 0;

                        foreach ($params['profilePosts'] as $post) {
                            $this->positionParams['posts'][$i++] = $post;
                        }

                        $this->loadFilterAds = true;
                    }
                    break;
                case 'XF\Pub\Controller\Search':
                case 'XF:Tag':
                    if (!empty($params['results'])) {
                        $this->itemCount = count($params['results']);
                    }
                    if (!empty($params['search'])) {
                        $this->positionParams['searchQuery'] = $params['search']['search_query'];
                    }
                    break;
                case 'XF:WhatsNew':
                    if (!empty($params['newsFeedItems'])) {
                        $this->itemCount = count($params['newsFeedItems']);
                    }
                    break;
                case 'XFMG:Media':
                case 'XFMG\Pub\Controller\Category':
                case 'XFMG\Pub\Controller\Album':
                    if (!empty($params['mediaItems'])) {
                        $this->itemCount = count($params['mediaItems']);
                    }
                    break;
                case 'XFMG\Pub\Controller\Media':
                    if (!empty($params['comments'])) {
                        $this->itemCount = count($params['comments']);
                    }
                    break;
                case 'XFRM:ResourceItem':
                case 'XFRM:Category':
                case 'XFRM\Pub\Controller\ResourceItem':
                    if (!empty($params['resources'])) {
                        $this->itemCount = count($params['resources']);
                    }
                    if (!empty($params['resource'])) {
                        $this->positionParams['resource'] = $params['resource'];
                    }
                    break;
                case 'XenAddons\AMS:Category':
                case 'XenAddons\AMS:ArticleItem':
                case 'XenAddons\AMS\Pub\Controller\ArticleItem':
                    if (!empty($params['articles'])) {
                        $this->itemCount = count($params['articles']);
                    }
                    if (!empty($params['article'])) {
                        $this->positionParams['article'] = $params['article'];
                    }
                    break;
                case 'XenAddons\Showcase:Category':
                    if (!empty($params['items'])) {
                        $this->itemCount = count($params['items']);
                    }
                    break;
                case 'XenAddons\Showcase\Pub\Controller\Item':
                    if (!empty($params['item'])) {
                        $this->positionParams['showcase'] = $params['item'];
                    }
                    break;
                case 'XF:Account':
                    if (!empty($params['alerts'])) {
                        $this->itemCount = count($params['alerts']);
                    }
                    break;
                case 'XFRM\Pub\Controller\ResourceItem':
                case 'XenAddons\AMS\Pub\Controller\ArticleItem':
                case 'XenAddons\Showcase\Pub\Controller\Item':
                case 'DBTech\eCommerce\Pub\Controller\Product':
                case 'DBTech\eCommerce:Product':
                case 'Siropu\Chat:Chat':
                case 'Siropu\Chat:Archive':
                    $this->loadFilterAds = true;
                    break;
                case 'XF:Forum\Listing':
                    if (!empty($postParsing['chat'])) {
                        $this->loadFilterAds = true;
                    }
                    break;
            }

            if ($this->itemCount) {
                $this->positionParams['itemCount'] = $this->itemCount;
            }
        }

        $this->setAds();

        if ($this->loadFilterAds) {
            $this->setFilterAds();
        }
    }
}
