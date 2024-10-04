<?php

namespace FH\RazorpayIntegration\Andy\PaidRegistrations\Pub\Controller;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Razorpay\Api\Api;


class PaidRegistrations extends XFCP_PaidRegistrations
{

    protected $api;


    public function actionIndex()
    {
        //================================ // shows various registration options ========================

        // get visitor
        $visitor = \XF::visitor();

        // get userId
        $userId = $visitor->user_id;

        if ($userId) {
            return $this->redirect($this->buildLink('index'));
        }


        //========================== For those users who's payment has done but could not complete registration process due to any reason (available for 24 hours from payment) =====================

        // ================== For Razorpay payments ===============

        $razorpayPaymentId = \XF::app()->request->getCookie('razorpayPaymentId');  // get cookie

        if ($razorpayPaymentId) {
            // get $razorpayPaidRegis record
            $razorpayPaidRegis = $this->finder('FH\RazorpayIntegration:PaidRegistrations')
                ->where('razorpay_payment_id', $razorpayPaymentId)
                ->where('user_upgrade_record_id', 0)
                ->fetchOne();

            // an extra check to make sure user againts this $razorpayPaymentId not exist;
            $razorpayAssosiateUser = $this->finder('XF:User')->where('razorpay_payment_id', $razorpayPaymentId)->fetchOne();

            if ($razorpayPaidRegis && !$razorpayAssosiateUser) {
                return $this->view('Andy\PaidRegistrations:RazorpayConfirm', 'fh_paid_registrations_confirm');
            }
        }

        // ================== For Stripe payments ===============

        $checkoutSessionId = \XF::app()->request->getCookie('stripe'); // get cookie

        if ($checkoutSessionId) {
            // get $stripePaidRegis record
            $stripePaidRegis = \XF::finder('Andy\PaidRegistrations:PaidRegistrations')
                ->where('checkout_session_id', $checkoutSessionId)
                ->where('user_upgrade_record_id', 0)
                ->fetchOne();

            if ($stripePaidRegis) {
                return $this->view('Andy\PaidRegistrations:RazorpayConfirm', 'fh_paid_registrations_confirm');
            }
        }

        //----------------------------------------------------------------------------------------------------------------------------




        // get results
        $finder = \XF::finder('XF:UserUpgrade');
        $results = $finder
            ->whereOr(
                ['andy_paid_registrations_stripe', '<>', ''],
                ['fh_paid_registrations_razorpay', 1]
            )
            ->order('display_order', 'ASC')
            ->fetch();



        $viewParams = [
            'results' => $results,
            'userId' => $userId
        ];

        return $this->view('Andy\PaidRegistrations:Index', 'fh_paid_registrations', $viewParams);
    }



    public function actionCreateOrder()   //  Create Order on Razorpay and redirect to Razorpay checkout
    {

        $options = \XF::options();

        // get userUpgradeId
        $userUpgradeId = $this->filter('userUpgradeId', 'uint');

        $userUpgrade = $this->em()->find('XF:UserUpgrade', $userUpgradeId);

        $apiKey = $options->fh_razorpayKeyId;
        $apiSecret = $options->fh_razorpayKeySecret;

        if (!$apiKey || !$apiSecret) {
            $errorPhrase = \XF::phrase('fh_razorpay_key_id_and_key_secret_must_be_provide_in_option_to_perform_payment_with_razorpay');

            throw $this->exception($errorPhrase);
        }


        $api = new Api($apiKey, $apiSecret);

        $this->api = $api;


        $orderData = [
            //            'receipt'         => 'xenUser',
            'amount' => (int)str_replace(".", "", $userUpgrade->cost_amount),
            'currency' => $userUpgrade->cost_currency,

        ];



        $razorpayOrder = $api->order->create($orderData);

        $orderId =  $razorpayOrder['id'];

        $razorPayOptions = [
            'key' => $apiKey,
            "name" => $userUpgrade->title,
            "description" => $userUpgrade->description ?: 'Paid Registration',
            "image" => \XF::app()->options()->boardUrl . "/styles/default/xenforo/xenforo-favicon.png",
            "order_id" => $orderId,
            "callback_url" => $this->getCallbackUrl() . '?userUpgradeId=' . $userUpgradeId,
            "notes" => [
                "userUpgradeId" => $userUpgradeId
            ],
            "theme" => [
                "color" => "#3399cc"
            ]
        ];

        $this->setResponseType('json');

        $view = $this->view();
        $view->setJsonParam('razorpayOptions', $razorPayOptions);
        return $view;
    }



    public function getCallbackUrl()
    {
        return \XF::app()->options()->boardUrl . '/rzp_payment_callback.php';

        //        $redirectUri = \XF::app()->router()->buildLink('rzp_payment_callback.php');
    }





    public function actionRazorpayConfirm()
    {

        //        $this->assertPostOnly();


        if (\XF::visitor()->user_id) {
            return $this->redirect($this->getDynamicRedirect());
        }

        $razorpay = $this->filter('razorpay', 'str');
        $razorpayPaymentId = $this->filter('razorpayPaymentId', 'str');


        if (!$razorpay || !$razorpayPaymentId || $razorpay != md5('xen$123@razorpay.')) {
            throw $this->exception($this->error(\XF::phrase('fh_action_available_via_razorpay_callback_only'), 405));
        }


        // get $razorpayPaidRegis record
        $razorpayPaidRegis = $this->finder('FH\RazorpayIntegration:PaidRegistrations')
            ->where('razorpay_payment_id', $razorpayPaymentId)
            ->where('user_upgrade_record_id', 0)
            ->fetchOne();


        // an extra check to make sure user againts this $razorpayPaymentId not exist;
        $razorpayAssosiateUser = $this->finder('XF:User')->where('razorpay_payment_id', $razorpayPaymentId)->fetchOne();


        if (!$razorpayPaidRegis || $razorpayAssosiateUser) {
            throw $this->exception($this->error(\XF::phrase('fh_razorpayPaidRegis_record_not_found')));
        }


        // set cookie
        $this->app->response()->setCookie('razorpayPaymentId', $razorpayPaymentId, 86400);

        return $this->view('Andy\PaidRegistrations:RazorpayConfirm', 'fh_paid_registrations_confirm');
    }



    public function actionAdmin()
    {
        //################################################################################
        // view paid registrations
        //################################################################################

        // get visitor
        $visitor = \XF::visitor();

        // check permission
        if (!\XF::visitor()->is_admin) {
            return $this->noPermission();
        }

        // get options
        $options = \XF::options();

        // get options from Admin CP -> Options -> Paid registrations -> Limit
        $limit = $options->paidRegistrationsLimit;

        // get results
        $finder = \XF::finder('Andy\PaidRegistrations:PaidRegistrations');
        $results = $finder
            ->order('dateline', 'DESC')
            ->limit($limit)
            ->fetch();


        // get results
        $finder = \XF::finder('Andy\PaidRegistrations:PaidRegistrations');
        $results = $finder
            ->order('dateline', 'DESC')
            ->limit($limit)
            ->fetch();


        // get $razorpayPaidRegis record
        $razorpayPaidRegistrations = $this->finder('FH\RazorpayIntegration:PaidRegistrations')
            ->order('date', 'DESC')
            ->limit($limit)
            ->fetch();


        $viewParams = [
            'limit' => $limit,
            'results' => $results,
            'razorpayPaidRegistrations' => $razorpayPaidRegistrations
        ];

        // send to template
        return $this->view('Andy\PaidRegistrations:Admin', 'fh_paid_registrations_admin', $viewParams);
    }
}
