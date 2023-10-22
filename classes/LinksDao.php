<?php

class LinksDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "links", "link_id");
    }

    public function insert($object)
    {
        return $this->query(
            "INSERT INTO $this->tableName (`link_name`, `link_value`) VALUES (?, ?)",
            $object['link_name'],
            $object['link_value']
        );
    }

    public function update($id, $object)
    {
        return $this->query(
            "UPDATE $this->tableName SET `link_name` = ?, `link_value` = ? WHERE $this->primaryKey = ?",
            $object['link_name'],
            $object['link_value'],
            $id
        );
    }
}

?>