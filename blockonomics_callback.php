<?php

$dir = __DIR__;
require($dir . '/src/XF.php');

XF::start($dir);
$app = XF::setupApp('XF\Pub\App');

$status = $_GET['status'];
$addr = $_GET['addr'];
$uuid = $_GET['uuid'];

if ($status != 2) {
    //Only accept confirmed transactions
    return;
}

$blockonomicsApiKey = \XF::options()->fs_bitcoin_blockonomics_api_key;

if (!$blockonomicsApiKey) {
    return;
}

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, "https://www.blockonomics.co/api/merchant_order/" . $uuid);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $blockonomicsApiKey,
]);

$server_output = curl_exec($curl);

$resCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);



curl_close($curl);

$response = json_decode($server_output, true);




if ($response && $resCode == 200) {

    if (isset($response['status']) && ($response['status'] == -1 || $response['status'] == 0 || $response['status'] == 1)) {

        return;
    }



    if (!isset($response['data']['extra_data'])) {

        return;
    }

    $encrypt = $response["data"]["extra_data"];

    $data = decrypt($encrypt);


    $userUpgradeGroupId = $data["groupId"];
    $userId = $data["userId"];
    $id = $data["id"];
    $createdAt = $data["createdAt"];

    $upgrade = $app->em()->find('XF:UserUpgrade', $userUpgradeGroupId);




    if (!$upgrade) {

        return;
    }

    if ($upgrade['length_amount'] == 0) {
        $oneMonthLaterTimestamp = 0;
    } else {

        $oneMonthLaterTimestamp = strtotime('+' . $upgrade['length_amount'] . '' . $upgrade['length_unit'], $createdAt);
    }


    $recExist = $app->em()->find('FS\BitcoinIntegration:PurchaseRec', $id);


    if ($recExist && $recExist["user_id"] == $userId && $recExist["user_upgrade_id"] == $userUpgradeGroupId) {

        $user = $app->em()->find('XF:User', $userId);
        $upgrade = $app->em()->find('XF:UserUpgrade', $userUpgradeGroupId);


        if ($user && $upgrade) {
            $upgradeService = \XF::app()->service('XF:User\Upgrade', $upgrade, $user);
            $upgradeService->setEndDate($oneMonthLaterTimestamp);
            $upgradeService->ignoreUnpurchasable(true);
            $upgradeService->upgrade();

            $purchaseUpdate = [
                'status' => 2,
                'end_at' => $oneMonthLaterTimestamp
            ];

            $recExist->fastUpdate($purchaseUpdate);

            return true;

            // $redirect = $app->router('public')->buildLink('register/connected-accounts', $provider);
        }
    }
} else {
    return;
}

function decrypt($hex)
{
    $text = pack('H*', $hex);

    if (!$text) {
        return false;
    }

    $data = @json_decode($text, true);

    if (!is_array($data)) {
        return false;
    }

    $response = [
        'id' => $data[0],
        'userId' => $data[1],
        'groupId' => $data[2],
        'createdAt' => $data[3],
    ];

    return $response;
}
