<?php

namespace FH\RazorpayIntegration\XF\Pub\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Razorpay\Api\Api;

class Register extends XFCP_Register
{

    public function actionIndex()
    {

        $parent = parent::actionIndex();

        if (\XF::visitor()->user_id) {
            return $this->redirect($this->getDynamicRedirectIfNot($this->buildLink('register')), '');
        }



        // ================================================== For razorpay payments ====================================================================

        // get cookie
        $razorpayPaymentId = \XF::app()->request->getCookie('razorpayPaymentId');

        if ($razorpayPaymentId) {
            // get $razorpayPaidRegis record
            $razorpayPaidRegis = $this->finder('FH\RazorpayIntegration:PaidRegistrations')
                ->where('razorpay_payment_id', $razorpayPaymentId)
                ->where('user_upgrade_record_id', 0)
                ->fetchOne();

            // an extra check to make sure user againts this $razorpayPaymentId not exist;
            $razorpayAssosiateUser = $this->finder('XF:User')->where('razorpay_payment_id', $razorpayPaymentId)->fetchOne();

            if ($razorpayPaidRegis && !$razorpayAssosiateUser) {
                // =============== get payment information ================

                $options = \XF::options();

                $apiKey = $options->fh_razorpayKeyId;
                $apiSecret = $options->fh_razorpayKeySecret;

                $api = new Api($apiKey, $apiSecret);

                // get paymentInformation
                try {
                    $paymentInformation = $api->payment->fetch($razorpayPaymentId);
                } catch (\Exception $e) {
                    return $this->view('XF\Register:Index', 'fh_registration_not_allowed', []);
                }


                // ================== get user upgrade information ===========================


                $userUpgradeId = $razorpayPaidRegis['user_upgrade_id'];          // get userUpgradeId
                //            $userUpgradeId = $paymentInformation['notes']['userUpgradeId'];  // get userUpgradeId


                // get userUpgrade
                $userUpgrade = \XF::finder('XF:UserUpgrade')
                    ->where('user_upgrade_id', $userUpgradeId)
                    ->fetchOne();


                $captured  = $paymentInformation['captured'];  // check payment is captured

                if ($captured && $userUpgrade) {
                    // ===================== verify user upgrade cost is the same as amount payment amount ===================

                    $paymentAmount = $paymentInformation['amount'];         // get paymentAmount
                    $paymentCurrency = $paymentInformation['currency'];    // get paymentCurrency

                    $costAmount = (int)str_replace(".", "", $userUpgrade->cost_amount);   // get costAmount
                    $costCurrency = $userUpgrade->cost_currency;                          // get costCurrency

                    // check condition
                    if ($costAmount == $paymentAmount && $costCurrency == $paymentCurrency) {
                        return $parent;    // user has been paid registration amount and the payment is valid so return to registration form
                    }
                }
            }
        }


        // ================================================== For stripe payments =======================================================================


        // get cookie
        $checkoutSessionId = \XF::app()->request->getCookie('stripe');

        if ($checkoutSessionId) {
            // get $stripePaidRegis record
            $stripePaidRegis = \XF::finder('Andy\PaidRegistrations:PaidRegistrations')
                ->where('checkout_session_id', $checkoutSessionId)
                ->where('user_upgrade_record_id', 0)
                ->fetchOne();

            if ($stripePaidRegis) {

                //================ get payment information ===============

                $options = \XF::options();

                // get options from Admin CP -> Options -> Paid registrations -> Live secret key
                $liveSecretKey = $options->paidRegistrationsLiveSecretKey;

                // get stripe
                $stripe = new \Stripe\StripeClient($liveSecretKey);

                // get paymentInformation
                try {
                    $paymentInformation = $stripe->checkout->sessions->retrieve($checkoutSessionId, []);
                } catch (\Exception $e) {
                    return $this->view('XF\Register:Index', 'fh_registration_not_allowed', []);
                }

                //===========  get user upgrade information =============

                // get userUpgradeId
                $userUpgradeId = $stripePaidRegis['user_upgrade_id'];

                // get result2
                $userUpgrade = \XF::finder('XF:UserUpgrade')
                    ->where('user_upgrade_id', $userUpgradeId)
                    ->fetchOne();

                if ($userUpgrade) {
                    // =============== verify user upgrade cost is the same as amount payment amount ================

                    $paymentAmount = $paymentInformation['amount_total'];  // get paymentAmount

                    // get costAmount
                    $costAmount = $userUpgrade['cost_amount'] * 100;

                    // check condition
                    if ($costAmount == $paymentAmount) {
                        return $parent;    // user has been paid registration amount and the payment is valid so return to registration form
                    }
                }
            }
        }


        return $this->view('XF\Register:Index', 'fh_registration_not_allowed', []);
    }



