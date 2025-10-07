<?php

namespace FS\CallWhatsApp\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class CallLog extends AbstractController {

    public function actionIndex(ParameterBag $params) {


        $finder = $this->finder('FS\CallWhatsApp:CallWhatsAppLog');

        $filter = $this->filter('_xfFilter', [
            'text' => 'str',
            'prefix' => 'bool',
        ]);

        if (strlen($filter['text'])) {

            $finder->with('Thread'); // ensure relation is joined

            $finder->where('Thread.title', 'LIKE',
                    $finder->escapeLike($filter['text'], $filter['prefix'] ? '?%' : '%?%')
            );
        }

        $page = $this->filterPage($params->page);

        if (strlen($filter['text'])) {
            $page = 1;
            $perPage = 50000;
        } else {
            $perPage = 15;
            $finder->limitByPage($page, $perPage);
        }
        $viewpParams = [
            'page' => $page,
            'total' => $finder->total(),
            'perPage' => $perPage,
            'callLogs' => $finder->order('timestamp', 'DESC')->fetch(),
        ];

        return $this->view('FS\CallWhatsApp:CallLog', 'call_logs', $viewpParams);
    }
}
