<?php

class EducationDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "education", "education_id");
    }

    public function insert($object)
    {
        if ($object['completion_date'] == "") {
            $object['completion_date'] = null;
        } else {
            $object['completion_date'] = date('Y-m-d', strtotime($object['completion_date']));
        }

        return $this->query(
            "INSERT INTO $this->tableName (`education_internal_name`, `institution`, `location`, `result`, `gpa`, `description`, `completion_date`) VALUES (?, ?, ?, ?, ?, ?, ?)",
            $object['education_internal_name'],
            $object['institution'],
            $object['location'],
            $object['result'],
            $object['gpa'],
            $object['description'],
            $object['completion_date']
        );
    }

    public function update($id, $object)
    {
        if ($object['completion_date'] == "") {
            $object['completion_date'] = null;
        } else {
            $object['completion_date'] = date('Y-m-d', strtotime($object['completion_date']));
        }
        
        return $this->query(
            "UPDATE $this->tableName SET `education_internal_name` = ?, `institution` = ?, `location` = ?, `result` = ?, `gpa` = ?, `description` = ?, `completion_date` = ? WHERE $this->primaryKey = ?",
            $object['education_internal_name'],
            $object['institution'],
            $object['location'],
            $object['result'],
            $object['gpa'],
            $object['description'],
            $object['completion_date'],
            $id
        );
    }
}

?>