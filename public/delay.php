<?php
    include_once('../resources/dbconnection.php');
    include_once('../src/ClientService.php');

    $clientService = new ClientService($pdo);
    $client = $clientService->getClientByToken($_GET['token'], $_GET['id']);

    if(!$client->isLast()){
        echo $clientService->swapWithPrevious($client);
        
    }else{
        echo "ur not last";
    }
header('Location:appointment.php?token=' . $_GET['token']);
?>