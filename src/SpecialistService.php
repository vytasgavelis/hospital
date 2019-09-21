<?php
include_once('Specialist.php');

class SpecialistService
{
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAllSpecialists()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM specialists");
        $stmt->execute();
        $specialists = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $specialistsObjs = array();
        foreach($specialists as $specialist){
            array_push($specialistsObjs, new Specialist($this->pdo, $specialist));
        }
        return $specialistsObjs;
    }
    public function updateLastTime($specialist, $lastTime)
    {
        $stmt = $this->pdo->prepare("UPDATE specialists SET last_time = :last_time WHERE id = :id");
        $stmt->execute(array(
            ':last_time' => $lastTime,
            ':id' => $specialist->getId()
        ));
    }
    public function updateAverageTime($specialist, $avg)
    {
        $stmt = $this->pdo->prepare("UPDATE specialists SET avg_time = :avg_time WHERE id = :id");
        $stmt->execute(array(
            ':avg_time' => $avg,
            ':id' => $specialist->getId()
        ));
    }
}