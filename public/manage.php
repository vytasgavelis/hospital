<?php
    session_start();

    include_once('../src/ClientService.php');
    include_once('../src/Token.php');
    include_once('../resources/dbconnection.php');

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/board.css">
</head>
<body>
    <?php include_once('navbar.html'); ?>

    <div class="row">
        <div class="column side"></div>

        <div class="column middle">
            <table>
            <tr>
                <th>Vardas</th>
                <th>Specialistas</th>
                <th>Numatytas laikas</th>
                <th>Veiksmas</th>
            </tr>
            <?php
                $clientService = new ClientService($pdo);
                $clients = $clientService->getClients();

                foreach($clients as $client){
                    if($client->isFirst()){
                    echo "<tr class='first'>";
                    }else{
                        echo "<tr>"; 
                    }
                        echo "<td>" . $client->getName() . "</td>"; 
                        echo "<td>" . $client->getSpecialist()->getName() . "</td>"; 
                        echo "<td>" . $client->timeLeft() . "</td>"; 
                        echo "<td>";

                            echo "<form method='POST' action='service.php'>";
                                $token = Token::generate();
                                echo "<input type='hidden' name='token' value='" . $token . "'></input>";
                                echo "<input type='hidden' name='date' value='" . $client->getDate() . "'></input>";
                                echo "<input type='hidden' name='specialist_id' value='" . $client->getSpecialistId() . "'></input>";
                                echo "<input type='hidden' name='id' value='" . $client->getId() . "'></input>";
                                echo "<button type='submit'>Service</button>";
                            echo "</form>";

                        echo "</td>";
                    echo "</tr>";
                }
            ?>
        </div>
        
        <div class="column side"></div>
    </div>
</body>
</html>