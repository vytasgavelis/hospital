<?php
    session_start();

    include_once('../src/ClientService.php');
    include_once('../src/Token.php');
    include_once('../resources/dbconnection.php');

    // Different days
    $stmt = $pdo->prepare("SELECT DAY(date) as day FROM clients GROUP BY CAST(date AS DATE)");
    $stmt->execute();
    $days = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/board.css">
</head>
<body>
    <?php
    include_once('navbar.html');
    ?>
    <div class="row">
        <div class="column side"></div>

        <div class="column middle">
            <div class="days">
            <?php
            
                foreach($days as $day){
                    $d = $day['day'];
                    if($d == $_GET['day']){
                        echo "<a class='currentDay' href='board.php?day=$d'>" . $d . "</a>";
                    }else{
                        echo "<a href='board.php?day=$d'>" . $d . "</a>";
                    }
                }
            ?>
            </div>
            <table>
            <tr>
                <th>Vardas</th>
                <th>Specialistas</th>
                <th>Numatytas laikas</th>
                <th>Registracijos laikas</th>
            </tr>
            <?php
                $clientService = new ClientService($pdo);
                $clients = $clientService->getClientsByDay($_GET['day']);

                foreach($clients as $client){
                    if($client->isFirst()){
                    echo "<tr class='first'>";
                    }else{
                        echo "<tr>"; 
                    }
                    echo "<td>" . $client->getName() . "</td>"; 
                    echo "<td>" . $client->getSpecialist()->getName() . "</td>"; 
                    echo "<td>" . $client->getSpecialist()->timeLeft($client) . "</td>"; 
                    echo "<td>" . $client->getDate() . "</td>"; 

                    echo "</tr>";
                }
                
            ?>
            </table>
            
        </div>
        
        <div class="column side"></div>
    </div>
</body>
</html>