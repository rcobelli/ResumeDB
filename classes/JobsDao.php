<?php

class JobsDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "jobs", "job_id");
    }

    public function insert($object)
    {
        if ($object['start_date'] == "") {
            $object['start_date'] = null;
        } else {
            $object['start_date'] = date('Y-m-d', strtotime($object['start_date']));
        }

        if ($object['end_date'] == "") {
            $object['end_date'] = null;
        } else {
            $object['end_date'] = date('Y-m-d', strtotime($object['end_date']));
        }

        if (isset($object['current'])) {
            $object['current'] = 1;
        } else {
            $object['current'] = 0;
        }

        return $this->query(
            "INSERT INTO $this->tableName (`job_internal_name`, `machine_description`, `human_description`, `current`, `start_date`, `end_date`, `employer_name`, `title`, `location`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            $object['job_internal_name'],
            $object['machine_description'],
            $object['human_description'],
            $object['current'],
            $object['start_date'],
            $object['end_date'],
            $object['employer_name'],
            $object['title'],
            $object['location']
        );
    }

    public function update($id, $object)
    {
        if ($object['start_date'] == "") {
            $object['start_date'] = null;
        } else {
            $object['start_date'] = date('Y-m-d', strtotime($object['start_date']));
        }

        if ($object['end_date'] == "") {
            $object['end_date'] = null;
        } else {
            $object['end_date'] = date('Y-m-d', strtotime($object['end_date']));
        }

        if (isset($object['current'])) {
            $object['current'] = 1;
        } else {
            $object['current'] = 0;
        }
        
        return $this->query(
            "UPDATE $this->tableName SET `job_internal_name` = ?, `machine_description` = ?, `human_description` = ?, `current` = ?, `start_date` = ?, `end_date` = ?, `employer_name` = ?, `title` = ?, `location` = ? WHERE $this->primaryKey = ?",
            $object['job_internal_name'],
            $object['machine_description'],
            $object['human_description'],
            $object['current'],
            $object['start_date'],
            $object['end_date'],
            $object['employer_name'],
            $object['title'],
            $object['location'],
            $id
        );
    }
}

?>