<?php

abstract class BaseObject
{
    static $tablename;

    protected $database;
    protected $id;

    function __construct($database, $id)
    {
        $this->database = $database;
        $this->id = (int) $id;
    }

    function getId()
    {
        return $this->id;
    }

    /**
     * Remove this entry.
     */
    function remove()
    {
        $query = sprintf("DELETE FROM $this->tablename WHERE id=%d", (int) $this->id);
        return $this->database->DBQuery($query);
    }

    /**
     * Create a new record.
     * 
     * @param Database $database a database instance.
     * @param array $fields the country name.
     * @param array $values abbreviation of the country.
     */
    static function create($database, $fields, $values)
    {
        // Escape
        $escaped_values = array_map(function ($s) {
            global $database;
            return $database->RealEscapeString($s);
        }, $values);

        $query = "INSERT INTO " . static::$tablename . " (" . implode(",", $fields) . ")
            VALUES ('" . implode("','", $escaped_values) . "')";

        $database->DBQuery($query);
        $insertId = $database->InsertID();
        return $insertId;
    }
}
