<?php
session_start();
include_once('../resources/dbconnection.php');
include_once('../src/ClientService.php');

$clientService = new ClientService($pdo);
$client = $clientService->getClientByToken($_GET['token']);

?>
<html>

<head>
    <!--<meta http-equiv="refresh" content="5" />-->
    <link rel="stylesheet" type="text/css" href="css/singleContainer.css">
    <link href="https://fonts.googleapis.com/css?family=Cute+Font&display=swap" rel="stylesheet"> 
</head>

<body>
    <script>
        /*function updateTime(token){
            var xmlhttp = new XmlHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 $$ this.status == 200){
                    var text = this.responseText;
                    document.getElementById("timeLeft").innerHTML = text;
                }
            };
            xmlhttp.open("GET", "../src/updateTime.php?token=" + token, true);
            xmlhttp.send();    
        }
        
        updateTime();
        setInterval(updateTime, 2000);*/
    </script>
    <div class="container">
        <div class="content">
            <div class="inner">
                <div class="info">
                    <?php if(!is_null($client)) echo $client->getName(); ?>
                </div>
                <div class="info">
                    <?php if(!is_null($client)) echo "Užsiregistravote: " . $client->getDate(); ?>
                </div>
                <div class="info">
                    <?php
                    if(!is_null($client)){
                        echo "Specialistas: " . $client->getSpecialist($client->getSpecialistId())->getName(); 
                    }
                     ?>
                </div>
                <div class="time">
                    <?php
                    if(is_null($client)) {
                        echo "Neteisinga nuoroda";
                    }else if(!$client->isServiced() ){
                        echo $client->timeLeft();
                    }else{
                        echo "Jūs jau aptarnautas.";
                    }             
                    ?>
                </div>
                <div class="delete-container">
                    <?php 
                    if(!is_null($client)){
                        echo "<div class='action'><a class='delete' href='cancel.php?token=" . $_GET['token'] . "'>Atšaukti</a></div>";
                        if(!$client->isLast()){
                            echo "<div class='action'><a class='delay' href='delay.php?token=" . $_GET['token'] . "'>Pavėlinti</a></div>";
                        }
                    }
                     ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>