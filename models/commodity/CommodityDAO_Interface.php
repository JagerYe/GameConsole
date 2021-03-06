<?php
interface CommodityDAO_Interface
{
    public function insert($name, $price, $quantity, $status = false);
    public function update($id, $name, $price, $quantity, $status);
    public function updateImage($id, $img);
    public function getOneByID($id);
    public function getOneImgByID($id);
    public function getSome($id = null);
}
