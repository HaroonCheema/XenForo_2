<?php

namespace FS\ApproveRejectedUser\XF\Pub\Controller;

class ApprovalQueue extends XFCP_ApprovalQueue
{

    // public function actionIndex()
    // {
    //     $parent = parent::actionIndex();

    //     $isEmail = $this->filter('isEmail', 'bool');

    //     if ($isEmail && $parent instanceof \XF\Mvc\Reply\View) {
    //         $filters = $parent->getParam('filters');

    //         $filters['isEmail'] = $isEmail;

    //         $parent->setParam('filters', $filters);
    //     }

    //     return $parent;
    // }


    public function actionIndex()
    {
        $approvalQueueRepo = $this->getApprovalQueueRepo();

        $unapprovedFinder = $approvalQueueRepo->findUnapprovedContent(true);  // just pass true for find unapproved content with Rejected User records    

        $filters = $this->getQueueFilterInput();
        $this->applyQueueFilters($unapprovedFinder, $filters);

        /** @var \XF\Entity\ApprovalQueue[]|\XF\Mvc\Entity\ArrayCollection $unapprovedItems */
        $unapprovedItems = $unapprovedFinder->fetch();

        if ($unapprovedItems->count() != $this->app->unapprovedCounts['total']) {
            $approvalQueueRepo->rebuildUnapprovedCounts();
        }

        $approvalQueueRepo->addContentToUnapprovedItems($unapprovedItems);
        $approvalQueueRepo->cleanUpInvalidRecords($unapprovedItems);
        $unapprovedItems = $approvalQueueRepo->filterViewableUnapprovedItems($unapprovedItems);

        // ------ add isEmail in filters for condition on frontend -------
        $isEmail = $this->filter('isEmail', 'bool');
        if ($isEmail) {
            $filters['isEmail'] = $isEmail;
        }
        //----------------------------------------------------------------

        $viewParams = [
            'filters' => $filters,
            'unapprovedItems' => $unapprovedItems->slice(0, 50),
        ];
        return $this->view('XF:ApprovalQueue\Listing', 'approval_queue', $viewParams);
    }

    protected function getQueueFilterInput()
    {
        $filters = parent::getQueueFilterInput();

        $input = $this->filter([
            'content_id' => 'uint',
            'username' => 'str',
            'isEmail' => 'bool',
        ]);

        $isEmail = $input['isEmail'];

        if ($isEmail) {
            $filters['isEmail'] = $isEmail;
        }

        $nameOrEmail = $input['username'];

        if ($input['content_id']) {
            $filters['content_id'] = $input['content_id'];
        } else if ($nameOrEmail) {

            $userRepo = $this->repository("XF:User");
            $user =  $userRepo->getUserByNameOrEmail($nameOrEmail);

            if ($user) {
                $filters['content_id'] = $user->user_id;
            }

            if (strpos($nameOrEmail, '@')) {
                $filters['isEmail'] = true;
            }
        }

        return $filters;
    }


    protected function applyQueueFilters(\XF\Mvc\Entity\Finder $finder, array $filters)
    {
        if (!empty($filters['content_id'])) {
            $finder->where('content_id', $filters['content_id']);
        }

        return parent::applyQueueFilters($finder, $filters);
    }
}
