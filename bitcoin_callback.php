<?php

echo "hello";
exit;

$secret = 'Mabcdas122olkdd';
$txid = $_GET['txid'];
$value = $_GET['value'];
$status = $_GET['status'];
$addr = $_GET['addr'];

//Match secret for security
if ($_GET['secret'] != $secret) {
    return;
}

if ($status != 2) {
    //Only accept confirmed transactions
    return;
}

$db = new SQLite3('payments_db.sqlite', SQLITE3_OPEN_READWRITE);

//Mark address in database as paid
$stmt = $db->prepare("UPDATE payments set addr=:addr,txid=:txid," .
    "value=:value where addr=:addr");
$stmt->bindParam(":addr", $addr);
$stmt->bindParam(":txid", $txid);
$stmt->bindParam(":value", $value);
$stmt->execute();
