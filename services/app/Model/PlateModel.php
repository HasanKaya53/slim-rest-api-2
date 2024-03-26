<?php



namespace App\Model;
use App\Controller\BaseController;
class PlateModel extends BaseController
{

    protected $tableName = "plate";
    function createNewPlate($data){
        $stmt = $this->db->prepare("INSERT INTO $this->tableName (plate) VALUES (:plate)");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }


    function getPlate($plate){
        $stmt = $this->db->prepare("SELECT * FROM $this->tableName WHERE plate = :plate");
        $stmt->execute(['plate' => $plate]);
        return $stmt->fetchAll();
    }

}