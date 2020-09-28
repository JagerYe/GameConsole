<?php
class Permission implements \JsonSerializable
{
    private $_id;
    private $_name;
    private $_creationDate;
    private $_changeDate;

    public function getId()
    {
        return $this->_id;
    }
    public function setId($id)
    {
        if (!preg_match("/\d/", $id)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_id = $id;
        return true;
    }

    public function getName()
    {
        return $this->_name;
    }
    public function setName($name)
    {
        if (strlen(trim($name)) <= 0) {
            throw new Exception("名字格式錯誤");
        }
        $this->_name = $name;
        return true;
    }

    public function getCreationDate()
    {
        return $this->_creationDate;
    }
    public function setCreationDate($creationDate)
    {
        $this->_creationDate = $creationDate;
        return true;
    }

    public function getChangeDate()
    {
        return $this->_changeDate;
    }
    public function setChangeDate($changeDate)
    {
        $this->_changeDate = $changeDate;
        return true;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
