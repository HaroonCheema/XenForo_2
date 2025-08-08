<?php

namespace FS\ReviewsAlertBtn\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
    public function actionCreateReview()
    {
        $visitor = \XF::visitor();
        if (!$visitor->hasPermission('forum', 'postReviewAlert')) {
            return $this->noPermission();
        }

        $this->assertCanonicalUrl($this->buildLink('forums/post-thread'));

        $nodeRepo = $this->getNodeRepo();
        $nodes = $nodeRepo->getReviewsAlertNodeList(null, "review");

        $canCreateThread = false;
        foreach ($nodes as $nodeId => $node) {
            if ($node->node_type_id != 'Forum') {
                continue;
            }

            /** @var \XF\Entity\Forum $forum */
            $forum = $node->Data;
            if ($forum->canCreateThread() || $forum->canCreateThreadPreReg()) {
                $canCreateThread = true;
                break;
            }
        }

        if (!$canCreateThread) {
            return $this->noPermission();
        }

        $nodeTree = $nodeRepo->createNodeTree($nodes);
        $nodeTree = $nodeTree->filter(null, function ($id, \XF\Entity\Node $node, $depth, $children, \XF\Tree $tree) {
            if ($children) {
                return true;
            }
            if (
                $node->node_type_id == 'Forum'
                && ($node->Data->canCreateThread()
                    || $node->Data->canCreateThreadPreReg()
                )
            ) {
                return true;
            }
            return false;
        });

        $nodeExtras = $nodeRepo->getNodeListExtras($nodeTree);

        $viewParams = [
            'nodeTree' => $nodeTree,
            'nodeExtras' => $nodeExtras
        ];
        return $this->view('XF:Forum\PostThreadChooser', 'fs_forum_post_review_chooser', $viewParams);
    }

    public function actionCreateAlert()
    {
        $visitor = \XF::visitor();
        if (!$visitor->hasPermission('forum', 'postReviewAlert')) {
            return $this->noPermission();
        }

        $this->assertCanonicalUrl($this->buildLink('forums/post-thread'));

        $nodeRepo = $this->getNodeRepo();
        $nodes = $nodeRepo->getReviewsAlertNodeList(null, "alert");

        $canCreateThread = false;
        foreach ($nodes as $nodeId => $node) {
            if ($node->node_type_id != 'Forum') {
                continue;
            }

            /** @var \XF\Entity\Forum $forum */
            $forum = $node->Data;
            if ($forum->canCreateThread() || $forum->canCreateThreadPreReg()) {
                $canCreateThread = true;
                break;
            }
        }

        if (!$canCreateThread) {
            return $this->noPermission();
        }

        $nodeTree = $nodeRepo->createNodeTree($nodes);
        $nodeTree = $nodeTree->filter(null, function ($id, \XF\Entity\Node $node, $depth, $children, \XF\Tree $tree) {
            if ($children) {
                return true;
            }
            if (
                $node->node_type_id == 'Forum'
                && ($node->Data->canCreateThread()
                    || $node->Data->canCreateThreadPreReg()
                )
            ) {
                return true;
            }
            return false;
        });

        $nodeExtras = $nodeRepo->getNodeListExtras($nodeTree);

        $viewParams = [
            'nodeTree' => $nodeTree,
            'nodeExtras' => $nodeExtras
        ];
        return $this->view('XF:Forum\PostThreadChooser', 'fs_forum_post_alert_chooser', $viewParams);
    }
}
