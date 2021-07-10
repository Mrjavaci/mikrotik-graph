<?php

/**
 * Class Parse
 * @author github.com/mrjavaci
 */

include(__DIR__ . "/../config.php");
include(__DIR__ . "/../vendor/autoload.php");
include(__DIR__ . "/../Helpers/FlatFileDatabaseHelper.php");

class Parse
{
    private $flatBases;

    public function __construct()
    {
        $databaseFileNames = $this->getDatabaseFileNames();
        $this->flatBases = array();
        foreach ($databaseFileNames as $databaseFileName) {
            array_push($this->flatBases, new FlatFileDatabaseHelper($databaseFileName));
        }

    }

    private function getDatabaseFileNames(): array
    {
        $datasFolder = array_diff(scandir(__DIR__ . "/../" . DATABASE_FOLDER), array('.', '..', '.DS_Store'));
        $filesArray = array();
        foreach ($datasFolder as $folder) {
            array_push($filesArray, $folder);
        }
        return $filesArray;
    }

    public function getNormalizedArray()
    {
        $allRows = array();
        foreach ($this->flatBases as $flatBase) {
            $allRow = $flatBase->getAllRows();
            array_push($allRows, $allRow);
        }
        return $allRows;
    }
}