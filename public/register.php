<?php

include_once('../src/ClientService.php');
include_once('../resources/config.php');
include_once('../resources/dbconnection.php');

session_start();

$clientService = new ClientService($pdo);
if(isset($_GET['name'])){
    $_SESSION['response'] = $clientService->addClient($_GET['name']);
}else{
    $_SESSION['response'] = "Įvyko klaida, kreipkitės telefonu.";
}

header('Location:' . $_SERVER['DOCUMENT_ROOT']);