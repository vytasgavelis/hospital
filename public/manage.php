<?php
    session_start();

    include_once('../src/ClientService.php');
    include_once('../src/Token.php');
    include_once('../resources/dbconnection.php');

    $clientService = new ClientService($pdo);

    $clients = $clientService->getClients();

    $token = Token::generate();
    foreach($clients as $client){
        echo $client['date'];
        echo "<form method='POST' action='remove.php'>";
        echo "<input type='hidden' name='token' value='" . $token . "'></input>";
        echo "<input type='hidden' name='id' value='" . $client['id'] . "'></input>";
        echo "<button type='submit'>Remove</button>";
        echo "</form>";
        echo "<br>";
    }
?>