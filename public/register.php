<?php

include_once('../src/ClientService.php');
include_once('../resources/config.php');
include_once('../resources/dbconnection.php');
include_once('../src/Token.php');

session_start();
$clientService = new ClientService($pdo);
if(isset($_GET['name'], $_GET['specialist_id']) && $_GET['name'] != ""){
    $link = 'localhost/appointment.php?token=' . $_GET['token'];
    $_SESSION['response'] = $clientService->addClient($_REQUEST);
    $_SESSION['response'] = $_SESSION['response'] . ' Nuoroda, kuria galite žiūrėti savo apsilankymą: ' . $link;
}else if(isset($_GET['name']) && $_GET['name'] == ""){
    $_SESSION['response'] = "Prašome užpildyti vardo laukelį";
}else{
    $_SESSION['response'] = "Įvyko klaida, kreipkitės telefonu.";
}

header('Location:index.php');