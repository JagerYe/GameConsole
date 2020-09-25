<?php

class Controller
{
    public function requireDAO($dao)
    {
        require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/$dao/{$dao}Service.php";
        require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/$dao/$dao.php";
    }
    public function getJsonToModel($model, $jsonStr, $isInsert = false)
    {
        
        return $model::jsonStringToModel($jsonStr, $isInsert);
    }

    public function getJsonArrToModelsArr($model, $jsonStr, $isInsert = false)
    {
        return $model::jsonArrayStringToModelsArray($jsonStr, $isInsert);
    }
}
