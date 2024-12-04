<?php

namespace FS\ExtendThreadCredits\Admin\Controller;

use ThemeHouse\ThreadCredits\Entity\CreditPackage as CreditPackageEntity;
use ThemeHouse\ThreadCredits\Repository\CreditPackage as CreditPackageRepository;
use ThemeHouse\ThreadCredits\Service\CreditPackage\Purchase;
use XF\Admin\Controller\AbstractController;
use XF\ControllerPlugin\Delete;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Entity\User as BaseNode;
class DeletePurchaseLog extends AbstractController
{
    public function actionDeletePurchase(ParameterBag $params)
    {
        // var_dump($params);exit;
        $creditPackage = $this->assertUserCreditPackageExists($params['user_credit_package_id']);
        // var_dump( $creditPackage);exit;
        $packageName = $creditPackage->CreditPackage->title ?? 'Unknown Package';
        $visitorId = \XF::visitor()->user_id;
        // var_dump($packageName);exit;
        if($this->isPost()){

            $reason=$this->filter('reason','str');
            $db = $this->app()->db();
            $db->insert('xf_deleted_user_purchase_log', [
                'user_credit_package_id'=>$creditPackage->user_credit_package_id,
                'credit_package_id'=>$creditPackage->CreditPackage->credit_package_id,
                'purchase_request_key'=>$creditPackage->purchase_request_key,
                'extra' => json_encode($creditPackage->extra),
                'total_credits'=>$creditPackage->total_credits,
                'used_credits'=>$creditPackage->used_credits,
                'remaining_credits'=>$creditPackage->remaining_credits,
                'purchased_at'=>$creditPackage->purchased_at,
                'expires_at'=>$creditPackage->expires_at,
                'user_id' => $creditPackage->User->user_id,
                'package_name' => $packageName,
                'visitor_id' => $visitorId,
                'reason_of_deletion' => $reason,
                'time' => \XF::$time
            ]);
            $creditPackage->delete();
            return $this->redirect($this->buildLink('delete-purchase-log/delete-list', $creditPackage), \XF::phrase('purchase_log_deleted_successfully'));
        }
    $viewParams = [
    'creditPackage'=> $creditPackage,
    ];
 
    return $this->view('FS\ExtendThreadCredits:DeletePurchaseLog', 'purchase_log_delete', $viewParams);
    }
    protected function assertUserCreditPackageExists($id, $with = null, $phraseKey = null)
    {
        
        return $this->assertRecordExists('ThemeHouse\ThreadCredits:UserCreditPackage', $id, $with, $phraseKey);
    }
    public function actionDeleteList(ParameterBag $params)
    {

        // Fetching all data from the xf_deleted_user_purchase_log table
        $deletedPurchaseFinder = $this->finder('FS\ExtendThreadCredits:DeletedUserPurchaseLog')->with('User'); // Adjust this based on your requirements
        // Fetch all records without pagination
        $deletedPurchases = $deletedPurchaseFinder->fetch();
        $page = $params->page;
        $perPage = 15;
        $deletedPurchaseFinder->limitByPage($page, $perPage);
        
        // Prepare view parameters
        $viewParams = [
            'deletedPurchases' => $deletedPurchases,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $deletedPurchases->count(), // Total number of records fetched
        ];
        // var_dump( $deletedPurchaseFinder);exit;
        // // Render the view with the fetched data
        return $this->view('FS\ExtendThreadCredits:CreditPackage\DeleteList', 'delete_user_purchase_log', $viewParams);
    }
    public function actionConfirmDelete(ParameterBag $params)
    {
        $deletedLog = $this->finder('FS\ExtendThreadCredits:DeletedUserPurchaseLog')
        ->where('user_credit_package_id', $params['user_credit_package_id']) // Assuming you're passing the ID of the deleted log
        ->fetchOne();
        if($this->isPost()){
            $this->actionrestorePurchaseLog($params);
            return $this->redirect($this->buildLink('thtc-credit-package/purchase-log', $deletedLog), \XF::phrase('purchase_log_deleted_successfully'));
        }
    $viewParams = [
    'deletedLog'=> $deletedLog,
    ];
 
    return $this->view('FS\ExtendThreadCredits:DeletePurchaseLog', 'restore_purchase_log', $viewParams);
    }

    public function actionrestorePurchaseLog(ParameterBag $params)
    {
        
        // Fetch the deleted purchase log entry using the provided ID
        $deletedLog = $this->finder('FS\ExtendThreadCredits:DeletedUserPurchaseLog')
            ->where('user_credit_package_id', $params['user_credit_package_id']) // Assuming you're passing the ID of the deleted log
            ->fetchOne();
    
        // Check if the deleted log entry exists
        if (!$deletedLog) {
            return $this->error(\XF::phrase('requested_purchase_log_not_found'));
        }

        $db = $this->app()->db();
        $db->insert('xf_thtc_user_credit_package', [
            'credit_package_id'=>$deletedLog->CreditPackage->credit_package_id,
            'purchase_request_key'=>$deletedLog->purchase_request_key,
           'extra' => is_array($deletedLog->extra) ? json_encode($deletedLog->extra) : $deletedLog->extra, // Ensure it's a JSON string
            'total_credits'=>$deletedLog->total_credits,
            'used_credits'=>$deletedLog->used_credits,
            'remaining_credits'=>$deletedLog->remaining_credits,
            'purchased_at'=>$deletedLog->purchased_at,
            'expires_at'=>$deletedLog->expires_at,
            'user_id' => $deletedLog->User->user_id,
    
        ]);
        $db->delete('xf_deleted_user_purchase_log', 'user_credit_package_id = ?', $deletedLog->user_credit_package_id);
        return $this->redirect($this->buildLink('thtc-credit-package/purchase-log',$deletedLog), \XF::phrase('purchase_log_restored_successfully'));
    
    }
}