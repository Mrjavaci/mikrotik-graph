<?php
date_default_timezone_set('Europe/Istanbul');
$isDebug = false;
include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/Helpers/ApiConnectionHelper.php";
include __DIR__ . "/Helpers/FlatFileDatabaseHelper.php";
include __DIR__ . "/config.php";
$apiConnection = new ApiConnectionHelper([
    'host' => HOST,
    'user' => USER,
    'pass' => PASS,
    'port' => PORT]);
$i = 0;
while (1) {
    foreach (_INTERFACE_ as $val) {

        $flatFile = new FlatFileDatabaseHelper();
        $flatFile->setInterface($val);
        $apiConnection->setInterface($val);
        $i++;
        $rxTx = $apiConnection->getRxTx();
        print_r($rxTx);
        $rxTx["date"] = $flatFile->createCollectionName($val);
        $rxTx["time"] = date("H:m:s");
        $flatFile->addNewRow($rxTx);

    }
    sleep(SLEEP_SECONDS);//performance test
    echo "\n" . $i . "\n";
    if ($isDebug) {
        echo "--" . $i . "--";
        if ($i > 15) {
            die("die");
        }
    }
}

