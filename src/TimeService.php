<?php
include('SpecialistService.php');

class TimeService
{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function addTime($data){
        $stmt = $this->pdo->prepare("SELECT last_time from specialists WHERE id = ?");
        $stmt->execute([$data['specialist_id']]);
        $lastTime = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $clientTime = strtotime($data['date']);
        $specTime = strtotime($lastTime['last_time']);
        
        $deltaInSecs = $clientTime - $specTime;

        // Only update times if the time it took for specialist to service the client is bigger than 0.
        if($deltaInSecs >= 0){
            $hours = floor($deltaInSecs / 3600);
            $mins = floor($deltaInSecs / 60 % 60);
            $secs = floor($deltaInSecs % 60);

            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            
            $stmt = $this->pdo->prepare("INSERT INTO times (specialists_id, time) VALUES(:id, :time)");
            $stmt->execute(array(
                ':id' => $data['specialist_id'],
                ':time' => $timeFormat
            ));

            $specialistService = new SpecialistService($this->pdo);
            $specialistService->updateLastTime($data['specialist_id'], $data['date']);
        }
    }
}