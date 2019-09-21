<?php
session_start();

include_once('../src/Token.php');
include_once('../src/ClientService.php');
include_once('../src/TimeService.php');
include_once('../resources/dbconnection.php');

if(isset($_POST['token'], $_POST['id']) && Token::check($_SESSION['token']) == 1){
    $clientService = new ClientService($pdo);
    $timeService = new TimeService($pdo);
        
    $clientService->serviceClient($_POST['id']);
    $timeService->addTime($_REQUEST);
}

header('location:manage.php');
    
?>