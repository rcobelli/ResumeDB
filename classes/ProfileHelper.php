<?php

use Rybel\backbone\Helper;

class ProfileHelper extends Helper
{
    public function name()
    {
        return $this->fetch("name");
    }

    public function email()
    {
        return $this->fetch("email");
    }

    public function phone()
    {
        return $this->fetch("phone");
    }

    private function fetch($key)
    {
        return $this->query("SELECT `value` FROM `profile` WHERE `key` = ? LIMIT 1", $key)['value'];
    }
}

?>