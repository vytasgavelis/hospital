<?php
include_once('config.php');

date_default_timezone_set('Europe/Vilnius');

$server = $config['db']['server'];
$dbname = $config['db']['dbname'];
$username = $config['db']['username'];
$password = $config['db']['password'];

$dsn = 'mysql:host=' . $server . ';dbname=' . $dbname;
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
    date                DATETIME              NOT NULL,
    token               VARCHAR (255)         NOT NULL
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

