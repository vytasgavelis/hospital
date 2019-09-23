<?php
class Specialist
{
    protected $pdo;

    protected $id;
    protected $name;
    protected $avgTime;
    protected $lastTime;

    function __construct($pdo, $data)
    {
        $this->pdo = $pdo;
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->avgTime = $data['avg_time'];
        $this->lastTime = $data['last_time'];
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getAvgTime()
    {
        return $this->avgTime;
    }
    public function getLastTime()
    {
        return $this->lastTime;
    }
}
