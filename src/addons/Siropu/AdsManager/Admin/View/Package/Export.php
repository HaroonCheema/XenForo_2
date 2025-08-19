<?php

namespace Siropu\AdsManager\Admin\View\Package;

class Export extends \XF\Mvc\View
{
	public function renderXml()
	{
		/** @var \DOMDocument $document */
		$document = $this->params['xml'];

		$this->response->setDownloadFileName('packages_' . date('d-m-Y-H-i', \XF::$time) . '.xml');

		return $document->saveXML();
	}
     public function renderRaw()
	{
          $this->response->setAttachmentFileParams('ads_manager_export.zip');
		return $this->response->responseStream(\XF::fs()->readStream('data://siropu/am/export/ads_manager_export.zip'));
	}
}
