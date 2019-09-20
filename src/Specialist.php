<?php
class Specialist{
    protected $pdo;

    protected $id;
    protected $name;
    protected $avgTime;
    protected $lastTime;

    function __construct($pdo, $data){
        $this->pdo = $pdo;
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->avgTime = $data['avg_time'];
        $this->lastTime = $data['last_time'];      
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getAvgTime(){
        return $this->avgTime;
    }
    public function getLastTime(){
        return $this->lastTime;
    }

    public function timeLeft($client){
        $timeService = new TimeService($this->pdo);
        
        $last = date("H:i:s",strtotime($this->getLastTime()));
        $current = new DateTime();
        $timeLeft = $timeService->timeToSecs($last) + $this->avgTime($client) - $timeService->timeToSecs($current->format('H:i:s'));
        if($timeLeft > 0){
            return $timeService->secsToTime($timeLeft);
        }else{
            return '00:00:00';
        }
        
    }

    public function avgTime($client){
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE serviced = 0 AND specialists_id = ?");
        $stmt->execute([$this->id]);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0; $i < sizeof($arr); $i++){
            if($arr[$i]['id'] == $client->getId()){
                $index = $i;
                break;
            }
        }
        if(isset($index)){
            $timeService = new TimeService($this->pdo);
            $avgTimeSecs = $timeService->timeToSecs($this->avgTime);
            $avg = $avgTimeSecs * $index;
            return $avg;
        }
        return 0;
    }
}