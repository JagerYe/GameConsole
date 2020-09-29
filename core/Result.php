<?php
class Result
{
    public static function getResultJson($success, $result, $errMessage = "")
    {
        $data['success'] = $success;
        $data['result'] = $result;
        $data['errMessage'] = $errMessage;
        return json_encode($data);
    }
}