    protected function setupRegistration(array $input)
    {

        $registration = parent::setupRegistration($input);


        // ================================================== For Stripe Payments =======================================================================

        // get cookie
        $checkoutSessionId = \XF::app()->request->getCookie('stripe');

        if ($checkoutSessionId) {
            // get $stripePaidRegis record
            $stripePaidRegis = \XF::finder('Andy\PaidRegistrations:PaidRegistrations')
                ->where('checkout_session_id', $checkoutSessionId)
                ->where('user_upgrade_record_id', 0)
                ->fetchOne();

            if ($stripePaidRegis) {
                return $registration;
            }
        }


        // ================================================== For Razorpay Payments =======================================================================

        // get cookie
        $razorpayPaymentId = \XF::app()->request->getCookie('razorpayPaymentId');


        if (!$razorpayPaymentId) {
            return $this->view('XF\Register:Index', 'fh_registration_not_allowed', []);
        }


        // get $razorpayPaidRegis record
        $razorpayPaidRegis = $this->finder('FH\RazorpayIntegration:PaidRegistrations')
            ->where('razorpay_payment_id', $razorpayPaymentId)
            ->where('user_upgrade_record_id', 0)
            ->fetchOne();

        // an extra check to make sure user againts this $razorpayPaymentId not exist;
        $razorpayAssosiateUser = $this->finder('XF:User')->where('razorpay_payment_id', $razorpayPaymentId)->fetchOne();


        if ($razorpayPaidRegis && !$razorpayAssosiateUser) {
            //============= get payment information ================

            $options = \XF::options();

            $apiKey = $options->fh_razorpayKeyId;
            $apiSecret = $options->fh_razorpayKeySecret;

            $api = new Api($apiKey, $apiSecret);

            // get paymentInformation
            try {
                $paymentInformation = $api->payment->fetch($razorpayPaymentId);
            } catch (\Exception $e) {
                return $this->view('XF\Register:Index', 'fh_registration_not_allowed', []);
            }


            //================ get user upgrade information ==============================


            $userUpgradeId = $razorpayPaidRegis['user_upgrade_id'];          // get userUpgradeId
            //            $userUpgradeId = $paymentInformation['notes']['userUpgradeId'];  // get userUpgradeId


            // get userUpgrade
            $userUpgrade = \XF::finder('XF:UserUpgrade')
                ->where('user_upgrade_id', $userUpgradeId)
                ->fetchOne();


            $captured  = $paymentInformation['captured'];  // check payment is captured

            if ($captured && $userUpgrade) {
                //================ verify user upgrade cost is the same as amount payment amount ===============

                $paymentAmount = $paymentInformation['amount'];         // get paymentAmount
                $paymentCurrency = $paymentInformation['currency'];    // get paymentCurrency

                $costAmount = (int)str_replace(".", "", $userUpgrade->cost_amount);   // get costAmount
                $costCurrency = $userUpgrade->cost_currency;                          // get costCurrency

                // check condition
                if ($costAmount == $paymentAmount && $costCurrency == $paymentCurrency) {
                    $registration->forceUserState('valid');    // force UserState to valid
                    return $registration;
                }
            }
        }

        //        return $this->redirect($this->buildLink('paidregistrations'));
        return $this->view('XF\Register:Index', 'fh_registration_not_allowed', []);
    }


    public function actionComplete()
    {

        $complete = parent::actionComplete();

        // ================================================== For Stripe Payments =======================================================================

        $checkoutSessionId = \XF::app()->request->getCookie('stripe'); // get cookie

        if ($checkoutSessionId) {
            $this->app->response()->setCookie('stripe', '', (\XF::$time - 86400));  // delete stripe cookie

            return $complete;  //  return to andy Paid Registration actionComplete
        }


        // ================================================== For Razorpay Payments =======================================================================

        // get cookie
        $razorpayPaymentId = \XF::app()->request->getCookie('razorpayPaymentId');

        if (!$razorpayPaymentId) {
            return $complete;
        }

        // get $razorpayPaidRegis record
        $razorpayPaidRegis = $this->finder('FH\RazorpayIntegration:PaidRegistrations')
            ->where('razorpay_payment_id', $razorpayPaymentId)
            ->where('user_upgrade_record_id', 0)
            ->fetchOne();

        if ($razorpayPaidRegis) {
            $user = \XF::visitor();


            $userUpgradeId = $razorpayPaidRegis->user_upgrade_id;

            // get userUpgrade 
            $userUpgrade = $this->app->find('XF:UserUpgrade', $userUpgradeId);


            $endDate = $userUpgrade->length_amount
                ? strtotime($userUpgrade->length_amount . ' ' . $userUpgrade->length_unit)
                : 0;

            /* @var \XF\Service\User\Upgrade $upgradeService */
            $upgradeService = $this->service('XF:User\Upgrade', $userUpgrade, $user);
            $upgradeService->setEndDate($endDate);
            $upgradeService->ignoreUnpurchasable(true);
            $upgradeService->upgrade();


            // =================== update $razorpayPaidRegis =====================

            // get userUpgradeActive
            $userUpgradeActive = \XF::finder('XF:UserUpgradeActive')
                ->where('user_id', $user->user_id)
                ->fetchOne();

            if ($userUpgradeActive) {

                $data = [
                    'user_upgrade_record_id' => $userUpgradeActive->user_upgrade_record_id
                ];

                // update
                $razorpayPaidRegis->fastUpdate($data);

                $this->app->response()->setCookie('razorpayPaymentId', '', (\XF::$time - 86400));  // delete cookie
            }


            // In future may be need it So assosiate razorpayPaymentId with user

            $user->fastUpdate('razorpay_payment_id', $razorpayPaymentId);   //  Assosiate razorpayPaymentId to newly Registered user (in xf_user table)

        }

        return $complete;
    }
}
