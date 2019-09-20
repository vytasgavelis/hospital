<?php
include_once('../resources/dbconnection.php');

if(isset($_GET['token'])){
    $stmt = $pdo->prepare('DELETE FROM clients WHERE token = ?');
    $stmt->execute([$_GET['token']]);
}

header('Location:index.php');

?>