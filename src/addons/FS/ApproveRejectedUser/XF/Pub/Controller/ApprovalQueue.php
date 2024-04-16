<?php

namespace FS\ApproveRejectedUser\XF\Pub\Controller;

class ApprovalQueue extends XFCP_ApprovalQueue
{

    protected function getQueueFilterInput()
    {
        $filters = [];

        $input = $this->filter([
            'content_type' => 'str',
            'order' => 'str',
            'direction' => 'str',
            'content_id' => 'uint',
            'username' => 'str',
        ]);


        if ($input['content_type']) {
            $filters['content_type'] = $input['content_type'];
        }



        if ($input['content_id']) {
            $filters['content_id'] = $input['content_id'];
        } else if ($input['username']) {
            $user = $this->em()->findOne('XF:User', ['username' => $input['username']]);
            if ($user) {
                $filters['content_id'] = $user->user_id;
            }
        }


        $sorts = $this->getAvailableQueueSorts();

        if ($input['order'] && isset($sorts[$input['order']])) {
            if (!in_array($input['direction'], ['asc', 'desc'])) {
                $input['direction'] = 'asc';
            }

            if ($input['order'] != 'content_date' || $input['direction'] != 'asc') {
                $filters['order'] = $input['order'];
                $filters['direction'] = $input['direction'];
            }
        }

        return $filters;
    }


    protected function applyQueueFilters(\XF\Mvc\Entity\Finder $finder, array $filters)
    {
        if (!empty($filters['content_type'])) {
            $finder->where('content_type', $filters['content_type']);
        }


        if (!empty($filters['content_id'])) {
            $finder->where('content_id', $filters['content_id']);
        }

        $sorts = $this->getAvailableQueueSorts();

        if (!empty($filters['order']) && isset($sorts[$filters['order']])) {
            $finder->order($sorts[$filters['order']], $filters['direction']);
        }
        // else the default order has already been applied
    }
}
