<?php
class ClientService
{
    protected $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function addClient($name){
        $stmt = $this->pdo->prepare("INSERT INTO clients (client_name, date) VALUES(:name, :date)");
        $stmt->execute(array(
            ':name' => $name,
            ':date'         => date('Y/m/d H:i:s')
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
    public function getClients(){
        $stmt = $this->pdo->prepare("SELECT * FROM clients ORDER BY date ASC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}