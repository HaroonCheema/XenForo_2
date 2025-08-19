<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\ParameterBag;

class Invoice extends AbstractController
{
     protected function preDispatchController($action, ParameterBag $params)
     {
          if (!($this->isLoggedIn() && \XF::visitor()->canCreateAdsSiropuAdsManager()))
          {
               throw $this->exception($this->noPermission());
          }
     }
     public function actionIndex(ParameterBag $params)
     {
          $userId  = \XF::visitor()->user_id;
          $page    = $this->filterPage();
          $perPage = 20;

          $finder = $this->getInvoiceRepo()
               ->findInvoicesForUser($userId)
               ->isParent()
               ->limitByPage($page, $perPage);

          $pendingCount = $this->getInvoiceRepo()
               ->findInvoicesForUser($userId)
               ->ofStatus('pending')
               ->isParent()
               ->total();

          $viewParams = [
               'pendingCount'  => $pendingCount,
               'invoices'      => $finder->fetch(),
               'total'         => $finder->total(),
               'page'          => $page,
               'perPage'       => $perPage
          ];

          $view = $this->view('Siropu\AdsManager:Invoice\List', 'siropu_ads_manager_invoice_list', $viewParams);
          return $this->addWrapperParams($view, 'invoices');
     }
     public function actionPay(ParameterBag $params)
     {
          $invoice = $this->assertInvoiceExistsAndValid($params->invoice_id);

          if ($invoice->isCompleted())
          {
               return $this->message(\XF::phrase('siropu_ads_manager_invoice_has_been_paid'));
          }
          else if ($invoice->isCancelled())
          {
               return $this->message(\XF::phrase('siropu_ads_manager_invoice_has_been_cancelled'));
          }

          $paymentProfiles = $this->getPaymentRepo()
               ->findPaymentProfilesForList()
               ->where('payment_profile_id', \XF::options()->siropuAdsManagerPaymentProfiles)
               ->pluckFrom('title', 'payment_profile_id');

          $invoices = [];

          if (!empty($invoice->child_ids))
          {
               $invoices = $this->getInvoiceRepo()
                    ->findInvoicesForUser(\XF::visitor()->user_id)
                    ->where('invoice_id', $invoice->child_ids)
                    ->fetch();
          }

          $viewParams = [
               'invoice'         => $invoice,
               'invoices'        => $invoices,
               'paymentProfiles' => $paymentProfiles
          ];

          $view = $this->view('Siropu\AdsManager:Invoice\Pay', 'siropu_ads_manager_invoice_pay', $viewParams);
          return $this->addWrapperParams($view, 'invoices');
     }
     public function actionMassPay()
     {
          $invoices = $this->getInvoiceRepo()
               ->findInvoicesForUser(\XF::visitor()->user_id)
               ->ofStatus('pending')
               ->isParent()
               ->fetch();

          $amount = 0;

          foreach ($invoices as $invoice)
          {
               $amount += $invoice->cost_amount;
          }

          if (!$amount)
          {
               return $this->message(\XF::phrase('siropu_ads_manager_no_invoices_to_pay'));
          }

          $invoiceIds    = $invoices->pluckNamed('invoice_id');
          $invoiceExists = $this->em()->findOne('Siropu\AdsManager:Invoice', ['child_ids' => $invoiceIds]);

          if ($invoiceExists)
          {
               $invoiceId = $invoiceExists->invoice_id;
          }
          else
          {
               $invoice = $this->em()->create('Siropu\AdsManager:Invoice');
               $invoice->child_ids = $invoices->pluckNamed('invoice_id');
               $invoice->cost_amount = $amount;
               $invoice->cost_currency = \XF::options()->siropuAdsManagerPreferredCurrency;
               $invoice->save();

               $invoiceId = $invoice->invoice_id;
          }

          return $this->rerouteController(__CLASS__, 'pay', ['invoice_id' => $invoiceId]);
     }
     public function actionDownload(ParameterBag $params)
     {
          $invoice = $this->assertInvoiceExistsAndValid($params->invoice_id);

          if (!$invoice->invoice_file)
          {
               return;
          }

          $this->setResponseType('raw');

          $view = $this->view('Siropu\AdsManager:Invoice\Download');
          $view->setParam('invoice', $invoice);

          return $view;
     }
     public function actionView(ParameterBag $params)
     {
          $invoice = $this->assertInvoiceExistsAndValid($params->invoice_id);

          $viewParams = [
               'invoice' => $invoice
          ];

          return $this->view('Siropu\AdsManager:Invoice\View', 'siropu_ads_manager_invoice_view', $viewParams);
     }
     protected function assertInvoiceExistsAndValid($invoiceId)
     {
          $invoice = $this->assertInvoiceExists($invoiceId);

          if (!$invoice->canPay())
          {
               throw $this->exception($this->noPermission());
          }

          return $invoice;
     }
}
