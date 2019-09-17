<?php
include("../resources/dbconnection.php");

session_start();

?>
<html>
<head>
</head>
<body>
  <form method="POST" action="register.php"> 
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
