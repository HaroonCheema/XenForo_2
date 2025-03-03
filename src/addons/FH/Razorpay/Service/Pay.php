<?php

namespace FH\Razorpay\Service;

require __DIR__ . '../../vendor/autoload.php';

use Razorpay\Api\Api;

class Pay extends \XF\Service\AbstractService {

    public function razorPay($apiKey, $apiSecret) {

        return new Api($apiKey, $apiSecret);
    }
}
