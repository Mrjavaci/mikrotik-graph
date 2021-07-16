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
            $flatBase = new FlatFileDatabaseHelper($databaseFileName);
            array_push($this->flatBases, $flatBase);
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
        $flatBase->setInterface(_INTERFACE_[0]);
        $row = $flatBase->getFirstRow();
        $tmp = array();
        foreach ($row[0][0] as $key => $value) {
            array_push($tmp, $key);
        }
        return $tmp;
    }

    public function getNormalizedArray($detail, $interface)
    {
        $allRows = array();


        foreach ($this->flatBases as $flatBase) {
            if ($this->getInterfaceNameFromCollection($flatBase->collectionName) == $interface) {
                $flatBase->setInterface($interface);
                $allRow = $flatBase->getAllRows();
                $labels = array();
                $values = array();
                foreach ($allRow as $value) {
                    array_push($values, $value[0][$detail]);
                    array_push($labels, $value["time"]);

                }
                $allRows["labels"] = $labels;
                $allRows["values"] = $values;
                //    echo $flatBase->interface;
                //   return $allRows;
            }
        }

        return $allRows;
    }

    public function getInterfaces()
    {
        $fileNames = $this->getDatabaseFileNames();
        $tmpArray = array();
        foreach ($fileNames as $fileName) {
            $interfacesWithDot = explode("_", $fileName);
            $interfacesWithoutDot = explode(".", $interfacesWithDot[1]);
            array_push($tmpArray, $interfacesWithoutDot[0]);
        }
        return array_unique($tmpArray);
    }

    private function getInterfaceNameFromCollection($collectionName)
    {
        $interfacesWithDot = explode("_", $collectionName);
        $interfacesWithoutDot = explode(".", $interfacesWithDot[1]);
        return $interfacesWithoutDot[0];
    }


}