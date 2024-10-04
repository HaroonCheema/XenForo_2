<?php

$dir = __DIR__;
require ($dir . '/src/XF.php');

XF::start($dir);
$app = XF::setupApp('XF\Pub\App');

require_once __DIR__.'/src/addons/FH/RazorpayIntegration/vendor/autoload.php';
            
use Razorpay\Api\Api;

$response = $app->response();
$response->contentType('text/plain');
$request = $app->request();


    $options = $app->options();

    if(isset($_POST['razorpay_payment_id']) && isset($_POST['razorpay_signature']))
    {

        $apiKey = $options->fh_razorpayKeyId;
        $apiSecret = $options->fh_razorpayKeySecret;

        if (!$apiKey || !$apiSecret)
        {
            $errorPhrase = \XF::phrase('fh_razorpay_key_id_and_key_secret_must_be_provide_in_option_to_perform_payment_with_razorpay');

            throw $app->exception($errorPhrase);
        }

        $api = new Api($apiKey, $apiSecret);

        $razorpayOrderId = $_POST['razorpay_order_id'];
        $razorpayPaymentId = $_POST['razorpay_payment_id'];
        $razorpaySignature = $_POST['razorpay_signature'];


        $razorpayVarify = $api->utility->verifyPaymentSignature(array('razorpay_order_id' => $razorpayOrderId, 'razorpay_payment_id' => $razorpayPaymentId, 'razorpay_signature' => $razorpaySignature));

        // PaymentSignature verified


        if ($razorpayPaymentId)
        {

                // try to set cookie here but could not be set,so thats why I Send this $razorpayPaymentId with url and set this Cookie in next step

                    // $response->setCookie('razorpayPaymentId', $razorpayPaymentId, 86400);
                    // setcookie("razorpayPaymentId", $razorpayPaymentId, 86400, "/",'',false, false);

                // get $razorpayPaidRegis record
                $razorpayPaidRegis = $app->finder('FH\RazorpayIntegration:PaidRegistrations')
                                    ->where('razorpay_payment_id', $razorpayPaymentId)
                                    ->where('user_upgrade_record_id', 0)
                                    ->fetchOne();

                if (!$razorpayPaidRegis)
                {
                        //get userUpgradeId
                        $userUpgradeId = $request->filter('userUpgradeId', 'uint');

                        $paidRegistrations = $app->em()->create('FH\RazorpayIntegration:PaidRegistrations');
                        $paidRegistrations->user_upgrade_id = $userUpgradeId;
                        $paidRegistrations->razorpay_order_id = $razorpayOrderId;
                        $paidRegistrations->razorpay_payment_id = $razorpayPaymentId;
                        $paidRegistrations->razorpay_signature = $razorpaySignature;
                        $paidRegistrations->save();
                }
                
                
                $parameters= [
                    'razorpay' => md5('xen$123@razorpay.'),
                    'razorpayPaymentId' => $razorpayPaymentId
                    
                ];
                
                $url = $app->router()->buildLink('paidregistrations/razorpay-confirm', null, $parameters);

//                $url = $options->boardUrl.'/index.php/paidregistrations/razorpay-confirm/?razorpay=1&razorpayPaymentId='.$razorpayPaymentId;
                
                header("Location: ".$url);

                exit;
//			return $this->view('FH\RazorpayIntegration:Index', 'andy_paid_registrations_confirm');
        }

//		return $this->error(\XF::phrase('error'));     

    }
    else 
    {
            echo 'Request is not coming from Razorpay callback';
    }

    exit;