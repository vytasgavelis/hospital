<?php

session_start();
clearstatcache();

include_once("../resources/dbconnection.php");
include_once("../src/SpecialistService.php");
include_once("../src/Token.php");
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/singleContainer.css">
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="inner">
                <form method="GET" action="register.php">
                    <div class="input">
                        <label for="name">Your name</label>
                        <br>
                        <input type="text" name="name">
                    </div>
                    <input type="hidden" name="token" value="<?php echo Token::generateNoSession(); ?>">
                    <div class="input">
                        <select name="specialist_id">
                            <?php
                            $specialistService = new SpecialistService($pdo);
                            $specialists = $specialistService->getAllSpecialists();
                            foreach ($specialists as $specialist) {
                                echo "<option value='" . $specialist->getId() . "'>" . $specialist->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit">Register</button>
                </form>
                <?php
                if (isset($_SESSION['response'])) {
                    echo "<div class='feedback'>" . $_SESSION['response'] . "</div>";
                    unset($_SESSION['response']);
                }
                if (isset($_SESSION['link'])) {
                    echo "<div class='feedback'>" . $_SESSION['link'] . "</div>";
                    unset($_SESSION['link']);
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>