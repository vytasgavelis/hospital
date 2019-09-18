<?php
include('config.php');

$server = $config['db']['server'];
$dbname = $config['db']['dbname'];
$username = $config['db']['username'];
$password = $config['db']['password'];

$dsn = 'mysql:host=' . $server . ';dbname=' . $dbname;

//$dsn = 'mysql:host=' . 'eu-cdbr-west-02.cleardb.net' . ';dbname=heroku_799bada3d1cdc24';

$pdo = new PDO($dsn, $username, $password);

$specialistsTblQuery = "CREATE TABLE IF NOT EXISTS specialists(
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    name                VARCHAR (255)           NOT NULL,
    avg_time            TIME                    NOT NULL,
    last_time           DATETIME                NOT NULL
  )";

$clientsTblQuery = "CREATE TABLE IF NOT EXISTS clients(
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    clients_name         VARCHAR (255)         NOT NULL,
    specialists_id 		INT,
    FOREIGN KEY (specialists_id)  REFERENCES specialists(id),
    serviced            BOOLEAN               NOT NULL DEFAULT 0,
    date                DATETIME              NOT NULL
    )";

$timesTblQuery = "CREATE TABLE IF NOT EXISTS times(
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    specialists_id 		INT,
    FOREIGN KEY (specialists_id)  REFERENCES specialists(id),
    time                TIME              NOT NULL
    )";


$stmt = $pdo->prepare($specialistsTblQuery);
$stmt->execute();

$stmt = $pdo->prepare($clientsTblQuery);
$stmt->execute();

$stmt = $pdo->prepare($timesTblQuery);
$stmt->execute();

?>
