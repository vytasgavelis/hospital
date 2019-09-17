<?php

include_once('../src/ClientService.php');
include_once('../resources/config.php');
include_once('../resources/dbconnection.php');

session_start();

$clientService = new ClientService($pdo);
if(isset($_POST['name'])){
    $_SESSION['response'] = $clientService->addClient($_POST['name']);
}else{
    $_SESSION['response'] = "Įvyko klaida, kreipkitės telefonu.";
}

header('location:' . $_SERVER['DOCUMENT_ROOT']);