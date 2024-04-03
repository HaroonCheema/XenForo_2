<?php

namespace FS\AuctionPlugin\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class GuestEmail extends AbstractController
{

    public function actionGuestEmail()
	{
		$input = $this->filter([
			'email' => 'str',
		]);

		if ($this->isPost()) {
			echo "<pre>";
			var_dump($input);
			exit;
		}



		return $this->view('XF:Thread\GuestEmail', 'fs_guest_dialog_box', []);

		return $this->message("Hello World");
	}

    public function actionIndex(ParameterBag $params)
    {
        return $this->message("Index page. Template not created yet.");

        $viewpParams = [];

        return $this->view('FS\AuctionPlugin', 'index_Auction', $viewpParams);
    }

   

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\AuctionPlugin\Entity\AuctionListing
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\AuctionPlugin:AuctionListing', $id, $extraWith, $phraseKey);
    }
}
