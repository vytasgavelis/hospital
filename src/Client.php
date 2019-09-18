<?php
class Client{
    protected $pdo;

    protected $id;
    protected $name;
    protected $specialist;
    protected $serviced = 0;
    protected $date;

    function __construct($pdo, $data){
        $this->pdo = $pdo;
        $this->id = $data['id'];
        $this->name = $data['client_name'];
        $this->specialist = $data['specialist'];
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
    public function getSpecialist(){
        return $this->specialist;
    }
    public function getDate(){
        return $this->date;
    }
    // Returns how much time was taken to service the client
    public function getTimeDt(){

    }


}