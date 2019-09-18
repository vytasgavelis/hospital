<?php
    session_start();

    include_once('../src/ClientService.php');
    include_once('../src/Token.php');
    include_once('../resources/dbconnection.php');

    $clientService = new ClientService($pdo);

    $clients = $clientService->getClients();

    $token = Token::generate();
    foreach($clients as $client){
        if(!$client->isServiced()){

            echo $client->getDate();
            echo "<form method='POST' action='remove.php'>";
            echo "<input type='hidden' name='token' value='" . $token . "'></input>";
            echo "<input type='hidden' name='id' value='" . $client->getId() . "'></input>";
            echo "<button type='submit'>Remove</button>";
            echo "</form>";

            echo "<form method='POST' action='service.php'>";
            echo "<input type='hidden' name='token' value='" . $token . "'></input>";
            echo "<input type='hidden' name='id' value='" . $client->getId() . "'></input>";
            echo "<button type='submit'>Service</button>";
            echo "</form>";

            echo "<br>";
        }
    }
?>