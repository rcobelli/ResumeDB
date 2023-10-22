<?php

class ResumeDao extends Dao
{
    function __construct($config) {
        parent::__construct($config, "resumes", "resume_id");
    }

    public function insert($object)
    {
        $object['machine_first'] = $object['type'] == "machine";

        return $this->query(
            "INSERT INTO $this->tableName (`internal_resume_name`, `machine_first`, `skills`) VALUES (?, ?, ?)",
            $object['internal_resume_name'],
            $object['machine_first'],
            $object['skills']
        );
    }

    public function update($id, $object)
    {
        $object['machine_first'] = $object['type'] == "machine";
        
        return $this->query(
            "UPDATE $this->tableName SET `internal_resume_name` = ?, `machine_first` = ?, `skills` = ? WHERE $this->primaryKey = ?",
            $object['internal_resume_name'],
            $object['machine_first'],
            $object['skills'],
            $id
        );
    }

    public function createLink($object_id, $resume_id)
    {
        throw new \Exception("Can't create a link between a resume and itself");
    }

    public function deleteLink($object_id, $resume_id)
    {
        throw new \Exception("Can't create a link between a resume and itself");
    }
}

?>