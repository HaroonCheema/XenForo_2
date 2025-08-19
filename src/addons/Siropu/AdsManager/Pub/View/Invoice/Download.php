<?php

namespace Siropu\AdsManager\Pub\View\Invoice;

class Download extends \XF\Mvc\View
{
	public function renderRaw()
	{
		$this->response->setAttachmentFileParams($this->params['invoice']->invoice_file);
		return $this->response->responseStream(\XF::fs()->readStream($this->params['invoice']->getInvoiceFilePath()));
	}
}
