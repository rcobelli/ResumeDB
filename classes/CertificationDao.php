<?php

class CertificationDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "certifications", "certification_id");
    }

    public function insert($object)
    {
        if ($object['expiration'] == "") {
            $object['expiration'] = null;
        } else {
            $object['expiration'] = date('Y-m-d', strtotime($object['expiration']));
        }

        return $this->query(
            "INSERT INTO $this->tableName (`internal_certification_name`, `external_certification_name`, `expiration`) VALUES (?, ?, ?)",
            $object['internal_certification_name'],
            $object['external_certification_name'],
            $object['expiration']
        );
    }

    public function update($id, $object)
    {
        if ($object['expiration'] == "") {
            $object['expiration'] = null;
        } else {
            $object['expiration'] = date('Y-m-d', strtotime($object['expiration']));
        }
        
        return $this->query(
            "UPDATE $this->tableName SET `internal_certification_name` = ?, `external_certification_name` = ?, `expiration` = ? WHERE $this->primaryKey = ?",
            $object['internal_certification_name'],
            $object['external_certification_name'],
            $object['expiration'],
            $id
        );
    }
}

?>