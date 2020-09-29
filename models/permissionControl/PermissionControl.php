<?php
class PermissionControl implements \JsonSerializable
{
    private $_employeeID;
    private $_permissionID;
    private $_creationDate;

    public function getEmployeeID()
    {
        return $this->_employeeID;
    }
    public function setEmployeeID($employeeID)
    {
        if (!preg_match("/\d/", $employeeID)) {
            throw new Exception("員工 ID  格式錯誤");
        }
        $this->_employeeID = $employeeID;
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
