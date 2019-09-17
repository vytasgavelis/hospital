<?php
include_once('../src/ClientService.php');
include_once('../resources/dbconnection.php');

$clientService = new ClientService($pdo);

$clients = $clientService->getClients();
foreach($clients as $client){
    echo $client['date'];
    echo "<br>";
}
?>