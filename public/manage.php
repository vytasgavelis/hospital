<?php
    session_start();

    include_once('../src/ClientService.php');
    include_once('../src/Token.php');
    include_once('../resources/dbconnection.php');

    $clientService = new ClientService($pdo);

    $clients = $clientService->getClients();

    $token = Token::generate();
?>
<html>
<head>
</head>
<body>
    <table>
        <tr>
            <th>Name</th>
            <th>Sepcialist</th>
            <th>Date</th>
            <th>Time left</th>
        </tr>
    <?php
        foreach($clients as $client){
            echo "<tr>";
            echo "<td>" . $client->getName() . "</td>";
            echo "<td>" . $client->getSpecialistId() . "</td>";
            echo "<td>" . $client->getDate() . "</td>";
            echo "<td>" . $clientService->avgTime($client->getId(), $client->getSpecialistId()) . "</td>";
                
            /*echo "<form method='POST' action='remove.php'>";
            echo "<input type='hidden' name='token' value='" . $token . "'></input>";
            echo "<input type='hidden' name='id' value='" . $client->getId() . "'></input>";
            echo "<button type='submit'>Remove</button>";
            echo "</form>";*/

            echo "<form method='POST' action='service.php'>";
            echo "<input type='hidden' name='token' value='" . $token . "'></input>";
            echo "<input type='hidden' name='date' value='" . $client->getDate() . "'></input>";
            echo "<input type='hidden' name='specialist_id' value='" . $client->getSpecialistId() . "'></input>";
            echo "<input type='hidden' name='id' value='" . $client->getId() . "'></input>";
            echo "<button type='submit'>Service</button>";
            echo "</form>";

            echo "</tr>";
        }
?>
    </table>
</body>
</html>