<?php

namespace FH\RazorpayIntegration\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class UserUpgrade extends XFCP_UserUpgrade
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['fh_paid_registrations_razorpay'] = ['type' => self::INT, 'default' => 0];

        return $structure;
    }




    //    public function getRazorpayCheckOutOptions()
    //    {
    ////        var options = {
    ////            "key": "rzp_test_49biDt42BfhO1x", // Enter the Key ID generated from the Dashboard
    //////            "amount": "50000", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    //////            "currency": "INR",
    ////            "name": "XenForo Paid Ragistarion", //your business name
    ////            "description": "Test Transaction",
    ////            "image": "http://localhost/xf226/styles/default/xenforo/xenforo-favicon.png",
    ////            "order_id": "order_MssvaWwyjaLwjP", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    ////            "callback_url": "http://d953-39-35-53-244.ngrok-free.app/sandbox/razorpay/paycallback.php",
    ////        //    "prefill": {
    ////        //        "name": "Gaurav Kumar",
    ////        //        "email": "gaurav.kumar@example.com",
    ////        //        "contact": "9000090000"
    ////        //    },
    ////            "notes": {
    ////                "address": "Razorpay Corporate Office"
    ////            },
    ////            "theme": {
    ////                "color": "#3399cc"
    ////            }
    ////        };
    //        
    //        
    ////        \XF::optin
    //        
    //        $razorPayOptions= [
    //            'key'=> "rzp_test_49biDt42BfhO1x",
    //            "name"=> "XenForo Paid Ragistarion", //your business name
    //            "description" => "Test Transaction",
    //            "image" => "http://localhost/xf226/styles/default/xenforo/xenforo-favicon.png",
    //            "order_id" => "order_MssvaWwyjaLwjP", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    //            "callback_url" => "http://d953-39-35-53-244.ngrok-free.app/sandbox/razorpay/paycallback.php",
    //            "notes"=> [
    //                "address"=> "Razorpay Corporate Office"
    //            ],
    //            "theme"=> [
    //                "color"=> "#3399cc"
    //            ]
    //        ];
    //        
    //        $razorPayOptions = json_encode($razorPayOptions,true);
    //        
    //        return $razorPayOptions;
    //        
    ////        var_dump($razorPayOptions);exit;
    //    }
}
