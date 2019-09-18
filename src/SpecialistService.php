<?php
include('Specialist.php');

class SpecialistService
{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function getAllSpecialists(){
        $stmt = $this->pdo->prepare("SELECT * FROM specialists");
        $stmt->execute();
        $specialists = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $specialistsObjs = array();
        foreach($specialists as $specialist){
            array_push($specialistsObjs, new Specialist($this->pdo, $specialist));
        }
        return $specialistsObjs;
    }
}