<?php

$dir = __DIR__;
require($dir . '/src/XF.php');

XF::start($dir);
$app = XF::setupApp('XF\Pub\App');

// $secret = 'Mabcdas122olkdd';
// $txid = $_GET['txid'];
// $value = $_GET['value'];
$status = $_GET['status'];
$addr = $_GET['addr'];
$uuid = $_GET['uuid'];

//Match secret for security
// if ($_GET['secret'] != $secret) {
//     return;
// }

if ($status != 2) {
    //Only accept confirmed transactions
    return;
}

// $app = XF::setupApp('XF\Pub\App');

// var_dump($app);
// exit;


$blockonomicsApiKey = \XF::options()->fs_bitcoin_blockonomics_api_key;

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, "https://www.blockonomics.co/api/merchant_order/" . $uuid);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $blockonomicsApiKey,
]);

$server_output = curl_exec($curl);

// $resCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// $this->CheckRequestError($resCode);

curl_close($curl);

$response = json_decode($server_output, true);

if ($response) {

    $userId = $response["data"]["Custom Field1"];
    $groupId = $response["data"]["Custom Field2"];

    $user = $app->em()->find('XF:User', $userId);

    echo "<pre>";
    var_dump($user);
    exit;
} else {
    return;
}

echo "<pre>";
var_dump($response["data"]["Custom Field1"]);
exit;

// $provider = $app->em()->find('XF:PaymentProvider', $providerId);


// return $getVideoRes["encodeProgress"] >= 50 ? true : false;

// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => 'eb6ee4da6f3d43bbb77c',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'GET',
//     CURLOPT_HTTPHEADER => array(
//         'Authorization: Bearer kGcaPQnzuAR9HaWthz1CHK1n5k5S1MfqIoTDa4QnLx4'
//     ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// // echo $response;

// echo "<pre>";
// var_dump($response);
// exit;


// $db = new SQLite3('payments_db.sqlite', SQLITE3_OPEN_READWRITE);

// //Mark address in database as paid
// $stmt = $db->prepare("UPDATE payments set addr=:addr,txid=:txid," .
//     "value=:value where addr=:addr");
// $stmt->bindParam(":addr", $addr);
// $stmt->bindParam(":txid", $txid);
// $stmt->bindParam(":value", $value);
// $stmt->execute();
