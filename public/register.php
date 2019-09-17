<?php

include_once('../src/ClientService.php');
include_once('../resources/config.php');
include_once('../resources/dbconnection.php');

session_start();

$clientService = new ClientService($pdo);
if(isset($_GET['name']) && $_GET['name'] != ""){
    $_SESSION['response'] = $clientService->addClient($_GET['name']);
}else if(isset($_GET['name']) && $_GET['name'] == ""){
    $_SESSION['response'] = "Prašome užpildyti vardo laukelį";
}else{
    $_SESSION['response'] = "Įvyko klaida, kreipkitės telefonu.";
}

header('Location:index.php');