<?php
session_start();

include_once('../resources/dbconnection.php');
include_once('../src/SpecialistService.php');

if(isset($_GET['id'])){
    $_SESSION['id'] = $_GET['id'];
    $times = array();

    for($i = 0; $i < 24; $i++){
        if($i < 10){
            $hour = '0' . $i;
            $dateL = $hour . ':00:00';
            $dateH = $hour . ':59:59';
        }else{
            $hour = $i;
            $dateL = $hour . ':00:00';
            $dateH = $hour . ':59:59';
        }
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE TIME(date) between :dateL AND :dateH AND specialists_id = :id");
        $stmt->execute(array(
            ':dateL' => $dateL,
            ':dateH' => $dateH,
            ':id' => $_GET['id']
        ));
        
        $data = array( 
            "time" => $hour,
            "count" => sizeof($stmt->fetchAll(PDO::FETCH_ASSOC))
        );
        array_push($times, $data);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" type="text/css" href="css/board.css">
</head>

<script>

// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Time', 'Count'],
  <?php
    foreach($times as $time){
        echo "['" . $time['time'] . "', " . $time['count'] . "], ";
    }
  ?>
]);

var options = {
    'width':600,
    'height':450,
    'backgroundColor': '#1ab188'
};

var chart = new google.visualization.PieChart(document.getElementById('piechart'));
chart.draw(data, options);
}

</script>
<body>
<?php include_once("navbar.html"); ?>

    <div class="row">
        <div class="column side"></div>

        <div class="column middle">
            <div class="form">
                <form>
                    <select name="id">
                        <?php
                            // Fill the select options with specialists.
                            $specialistService = new SpecialistService($pdo);
                            $specialists = $specialistService->getAllSpecialists();
                            foreach($specialists as $specialist) {
                                if(isset($_SESSION['id']) && $specialist->getId() == $_SESSION['id']){
                                    echo "<option selected='selected' value='" . $specialist->getId() . "'>" . $specialist->getName() . "</option>";
                                    unset($_SESSION['id']);
                                }else{
                                    echo "<option value='" . $specialist->getId() . "'>" . $specialist->getName() . "</option>";
                                }
                                echo $specialist->getId() . " " . $_SESSION['id'];
                            }
                        ?>
                    </select>
                    <button type="submit">Rodyti</button>
                </form>
            </div>
            <div>
                <?php 
                if(isset($_GET['id'])){
                    echo "Labiausiai užimti specialisto laikai:";
                }
                else{
                    echo "Pasirinkite specialistą ir spauskite rodyti, kad matyti jo laikus.";
                }
                ?>
            </div>
            <div id="piechart" align='center'></div>
        </div>

        <div class="column side"></div>
    </div>
</body>
</html>
