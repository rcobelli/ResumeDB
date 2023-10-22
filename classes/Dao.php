<?php

abstract class Dao extends Helper
{
    public $tableName;
    public $primaryKey;

    public function __construct($config, $tableName, $primaryKey)
    {
        parent::__construct($config);
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
    }

    public function selectAll()
    {
        return $this->query("SELECT * FROM $this->tableName");
    }

    public function select($id)
    {
        return $this->query("SELECT * FROM $this->tableName WHERE $this->primaryKey = ? LIMIT 1", $id);
    }

    public function delete($id)
    {
        return $this->query("DELETE FROM $this->tableName WHERE $this->primaryKey = ?", $id);
    }

    public function createLink($resume_id, $object_id)
    {
        return $this->query("INSERT IGNORE INTO resume_$this->tableName SET $this->primaryKey = ?, `resume_id` = ?", $object_id, $resume_id);
    }

    public function getLinks($resume_id)
    {
        return $this->query("SELECT * FROM resume_$this->tableName WHERE `resume_id` = ?", $resume_id);
    }

    public function deleteLinks($resume_id)
    {
        return $this->query("DELETE FROM resume_$this->tableName WHERE `resume_id` = ?", $resume_id);
    }

    abstract public function insert($object);
    abstract public function update($id, $object);
}

