<?php
include('Client.php');
include('TimeService.php');

class ClientService
{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function addClient($request){
        $stmt = $this->pdo->prepare("INSERT INTO clients (clients_name, date, specialists_id) VALUES(:name, :date, :specialist_id)");
        $stmt->execute(array(
            ':name'         => $request['name'],
            ':date'         => date('Y/m/d H:i:s'),
            ':specialist_id'   => $request['specialist_id']
        ));
        if($stmt){
            $response = "Užregistruota sėkmingai.";
        }else{
            $response = "Įvyko klaida, kreipkitės telefonu.";
        }
        return $response;
    }
    public function removeClient($id){
        $stmt = $this->pdo->prepare("DELETE from clients WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function serviceClient($id){
        $stmt = $this->pdo->prepare("UPDATE clients SET serviced = 1 WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function getClients(){
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE serviced = 0 ORDER BY DATE ASC LIMIT 10 ");
        //SELECT * FROM `clients` INNER JOIN specialists ON clients.specialists_id = specialists.id WHERE serviced = 0
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $clientsObjs = array();
        foreach($clients as $client){
            array_push($clientsObjs, new Client($this->pdo, $client));
        }
        return $clientsObjs;
    }
    public function avgTime($clientsId, $specId){
        $stmt = $this->pdo->prepare("SELECT specialists.avg_time FROM clients INNER JOIN specialists ON clients.specialists_id = specialists.id WHERE clients.id = :clients_id");
        $stmt->execute(array(
            ':clients_id' => $clientsId,
        ));
        $avgTime = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE serviced = 0 AND specialists_id = ?");
        $stmt->execute([$specId]);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0; $i < sizeof($arr); $i++){
            if($arr[$i]['id'] == $clientsId){
                $index = $i + 1;
                break;
            }
        }
        if(isset($index)){
            $timeService = new TimeService($this->pdo);
            $avgTimeSecs = $timeService->timeToSecs($avgTime['avg_time']);
            $avg = $avgTimeSecs * $index;
            return $timeService->secsToTime($avg);
        }
        return 0;
    }

}