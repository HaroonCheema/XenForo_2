<?php

namespace FS\ExtendThreadCredits\Admin\View\Purchase;

class Export extends \XF\Mvc\View
{
	public function renderXml()
	{
		/** @var \DOMDocument $document */
		$document = $this->params['xml'];

		$this->response->setDownloadFileName('purchase.xml');

		return $document->saveXML();
	}
}