<?php
include_once('../resources/dbconnection.php');
include_once('../src/ClientService.php');

$clientService = new ClientService($pdo);
$client = $clientService->getClientByToken($_GET['token']);


?>
<html>
<head>
<meta http-equiv="refresh" content="5" />
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

<?php
    if(is_null($client)){
        echo 'Neteisinga nuoroda';
    }else if(!$client->isServiced()){
        echo $client->timeLeft();
    }else{
        echo "Jūs jau aptarnautas.";
    }
?>
</body>
</html>