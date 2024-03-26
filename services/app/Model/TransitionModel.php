<?php

namespace App\Model;
use App\Controller\BaseController;
class TransitionModel extends BaseController
{

    protected $tableName = "transition";

    public function createNewTransition($data){
        $stmt = $this->db->prepare("INSERT INTO $this->tableName (plate_id, transition_date) VALUES (:plate_id, :date)");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function searchTransition($plateID, $date)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->tableName WHERE plate_id = ? AND transition_date = ?");
        $stmt->execute([$plateID, $date]);
        return $stmt->fetchAll();
    }
}