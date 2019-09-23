<?php
include_once('SpecialistService.php');
include_once('Specialist.php');

class TimeService
{
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addTime($data)
    {
        $stmt = $this->pdo->prepare("SELECT * from specialists WHERE id = ?");
        $stmt->execute([$data['specialist_id']]);
        $specialist = new Specialist($this->pdo, $stmt->fetch(PDO::FETCH_ASSOC));

        $clientRegDate = strtotime($data['date']);
        $specTime = strtotime($specialist->getLastTime());

        // Amount of time it took specialist to service the client.
        $deltaInSecs = $clientRegDate - $specTime;
        // Only update times if delta is bigger than 0.
        if ($deltaInSecs >= 0) {
            //Create new entry in times table.
            $stmt = $this->pdo->prepare("INSERT INTO times (specialists_id, time) VALUES(:id, :time)");
            $stmt->execute(array(
                ':id' => $specialist->getId(),
                ':time' => $this->secsToTime($deltaInSecs)
            ));

            //Update the time of the last visit.
            $specialistService = new SpecialistService($this->pdo);
            $specialistService->updateLastTime($specialist, $data['date']);

            // Calculate and update average time of specialist.
            $avg = $this->average($specialist);
            $specialistService->updateAverageTime($specialist, $avg);
        }
    }

    // Average time it takes for specialist to service the client.
    public function average($specialist)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM times WHERE specialists_id = ?");
        $stmt->execute([$specialist->getId()]);
        $times = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sum = 0;
        foreach ($times as $time) {
            $sum += $this->timeToSecs($time['time']);
        }
        if (sizeof($times) > 0) {
            $avg = round($sum / sizeof($times));
        } else { // If specialist has not serviced any clients set his average to set value.
            $avg = 5 * 60;
        }

        return $this->secsToTime($avg);
    }
    // Returns time (H:m:s) as seconds
    function timeToSecs($time)
    {
        $time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time);
        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
        return $hours * 3600 + $minutes * 60 + $seconds;
    }
    // Returns seconds as time format (H:m:s)
    function secsToTime($secs)
    {
        $hours = floor($secs / 3600);
        $mins = floor($secs / 60 % 60);
        $secs = floor($secs % 60);
        return sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
    }
}
