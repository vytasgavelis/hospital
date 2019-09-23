<?php
session_start();

include_once('src/ClientService.php');
include_once('resources/config.php');
include_once('resources/dbconnection.php');
include_once('src/Token.php');

$clientService = new ClientService($pdo);

if (isset($_GET['name']) && !ctype_alpha($_GET['name'])) {
    $_SESSION['response'] = "Vardo formatas ne toks.";
    $_SESSION['name'] = $_GET['name'];
} else if (isset($_GET['name'], $_GET['specialist_id'])) {
    $stmt = $pdo->prepare("SHOW TABLE STATUS LIKE 'clients'");
    $stmt->execute();
    $id = $stmt->fetch(PDO::FETCH_ASSOC)['Auto_increment'];
    $link = 'appointment.php?token=' . $_GET['token'] . "&id=" . $id;
    $_SESSION['response'] = $clientService->addClient($_REQUEST);
    $_SESSION['link'] = $link;
} else {
    $_SESSION['response'] = "Įvyko klaida, kreipkitės telefonu.";
}
if (isset($_GET['name'], $_GET['specialist_id'])) {
    $_SESSION['name'] = $_GET['name'];
    $_SESSION['id'] = $_GET['specialist_id'];
}
header('Location:index.php');
