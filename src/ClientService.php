<?php
include_once('Client.php');
include_once('TimeService.php');
include_once('Specialist.php');

class ClientService
{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function addClient($request){
        $stmt = $this->pdo->prepare("INSERT INTO clients (clients_name, date, specialists_id, token) VALUES(:name, :date, :specialist_id, :token)");
        $stmt->execute(array(
            ':name'         => $request['name'],
            ':date'         => date('Y/m/d H:i:s'),
            ':specialist_id'   => $request['specialist_id'],
            ':token'        => $request['token']
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


}