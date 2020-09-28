<?php
interface CommodityDAO
{
    public function insert($name, $price, $quantity, $text = "", $status = false);
    public function update($id, $name, $price, $quantity, $text, $status);
    public function updateImage($id, $img);
    public function getOneByID($id);
    public function getOneImgByID($id);
    public function getSome($id = null);
}
