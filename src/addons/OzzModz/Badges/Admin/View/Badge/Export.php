<?php

namespace OzzModz\Badges\Admin\View\Badge;

class Export extends \XF\Mvc\View
{
	public function renderXml()
	{
		/** @var \DOMDocument $document */
		$document = $this->params['xml'];
		$this->response->setDownloadFileName('badges-export.xml');

		return $document->saveXML();
	}
}
