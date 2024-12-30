<?php

namespace PunterForum\RelatedReviews\Pub\Controller;

use XF\App;
use XF\Http\Request;

class Search extends \XF\Pub\Controller\AbstractController
{

    public function actionIndex()
    {
        $this->setResponseType('json');

        try {

            /** @var \PunterForum\PhoneCoreLibrary\Service\PhoneService $phoneLibraryService */
            $phoneLibraryService = $this->service('PunterForum\PhoneCoreLibrary:PhoneService');
            $phone = $phoneLibraryService->validatePhoneNumber($this->filter('phone', 'str'));
            /** @var \PunterForum\RelatedReviews\Service\Reviews\Phones $phoneReviewsService */
            $phoneReviewsService = $this->service('PunterForum\RelatedReviews:Reviews\Phones');
            $viewParams['urls'] = $phoneReviewsService->searchEscortHub($phone);

        } catch (\Throwable $exception) {
            $this->app->logException($exception);
            $viewParams['urls'] = [];
        }

        $view = $this->view('PunterForum\RelatedReviews\Pub\View\Search');

        $view->setJsonParams($viewParams);

        return $view;
    }

}