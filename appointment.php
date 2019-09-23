<?php
session_start();
include_once('resources/dbconnection.php');
include_once('src/ClientService.php');

?>
<html>

<head>
    <meta http-equiv="refresh" content="5" />
    <link rel="stylesheet" type="text/css" href="css/singleContainer.css">
    <link href="https://fonts.googleapis.com/css?family=Cute+Font&display=swap" rel="stylesheet">
</head>

<body>
    <?php include_once("navbar.html"); ?>
    <div class="container">
        <div class="content">
            <div class="inner">
                <?php
                $clientService = new ClientService($pdo);
                $client = null;
                if (isset($_GET['id'], $_GET['token'])) {
                    //Client is searched by id but then its token is validated.
                    $client = $clientService->getClientByToken($_GET['token'], $_GET['id']);

                    if (!is_null($client)) {
                        echo "<div class='info'>Vardas: " . $client->getName() . "</div>";
                        echo "<div class='info'> Užsiregistravote: " . $client->getDate() . "</div>";
                        echo "<div class='info'> Specialistas: " . $client->getSpecialist()->getName() . "</div>";
                    }
                }
                ?>
                <div class="time">
                    <?php
                    if (is_null($client)) {
                        echo "Neteisinga nuoroda";
                    } else {
                        echo $client->timeLeft();
                    }
                    ?>
                </div>
                <div class="delete-container">
                    <?php
                    if (!is_null($client)) {
                        echo "<div class='action'><a class='delete' href='cancel.php?token=" . $_GET['token'] . "&id=" . $client->getId() . "'>Atšaukti</a></div>";
                        if (!$client->isLast()) {
                            echo "<div class='action'><a class='delay' href='delay.php?token=" . $_GET['token'] . "&id=" . $client->getId() . "'>Pavėlinti</a></div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>