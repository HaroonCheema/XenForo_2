<?php

namespace XenBulletins\PaySeraIntegration\XF\Pub\Controller;
require_once __DIR__ . '/../../../libwebtopay/WebToPay.php';
use XF\Mvc\ParameterBag;
//use XF\Purchasable\Purchase;


class Account extends XFCP_Account {

    
    public function actionUpgradePurchase() {
    
	    $session = $this->session();             
	    $providerId = $session->get('provider_id');

	    if(isset($providerId))
	    {
	    	$this->validatePayseraResponce();
	    	$session->remove('provider_id');
	    }

        return parent::actionUpgradePurchase();
    }


    protected function upgradeUser($response)
    {
        $userId = $response['orderid'];
        $userUpgradeId = $response['userupgradeid'];
        
        $upgrade = $this->em()->find('XF:UserUpgrade', $userUpgradeId);

            if(!$upgrade)
            {
                throw $this->exception($this->error(\XF::phrase('requested_user_upgrade_not_found')));
            }

            $user = $this->em()->findOne('XF:User', ['user_id' => $userId]);
            if (!$user)
            {
                throw $this->exception($this->error(\XF::phrase('requested_user_not_found')));
            }

            $endDate =  $response['enddate'];

            /** @var \XF\Service\User\Upgrade $upgradeService */
            $upgradeService = $this->service('XF:User\Upgrade', $upgrade, $user);
            $upgradeService->setEndDate($endDate);
            $upgradeService->ignoreUnpurchasable(true);
            $upgradeService->upgrade();

//            return $this->redirect($this->buildLink('user-upgrades'));
    }

        public function isPaymentValid(array $order, array $response)
        {
            if (array_key_exists('payamount', $response) === false) 
            {
                if ($order['amount'] !== $response['amount'] || $order['currency'] !== $response['currency']) {
                    
                    throw $this->exception($this->error(\XF::phrase('wrong_payment_amount')));
                }
            } 
            else 
            {
                if ($order['amount'] !== $response['payamount'] || $order['currency'] !== $response['paycurrency']) {

                    throw $this->exception($this->error(\XF::phrase('wrong_payment_amount')));
                }
            }

            return true;
        }

        public function  validatePayseraResponce()
        {
            
            $paymentProfile = $this->finder('XF:PaymentProfile')->where('provider_id','paysera')->fetchOne();
            $projectId = $paymentProfile->options['project_id'];
            $projectPassword = $paymentProfile->options['project_password'];
            
                $response = \WebToPay::validateAndParseData(
                    $_REQUEST,
                    $projectId,
                    $projectPassword

                );
             


                if ($response['status'] === '1' || $response['status'] === '3') {

                    $userUpgradeId = $response['userupgradeid'];

                    $userUpgradeData = $this->finder('XF:UserUpgrade')->where('user_upgrade_id',$userUpgradeId)->fetchOne();
                    
                    $order = [
                            'amount' => str_replace(".", "", $userUpgradeData->cost_amount),
                            'currency' => $userUpgradeData->cost_currency,
                        ];
                    
                    $validPament = $this->isPaymentValid($order, $response);
                    if($validPament)
                    {
                        $this->upgradeUser($response);
                    }

                } else {
                    
                    throw $this->exception($this->error(\XF::phrase('payment_was_not_successful')));
                }

        }
}
