<?php

namespace ThemeHouse\Monetize\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

/**
 * Class Log
 * @package ThemeHouse\Monetize\XF\Admin\Controller
 */
class Log extends XFCP_Log
{
    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionThmonetize(ParameterBag $params)
    {
        if ($params['communication_log_id']) {
            $entry = $this->assertThMonetizeCommunicationLogExists(
                $params['communication_log_id'],
                ['Communication', 'User'],
                'requested_log_entry_not_found'
            );

            $viewParams = [
                'entry' => $entry
            ];
            return $this->view('ThemeHouse\Monetize:Log\Communication\View', 'thmonetize_log_communication_view', $viewParams);
        } else {
            $page = $this->filterPage();
            $perPage = 20;

            /** @var \ThemeHouse\Monetize\Repository\CommunicationLog $communicationLogRepo */
            $communicationLogRepo = $this->repository('ThemeHouse\Monetize:CommunicationLog');

            $logFinder = $communicationLogRepo->findLogsForList()
                ->limitByPage($page, $perPage);

            $linkFilters = [];
            if ($userId = $this->filter('user_id', 'uint')) {
                $linkFilters['user_id'] = $userId;
                $logFinder->where('user_id', $userId);
            }

            if($contentType = $this->filter('content_type', 'str')) {
                $linkFilters['content_type'] = $contentType;
                $logFinder->where('Communication.type', '=', $contentType);
            }

            if ($this->isPost()) {
                // redirect to give a linkable page
                return $this->redirect($this->buildLink('logs/thmonetize', null, $linkFilters));
            }

            $viewParams = [
                'entries' => $logFinder->fetch(),
                'logUsers' => $communicationLogRepo->getUsersInLog(),

                'userId' => $userId,
                'contentType' => $contentType,

                'page' => $page,
                'perPage' => $perPage,
                'total' => $logFinder->total(),
                'linkFilters' => $linkFilters
            ];
            return $this->view('ThemeHouse\Monetize:Log\Communication\Listing', 'thmonetize_log_communication_list', $viewParams);
        }
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \ThemeHouse\Monetize\Entity\CommunicationLog
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertThMonetizeCommunicationLogExists($id, $with = null, $phraseKey = null)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->assertRecordExists('ThemeHouse\Monetize:CommunicationLog', $id, $with, $phraseKey);
    }
}
