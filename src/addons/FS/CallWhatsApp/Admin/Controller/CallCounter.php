<?php

namespace FS\CallWhatsApp\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class CallCounter extends AbstractController {

    public function actionIndex(ParameterBag $params) {


        $finder = $this->finder('FS\CallWhatsApp:CallWhatsAppCounter');

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
            'callCounts' => $finder->fetch(),
        ];

        return $this->view('FS\CallWhatsApp:CallLog', 'call_counts', $viewpParams);
    }
}
