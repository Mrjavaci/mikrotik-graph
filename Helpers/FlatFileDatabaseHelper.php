<?php

/**
 * Class ApiConnectionHelper
 * @author github.com/mrjavaci
 */

class FlatFileDatabaseHelper
{
    private $flatBase;
    private $collectionName;
    private $interface;

    public function __construct($collectionName = null)
    {
        $this->collectionName = $collectionName;
    }

    public function setInterface($int)
    {
        $this->interface = $int;
        $this->initializeClass();
    }

    public function initializeClass()
    {
        if ($this->collectionName == null) {
            $this->collectionName = FlatFileDatabaseHelper::createCollectionName($this->interface);
        }
        $storage = new Flatbase\Storage\Filesystem(__DIR__ . "/.." . DATABASE_FOLDER);
        $flatBase = new Flatbase\Flatbase($storage);
        $this->flatBase = $flatBase;
    }

    public function addNewRow($arr)
    {
        $this->flatBase->insert()->in($this->collectionName)->set($arr)->execute();
    }


    public function getAllRows()
    {
        return $this->flatBase->read()->in($this->collectionName)->get();
    }

    public function getFirstRow()
    {
        return $this->flatBase->read()->in($this->collectionName)->limit(1)->get();
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

    public function createCollectionName($appendInterface = null)
    {
        if ($appendInterface != null)
            return date('d-m-y') . "_" . $appendInterface . ".jvc";
        return date('d-m-y');
    }
}