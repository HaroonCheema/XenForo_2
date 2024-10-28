<?php

$dir = __DIR__;
require ($dir . '/src/XF.php');

XF::start($dir);
$app = XF::setupApp('XF\Pub\App');

$response = $app->response();
$response->contentType('text/plain');
$request = $app->request();

$webhookData = file_get_contents('php://input');

// Specify the file where the webhook response will be saved
$filename = 'webhook_response.txt';

$file = fopen($filename, 'a');

// Write the received webhook data into the file
fwrite($file, date("Y-m-d H:i:s") . " - " . $webhookData . "\n");

// Close the file
fclose($file);

$meetingSer = $app->service('FS\ZoomMeeting:Meeting');

// Assume you have the following variables defined
$ZOOM_WEBHOOK_SECRET_TOKEN = $app->options()->webhook_secret_key;

$requestBody = json_decode(file_get_contents('php://input'), true); // Get the request body
// Check if the webhook request event type is a challenge-response check
if (isset($requestBody['event']) && $requestBody['event'] === 'endpoint.url_validation') {
    $plainToken = $requestBody['payload']['plainToken'];
    $hashForValidate = hash_hmac('sha256', $plainToken, $ZOOM_WEBHOOK_SECRET_TOKEN);

    // Send response
    http_response_code(200);
    echo json_encode([
        "plainToken" => $plainToken,
        "encryptedToken" => $hashForValidate,
    ]);
}


if (isset($requestBody['event']) && $requestBody['event'] === 'meeting.participant_joined') {

    $accountId = $requestBody['payload']['account_id'] ?? '';
    $meetingId = $requestBody['payload']['object']['id'] ?? '';
    $userName = $requestBody['payload']['object']['participant']['user_name'] ?? '';
    $participant_uuid = $requestBody['payload']['object']['participant']['participant_uuid'] ?? '';
    $email = $requestBody['payload']['object']['participant']['email'] ?? '';

    $meetingSer->joinMeeting($userName, $email, $participant_uuid, $meetingId);
}

//particpant meeting left

if (isset($requestBody['event']) && $requestBody['event'] === 'meeting.participant_left') {

    $accountId = $requestBody['payload']['account_id'] ?? '';
    $meetingId = $requestBody['payload']['object']['id'] ?? '';
    $userName = $requestBody['payload']['object']['participant']['user_name'] ?? '';
    $participant_uuid = $requestBody['payload']['object']['participant']['participant_uuid'] ?? '';
    $email = $requestBody['payload']['object']['participant']['email'] ?? '';

    $meetingSer->leftMeeting($participant_uuid, $meetingId);
}
if (isset($requestBody['event']) && $requestBody['event'] === 'meeting.ended') {

    $accountId = $requestBody['payload']['account_id'] ?? '';
    $meetingId = $requestBody['payload']['object']['id'] ?? '';
    $meetingSer->endMeeting($meetingId);
}





