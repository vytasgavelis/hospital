<?php

session_start();
clearstatcache();

include("../resources/dbconnection.php");
include("../src/SpecialistService.php");


?>
<html>
<head>
</head>
<body>
  <form method="GET" action="register.php"> 
    <label for="name">Your name</label>
    <input type="text" name="name">
    <select name="specialist_id">
        <?php
        $specialistService = new SpecialistService($pdo);
        $specialists = $specialistService->getAllSpecialists();
        foreach($specialists as $specialist){
            echo "<option value='" . $specialist->getId() . "'>" . $specialist->getName() . "</option>";
        } 
        ?>
    </select>
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
