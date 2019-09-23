<?php
include_once('Client.php');
include_once('TimeService.php');
include_once('Specialist.php');

class ClientService
{
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addClient($request)
    {
        $stmt = $this->pdo->prepare("INSERT INTO clients (clients_name, date, specialists_id, token) 
        VALUES(:name, :date, :specialist_id, :token)");
        $stmt->execute(array(
            ':name'          => $request['name'],
            ':date'          => date('Y/m/d H:i:s'),
            ':specialist_id' => $request['specialist_id'],
            ':token'         => $request['token']
        ));
        if ($stmt) {
            $response = "Užregistruota sėkmingai.";
        } else {
            $response = "Įvyko klaida, kreipkitės telefonu.";
        }
        return $response;
    }
    public function removeClient($id)
    {
        $stmt = $this->pdo->prepare("DELETE from clients WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function serviceClient($id)
    {
        $stmt = $this->pdo->prepare("UPDATE clients SET serviced = 1 WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function getClients()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE serviced = 0 ORDER BY DATE ASC LIMIT 10 ");
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clientsObjs = array();
        foreach ($clients as $client) {
            array_push($clientsObjs, new Client($this->pdo, $client));
        }
        return $clientsObjs;
    }
    public function getClientsByDay($day)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE DAY(date) = ? AND serviced = 0 ORDER BY DATE ASC LIMIT 10");
        $stmt->execute([$day]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clientsObjs = array();
        foreach ($data as $d) {
            array_push($clientsObjs, new Client($this->pdo, $d));
        }
        return $clientsObjs;
    }
    public function getClientsFromSpecialist($specialist)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE serviced = 0 AND specialists_id = :specId ORDER BY DATE ASC ");
        $stmt->execute(array(
            'specId' => $specialist->getId()
        ));
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clientsObjs = array();
        foreach ($clients as $client) {
            array_push($clientsObjs, new Client($this->pdo, $client));
        }
        return $clientsObjs;
    }
    public function getClientByToken($token, $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE id = ? AND serviced = 0");
        $stmt->execute([$id]);
        $client = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($client) > 0 && $client[0]['token'] == $token) {
            return new Client($this->pdo, $client[0]);
        } else {
            return null;
        }
    }
    public function swapWithNext($client)
    {
        $clients = $this->getClientsFromSpecialist($client->getSpecialist());
        for ($i = 0; $i < sizeof($clients); $i++) {
            if ($clients[$i]->getId() == $client->getId()) {
                //Index of next client 
                $index = $i + 1;
                break;
            }
        }

        if (isset($index)) {
            $stmt = $this->pdo->prepare("UPDATE clients SET date = :date WHERE id = :original_id");
            //Update next client date
            $stmt->execute(array(
                ':date' => $client->getDate(),
                ':original_id' => $clients[$index]->getId(),
            ));
            // Update previous client date
            $stmt->execute(array(
                ':date' => $clients[$index]->getDate(),
                ':original_id' => $client->getId(),
            ));
        }
    }
}
