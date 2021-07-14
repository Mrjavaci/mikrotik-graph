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

    public function getDetailNames()
    {
        $flatBase = $this->flatBases[0];
        $row = $flatBase->getFirstRow();
        $tmp = array();
        foreach ($row[0][0] as $key => $value) {
            array_push($tmp, $key);
        }
        return $tmp;
    }

    public function getNormalizedArray($detail)
    {
        $allRows = array();
        foreach ($this->flatBases as $flatBase) {
            $allRow = $flatBase->getAllRows();
            $labels = array();
            $values = array();
            foreach ($allRow as $value) {
                array_push($values, $value[0][$detail],3);
                array_push($labels, $value["time"]);

            }
            $allRows["labels"] = $labels;
            $allRows["values"] = $values;
            //      array_push($allRows, $allRow);
        }
        return $allRows;
    }


}