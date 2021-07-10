<?php

$isDebug = true;
include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/Helpers/ApiConnectionHelper.php";
include __DIR__ . "/Helpers/FlatFileDatabaseHelper.php";
include __DIR__ . "/config.php";
$apiConnection = new ApiConnectionHelper([
    'host' => HOST,
    'user' => USER,
    'pass' => PASS,
    'port' => PORT]);
$apiConnection->setInterface(_INTERFACE_);
$flatFile = new FlatFileDatabaseHelper();
$i = 0;
while (1) {
    $i++;
    $rxTx = $apiConnection->getRxTx();
    print_r($rxTx);
    $rxTx["date"] = FlatFileDatabaseHelper::createCollectionName();
    $rxTx["time"] = date("H:m:s");
    $flatFile->addNewRow($rxTx);
    echo $rxTx["time"];
    sleep(SLEEP_SECONDS);//performance test
    if ($isDebug) {
        if ($i > 250) {
            die("die");
        }
    }
}

