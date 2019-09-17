<?php
include('config.php');

$server = $config['db']['server'];
$dbname = $config['db']['dbname'];
$username = $config['db']['username'];
$password = $config['db']['password'];

$dsn = 'mysql:host=' . $server . ';dbname=' . $dbname;

//$dsn = 'mysql:host=' . 'eu-cdbr-west-02.cleardb.net' . ';dbname=heroku_799bada3d1cdc24';

$pdo = new PDO($dsn, $username, $password);

$sql = "CREATE TABLE IF NOT EXISTS clients(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    client_name   VARCHAR (255)         NOT NULL,
    date          DATETIME              NOT NULL
  )";
$stmt = $pdo->prepare($sql);
$stmt->execute();
?>
