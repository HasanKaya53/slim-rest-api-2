<?php

namespace App\Model;
use App\Controller\BaseController;
class TransitionModel extends BaseController
{

    protected $tableName = "transition";


    public function listAllTransition()
    {
        $stmt = $this->db->prepare("SELECT plate,price,transition_date FROM $this->tableName INNER JOIN plate ON transition.plate_id = plate.id ORDER BY transition_date DESC");
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function createNewTransition($data){
        $stmt = $this->db->prepare("INSERT INTO $this->tableName (plate_id, price, transition_date) VALUES (:plate_id,:price, :date)");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function searchTransition($plateID, $date)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->tableName WHERE plate_id = ? AND transition_date = ?");
        $stmt->execute([$plateID, $date]);
        return $stmt->fetchAll();
    }

    public function carTodayTotal($plateID,$searchData)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM $this->tableName WHERE transition_date between ? and ? AND plate_id = ?");
        $stmt->execute([$searchData.' 00:00:00', $searchData.' 23:59:59',$plateID]);
        return $stmt->fetchAll();
    }
}