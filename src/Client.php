<?php
include_once('TimeService.php');
require_once('Specialist.php');

class Client{
    protected $pdo;

    protected $id;
    protected $name;
    protected $specialistId;
    protected $serviced = 0;
    protected $date;
    protected $token;

    function __construct($pdo, $data){
        $this->pdo = $pdo;
        $this->id = $data['id'];
        $this->name = $data['clients_name'];
        $this->specialistId = $data['specialists_id'];
        $this->serviced = $data['serviced'];
        $this->date = $data['date'];   
        $this->token = $data['token'];   
    }
    public function timeLeft(){
        $timeService = new TimeService($this->pdo);

        $stmt = $this->pdo->prepare("SELECT * FROM specialists WHERE id = ?");
        $stmt->execute([$this->specialistId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $specialist = new Specialist($this->pdo, $data);
        
        $last = date("H:i:s",strtotime($specialist->getLastTime()));
        $current = new DateTime();
        $timeLeft = $timeService->timeToSecs($last) + $this->avgTime($specialist) - $timeService->timeToSecs($current->format('H:i:s'));
        if($timeLeft > 0){
            return $timeService->secsToTime($timeLeft);
        }else{
            return '00:00:00';
        }
        
    }

    public function avgTime(){
        $stmt = $this->pdo->prepare("SELECT specialists.avg_time FROM clients INNER JOIN specialists ON clients.specialists_id = specialists.id WHERE clients.id = :clients_id");
        $stmt->execute(array(
            ':clients_id' => $this->id,
        ));
        $avgTime = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE serviced = 0 AND specialists_id = ?");
        $stmt->execute([$this->specialistId]);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0; $i < sizeof($arr); $i++){
            if($arr[$i]['id'] == $this->id){
                $index = $i;
                break;
            }
        }
        if(isset($index)){
            $timeService = new TimeService($this->pdo);
            $avgTimeSecs = $timeService->timeToSecs($avgTime['avg_time']);
            $avg = $avgTimeSecs * $index;
            return $avg;
            //return $timeService->secsToTime($avg);
        }
        return 0;
    }

    public function isServiced(){
        return $this->serviced == 1;
    }
    public function getSpecialist($id){
        $stmt = $this->pdo->prepare("SELECT * FROM specialists WHERE id = ?");
        $stmt->execute([$id]);
        $specialistData = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Specialist($this->pdo, $specialistData);
    }
    public function isLast(){
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE specialists_id = :specialists_id AND id = :client_id ORDER BY DATE DESC LIMIT 1");
        $stmt->execute(array(
            ':specialists_id' => $this->specialistId,
            ':client_id' => $this->id
        ));
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(sizeof($data) > 0){
           return true;
        }
        return false;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getSpecialistId(){
        return $this->specialistId;
    }
    public function getDate(){
        return $this->date;
    }
    public function getToken(){
        return $this->token;
    }


}