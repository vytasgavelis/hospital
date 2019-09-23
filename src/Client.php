<?php
include_once('TimeService.php');
require_once('Specialist.php');

class Client
{
    protected $pdo;
    protected $id;
    protected $name;
    protected $specialistId;
    protected $serviced = 0;
    protected $date;
    protected $token;

    function __construct($pdo, $data)
    {
        $this->pdo = $pdo;
        $this->id = $data['id'];
        $this->name = $data['clients_name'];
        $this->specialistId = $data['specialists_id'];
        $this->serviced = $data['serviced'];
        $this->date = $data['date'];
        $this->token = $data['token'];
    }
    public function timeLeft()
    {
        $timeService = new TimeService($this->pdo);
        $specialist = $this->getSpecialist();

        $last = date("H:i:s", strtotime($specialist->getLastTime()));
        //Last time + average time - current time
        $timeLeft = strtotime($last) + $this->avgTime($specialist) - strtotime(date('Y-m-d H:i:s'));
        if ($timeLeft > 0) {
            return $timeService->secsToTime($timeLeft);
        } else {
            return '00:00:00';
        }
    }

    public function avgTime()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE serviced = 0 AND specialists_id = ? ORDER BY DATE ASC");
        $stmt->execute([$this->specialistId]);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < sizeof($arr); $i++) {
            if ($arr[$i]['id'] == $this->id) {
                $index = $i;
                break;
            }
        }
        if (isset($index)) {
            $timeService = new TimeService($this->pdo);
            $avgTimeSecs = $timeService->timeToSecs($this->getSpecialist()->getAvgTime());
            $avg = $avgTimeSecs * $index;
            return $avg;
        }
        return 0;
    }

    public function isServiced()
    {
        return $this->serviced == 1;
    }

    public function getSpecialist()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM specialists WHERE id = ?");
        $stmt->execute([$this->specialistId]);
        $specialistData = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Specialist($this->pdo, $specialistData);
    }

    // Returns if client is last in queue.
    public function isLast()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE specialists_id = :specialists_id AND serviced = 0 ORDER BY DATE DESC LIMIT 1");
        $stmt->execute(array(
            ':specialists_id' => $this->specialistId,
        ));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data['id'] == $this->id) {
            return true;
        }
        return false;
    }

    public function isFirst()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE specialists_id = :specialists_id AND serviced = 0 ORDER BY DATE ASC LIMIT 1");
        $stmt->execute(array(
            ':specialists_id' => $this->specialistId,
        ));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data['id'] == $this->id) {
            return true;
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSpecialistId()
    {
        return $this->specialistId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getToken()
    {
        return $this->token;
    }
}
