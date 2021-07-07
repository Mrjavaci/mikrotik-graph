<?php

/**
 * Class ApiConnectionHelper
 * @author github.com/mrjavaci
 */

class FlatFileDatabaseHelper
{
    private $flatBase;

    public function __construct()
    {
        $storage = new Flatbase\Storage\Filesystem(__DIR__ . DATABASE_FOLDER);
        $flatBase = new Flatbase\Flatbase($storage);
        $this->flatBase = $flatBase;
    }

    public function addNewRow($arr)
    {
        $this->flatBase->insert()->in('lastStatistics')->set($arr)->execute();
    }


    public function getAllRows()
    {
        return $this->flatBase->read()->in('lastStatistics')->get();
    }

    public function getAllRowsNormalized()
    {
        $rows = $this->getAllRows();
        $groups = array();
        foreach ($rows as $row) {
            $groups[$row["gorupName"]][] = $row["userName"];
        }
        return $groups;
    }
}