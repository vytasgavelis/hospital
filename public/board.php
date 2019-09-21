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
            <div class="days">
                <?php
                    // Select distinct days
                    $stmt = $pdo->prepare("SELECT DAY(date) as day FROM clients WHERE serviced = 0 GROUP BY CAST(date AS DATE)");
                    $stmt->execute();
                    $days = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    //If unable to get wanted day through GET request, pick the first one.
                    if(isset($_GET['day'])){
                        $currentDay = $_GET['day'];
                    }else if(isset($days[0])){
                        $currentDay = $days[0]['day'];
                    }else{
                        echo "Klientų eilėje nėra.";
                    }
                    if(isset($currentDay)){
                        //Print days which have clients
                        foreach($days as $day){
                            $d = $day['day'];
                            if($d == $currentDay){
                                echo "<a class='currentDay' href='board.php?day=$d'>" . $d . "</a>";
                            }else{
                                echo "<a href='board.php?day=$d'>" . $d . "</a>";
                            }
                        }
                    }
                ?>
            </div>
            <table>
            <tr>
                <th>Vardas</th>
                <th>Specialistas</th>
                <th>Numatytas likęs laikas</th>
                <th>Registracijos laikas</th>
            </tr>
            <?php
                if(isset($currentDay)){
                    $clientService = new ClientService($pdo);
                    $clients = $clientService->getClientsByDay($currentDay);

                    foreach($clients as $client){
                        if($client->isFirst()){
                            echo "<tr class='first'>";
                            $time = "Aptarnaujamas dabar";
                        }else{
                            echo "<tr>"; 
                            $time = $client->timeLeft();
                        }
                        echo "<td>" . $client->getName() . "</td>"; 
                        echo "<td>" . $client->getSpecialist()->getName() . "</td>"; 
                        echo "<td>" . $time . "</td>"; 
                        echo "<td>" . $client->getDate() . "</td>"; 

                        echo "</tr>";
                    }
                }                
            ?>
            </table>           
        </div>
        
        <div class="column side"></div>
    </div>
</body>
</html>