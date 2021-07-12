<?php
date_default_timezone_set('Europe/Istanbul');

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
    sleep(SLEEP_SECONDS);//performance test
    if ($isDebug) {
        echo "--" . $i . "--";
        if ($i > 15) {

            die("die");
        }
    }
}

