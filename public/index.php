<?php

session_start();

include("../resources/dbconnection.php");

?>
<html>
<head>
</head>
<body>
  <form method="GET" action="register.php"> 
    <label for="name">Your name</label>
    <input type="text" name="name">
    <button type="submit">Register</button>  
  </form>
  <?php
    if(isset($_SESSION['response'])){
        echo $_SESSION['response'];
        unset($_SESSION['response']);
    }
  ?>
</body>
</html>
