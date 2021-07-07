<?php

include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/ApiConnectionHelper.php";
include __DIR__ . "/FlatFileDatabaseHelper.php";
include __DIR__ . "/config.php";
$apiConnection = new ApiConnectionHelper([
    'host' => HOST,
    'user' => USER,
    'pass' => PASS,
    'port' => PORT]);
$apiConnection->setInterface(_INTERFACE_);
$flatFile = new FlatFileDatabaseHelper();
while (1) {
    $rxTx = $apiConnection->getRxTx();
    print_r($rxTx);
    $flatFile->addNewRow($rxTx);
    sleep(1);
}