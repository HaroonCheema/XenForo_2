<?php

namespace FS\ExtendThreadCredits\Admin\Controller;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use ThemeHouse\ThreadCredits\Entity\CreditPackage as CreditPackageEntity;
use ThemeHouse\ThreadCredits\Repository\CreditPackage as CreditPackageRepository;
use ThemeHouse\ThreadCredits\Service\CreditPackage\Purchase;
use XF\Admin\Controller\AbstractController;
class CreditPackage extends XFCP_CreditPackage
{

    public function actionPurchaseLog(ParameterBag $params): View
    {
        $filter = $this->filter('filter', 'int');
    
        if (!$filter) {
            return parent::actionPurchaseLog($params);
        } else {

            $filters = [
                'username' => $this->filter('username', 'str'),
                'purchase_type' => $this->filter('purchase_type', 'str'),
                'start' => $this->filter('start', 'datetime'),
                'end' => $this->filter('end', 'datetime'),
            ];

            return $this->actionpurchaseFilter($params, $filters);
        }
    }
 
    
    public function actionpurchaseFilter(ParameterBag $params, array $filters):View      
    {
        // var_dump('sds');
        $creditPackage = $this->assertCreditPackageExists($params['credit_package_id']);
        
        $linkFilters = [];
        $page = $this->filterPage();
        $perPage = 15;
    
        $finder = $this->getCreditPackageRepo()
            ->findUserCreditPackagesForCreditPackage($creditPackage)
            ->with('User')
            ->with('PurchaseRequest');
    
       
            if (!empty($filters['username'])) {
                $finder->where('User.username', 'LIKE', $finder->escapeLike($filters['username'], '%?%'));
                $linkFilters['username'] = $filters['username'];  
            }
        
            if (!empty($filters['purchase_type'])) {
                $purchaseType = $filters['purchase_type'];
                if ($purchaseType === 'credit_purchase') {
                    $finder->where('purchase_request_key', '!=', null); 
                } elseif ($purchaseType === 'manually_granted') {
                    $finder->where('purchase_request_key', '=', null); 
                }
                $linkFilters['purchase_type'] = $purchaseType;
            }
        
            if (!empty($filters['start'])) {
                $finder->where('purchased_at', '>=', $filters['start']); 
                $linkFilters['start'] = $filters['start']; 
            }
        
            if (!empty($filters['end'])) {
                $finder->where('purchased_at', '<=', $filters['end'] + 86400); 
                $linkFilters['end'] = $filters['end']; 
            }
            $finder->limitByPage($page, $perPage);
            $total = $finder->total();
            $this->assertValidPage($page, $perPage, $total, 'credit_packages');
    
    

        $viewParams = [
            'username' => $filters['username'] ?? null,
            'purchase_type' => $filters['purchase_type'] ?? null,
            'start' => $filters['start'] ?? null,
            'end' => $filters['end'] ?? null,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'creditPackage' => $creditPackage,
            'purchases' => $finder->fetch(),
            'linkFilters' => $linkFilters,
        ];
         return $this->view('ThemeHouse\ThreadCredits:CreditPackage\PurchaseLog', 'thtc_credit_package_purchase_log', $viewParams);
    }
   
   
	 public function actionPurchaseExport(ParameterBag $params)
	 {
      
		// TODO: we could intercept this request and ask which data fields to export, but for now add-ons can extend the ExportListing class to get data outside the default

		$viewParams = $this->getListData(true,$params);
		$this->setResponseType('raw');
		return $this->view('FS\ExtendThreadCredits:Purchase\ExportListing', '', $viewParams);
	}




    protected function getListData($forExport,$params)
    {
        $filters = [
            'username' => $this->filter('username', 'str'),
            'purchase_type' => $this->filter('purchase_type', 'str'),
            'start' => $this->filter('start', 'datetime'),
            'end' => $this->filter('end', 'datetime'),
        ];

       
        // var_dump('sds');
        $creditPackage = $this->assertCreditPackageExists($params['credit_package_id']); 
        
      
        
        $linkFilters = [];
        $page = $this->filterPage();
        $perPage = 15;
    
        $finder = $this->getCreditPackageRepo()
            ->findUserCreditPackagesForCreditPackage($creditPackage)
            ->with('User')
            ->with('PurchaseRequest');
    
       
            if (!empty($filters['username'])) {
                $finder->where('User.username', 'LIKE', $finder->escapeLike($filters['username'], '%?%'));
                $linkFilters['username'] = $filters['username'];  
            }
        
            if (!empty($filters['purchase_type'])) {
                $purchaseType = $filters['purchase_type'];
                if ($purchaseType === 'credit_purchase') {
                    $finder->where('purchase_request_key', '!=', null); 
                } elseif ($purchaseType === 'manually_granted') {
                    $finder->where('purchase_request_key', '=', null); 
                }
                $linkFilters['purchase_type'] = $purchaseType;
            }
        
            if (!empty($filters['start'])) {
                $finder->where('purchased_at', '>=', $filters['start']); 
                $linkFilters['start'] = $filters['start']; 
            }
        
            if (!empty($filters['end'])) {
                $finder->where('purchased_at', '<=', $filters['end'] + 86400); 
                $linkFilters['end'] = $filters['end']; 
            }       
            if ($forExport)
            {
                $purchases = $finder->fetch(); 

              
                $viewParams = [
                    'purchases' => $purchases,
                    'total' => count($purchases),
                ];

                return $viewParams;
            }
            else
            {
                $page = $this->filterPage();
                $perPage = 15;
    
                $finder->limitByPage($page, $perPage);
                $purchases = $finder->fetch();
                $total = $finder->total();
                 $this->assertValidPage($page, $perPage, $total, 'credit_packages');

         return       $viewParams = [
                    'username' => $filters['username'] ?? null,
                    'purchase_type' => $filters['purchase_type'] ?? null,
                    'start' => $filters['start'] ?? null,
                    'end' => $filters['end'] ?? null,
                    'purchases' => $purchases,
                    'total' => $total,
                    'page' => $page,
                    'perPage' => $perPage,
                    'linkFilters' => $linkFilters,
                    'creditPackage' => $creditPackage,
                ];
            }   
       
    }

    public function actionConfirmDelete(ParameterBag $params)
    {
    // Get user_id and username from th
    $userId = $this->filter('user_id', 'int');
    $username = $this->filter('username', 'str');
    // Fetch the purchase log entry using the user_id
    $purchaseLog = $this->finder('ThemeHouse\ThreadCredits:UserCreditPackage')
    ->where('user_id', $userId)
    ->fetchOne();

    
    // var_dump($purchaseLog);exit;
    // Check if the purchase log entry exists
    if (!$purchaseLog) {
    return $this->error(\XF::phrase('requested_purchase_log_not_found'));
    }
    
    $viewParams = [
    'userId'=> $userId,
    'user' => $purchaseLog->User,
    'username' => $username
    ];
    // var_dump($viewParams);
    return $this->view('ThemeHouse\ThreadCredits:CreditPackage', 'purchase_log_delete', $viewParams);
    }
    

 
}