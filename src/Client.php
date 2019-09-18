<?php
class Client{
    protected $pdo;

    protected $id;
    protected $name;
    protected $specialistId;
    protected $serviced = 0;
    protected $date;

    function __construct($pdo, $data){
        $this->pdo = $pdo;
        $this->id = $data['id'];
        $this->name = $data['clients_name'];
        $this->specialistId = $data['specialists_id'];
        $this->serviced = $data['serviced'];
        $this->date = $data['date'];      
    }
    public function isServiced(){
        return $this->serviced == 1;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getSpecialistId(){
        return $this->specialistId;
    }
    public function getDate(){
        return $this->date;
    }
    // Returns how much time was taken to service the client
    public function getTimeDt(){

    }


}