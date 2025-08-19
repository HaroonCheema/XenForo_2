<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class Invoice extends AbstractController
{
     public function actionIndex()
     {
          $page    = $this->filterPage();
          $perPage = 20;

          $linkParams = [];

          $finder = $this->getInvoiceRepo()
               ->findInvoicesForList()
               ->limitByPage($page, $perPage);

          if ($username = $this->filter('username', 'str'))
          {
               $user = $this->em()->findOne('XF:User', ['username' => $username]);

               if ($user)
               {
                    $finder->forUser($user->user_id);
               }

               $linkParams['username'] = $username;
          }

          if ($promoCode = $this->filter('promo_code', 'str'))
          {
               $finder->withPromoCode($promoCode);
               $linkParams['promo_code'] = $promoCode;
          }

          if ($status = $this->filter('status', 'str'))
          {
               $finder->ofStatus($status);
               $linkParams['status'] = $status;
          }

          if ($this->filter('recurring', 'bool'))
          {
               $finder->isRecurring();
               $linkParams['recurring'] = 1;
          }

          $viewParams = [
               'revenew'    => $this->getInvoiceRepo()->getRevenewPerCurrency(),
               'invoices'   => $finder->fetch(),
               'total'      => $finder->total(),
               'page'       => $page,
               'perPage'    => $perPage,
               'linkParams' => $linkParams
          ];

          return $this->view('Siropu\AdsManager:Invoice\List', 'siropu_ads_manager_invoice_list', $viewParams);
     }
     public function actionAdd(ParameterBag $params)
     {
          $invoice = $this->em()->create('Siropu\AdsManager:Invoice');
          return $this->invoiceAddEdit($invoice);
     }
     public function actionEdit(ParameterBag $params)
     {
          $invoice = $this->assertInvoiceExists($params->invoice_id);
          return $this->invoiceAddEdit($invoice);
     }
     public function actionSave(ParameterBag $params)
     {
          $this->assertPostOnly();

		if ($params->invoice_id)
		{
			$invoice = $this->assertInvoiceExists($params->invoice_id);
		}
		else
		{
			$invoice = $this->em()->create('Siropu\AdsManager:Invoice');
		}

          $invoice->setOption('admin_edit', true);
		$this->invoiceSaveProcess($invoice)->run();

		return $this->redirect($this->buildLink('ads-manager/invoices'));
     }
     public function actionDelete(ParameterBag $params)
     {
          $invoice = $this->assertInvoiceExists($params->invoice_id);
          $plugin  = $this->plugin('XF:Delete');

          return $plugin->actionDelete(
               $invoice,
               $this->buildLink('ads-manager/invoices/delete', $invoice),
               $this->buildLink('ads-manager/invoices/edit', $invoice),
               $this->buildLink('ads-manager/invoices'),
               "#{$invoice->invoice_id}"
          );
     }
     public function actionDetails(ParameterBag $params)
     {
          $invoice = $this->assertInvoiceExists($params->invoice_id);

          $invoices = [];

          if ($invoice->child_ids)
          {
               $invoices = $this->getInvoiceRepo()
                    ->findInvoicesForList()
                    ->where('invoice_id', $invoice->child_ids)
                    ->fetch();
          }

          $viewParams = [
               'invoice'  => $invoice,
               'invoices' => $invoices
          ];

          return $this->view('Siropu\AdsManager:Invoice\Details', 'siropu_ads_manager_invoice_details', $viewParams);
     }
     public function actionUpload(ParameterBag $params)
     {
          $invoice = $this->assertInvoiceExists($params->invoice_id);

          if ($this->isPost())
          {
               $upload = $this->app()->request->getFile('upload', false, false);

               if ($upload)
               {
                    if (!$upload->isValid($errors))
                    {
                         return $this->message($errors);
                    }

                    $path = "data://siropu/am/invoice/{$invoice->invoice_id}/{$upload->getFileName()}";
                    \XF\Util\File::copyFileToAbstractedPath($upload->getTempFile(), $path);

                    $invoice->invoice_file = $upload->getFileName();
                    $invoice->save();

                    if ($invoice->child_ids)
                    {
                         foreach ($invoice->child_ids as $id)
                         {
                              $inv = $this->em()->find('Siropu\AdsManager:Invoice', $id);
                              $inv->invoice_file = $invoice->invoice_file;
                              $inv->save();
                         }
                    }

                    return $this->redirect($this->buildLink('ads-manager/invoices'));
               }
          }

          $viewParams = [
               'invoice' => $invoice
          ];

          return $this->view('Siropu\AdsManager:Invoice\Upload', 'siropu_ads_manager_invoice_upload', $viewParams);
     }
     public function actionStatistics()
     {
          $currency   = $this->filter('currency', 'str');
          $currencies = $this->getInvoiceRepo()->getRevenewPerCurrency();

          if ($currencies)
          {
               $first = current($currencies);
               $currency = $currency ?: $first['cost_currency'];
          }

          $viewParams = [
               'statistics' => $this->getInvoiceRepo()->getStatistics($currency),
               'currencies' => $currencies,
               'currency'   => $currency
          ];

          return $this->view('Siropu\AdsManager:Invoice\Stats', 'siropu_ads_manager_invoice_stats', $viewParams);
     }
     protected function invoiceAddEdit(\Siropu\AdsManager\Entity\Invoice $invoice)
	{
          $profiles = $this->getPaymentRepo()
               ->findPaymentProfilesForList()
               ->pluckFrom('title', 'payment_profile_id');

          $viewParams = [
               'invoice'    => $invoice,
               'ads'        => $this->getAdRepo()->getAdNamePairs(),
               'promoCodes' => $this->getPromoCodeRepo()->getPromoCodePairs(),
               'profiles'   => $profiles
          ];

          return $this->view('Siropu\AdsManager:Invoice\Edit', 'siropu_ads_manager_invoice_edit', $viewParams);
     }
     protected function invoiceSaveProcess(\Siropu\AdsManager\Entity\Invoice $invoice)
	{
          $input = $this->filter([
               'ad_id'              => 'uint',
               'username'           => 'str',
               'cost_amount'        => 'float',
               'cost_currency'      => 'str',
               'payment_profile_id' => 'uint',
               'status'             => 'str'
          ]);

          if ($invoice->isUpdate())
          {
               unset($input['ad_id'], $input['username']);
          }

          $form = $this->formAction();
          $form->basicEntitySave($invoice, $input);

          if ($invoice->isInsert())
          {
               $form->validate(function(FormAction $form) use ($invoice, $input)
               {
                    if (!$input['ad_id'])
                    {
                         $form->logError(\XF::phrase('siropu_ads_manager_ad_is_required'));
                    }

                    if (!$input['username'])
                    {
                         $form->logError(\XF::phrase('siropu_ads_manager_advertiser_is_required'));
                    }
                    else if (!$this->getAdvertiserFromUsername())
                    {
                         $form->logError(\XF::phrase('siropu_ads_manager_sepecified_advertiser_not_found'));
                    }

                    if (!$input['cost_amount'])
                    {
                         $form->logError(\XF::phrase('siropu_ads_manager_amount_is_required'));
                    }
               });

               $form->setup(function() use ($invoice, $input)
               {
                    $user = $this->getAdvertiserFromUsername();

                    if ($user)
                    {
                         $invoice->bulkSet([
                              'user_id'  => $user->user_id,
                              'username' => $user->username
                         ]);
                    }
               });
          }

		return $form;
     }
     protected function getAdvertiserFromUsername()
     {
          return $this->em()->findOne('XF:User', ['username' => $this->filter('username', 'str')]);
     }
}
