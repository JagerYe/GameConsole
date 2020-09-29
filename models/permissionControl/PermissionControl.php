<?php
class PermissionControl implements \JsonSerializable
{
    private $_empID;
    private $_permissionID;
    private $_creationDate;

    public function getEmpID()
    {
        return $this->_empID;
    }
    public function setEmpID($empID)
    {
        if (!preg_match("/\d/", $empID)) {
            throw new Exception("員工 ID  格式錯誤");
        }
        $this->_empID = $empID;
        return true;
    }

    public function getPermissionID()
    {
        return $this->_permissionID;
    }
    public function setPermissionID($permissionID)
    {
        if (!preg_match("/\d/", $permissionID)) {
            throw new Exception("權限 ID 格式錯誤");
        }
        $this->_permissionID = $permissionID;
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

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
