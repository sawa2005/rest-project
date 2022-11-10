<?php

class Work {
    // Egenskaper
    public $id;
    public $job;
    public $title;
    public $startDate;
    public $endDate;

    // Sparar databasanslutningen för användning
    function __construct($db) {
        $this->db = $db;
    }
        
    // Metoder
    public function read() {
        // SQL-fråga för att läsa ut allt (*) från tabellen jobb
        $sql = "SELECT * FROM work;";
        $result = mysqli_query($this->db, $sql);
            
        // Loopa genom alla rader
        while($row = mysqli_fetch_assoc($result)) {
            $arrResult[] = $row;
        }

        // Returnera resultatet
        return $arrResult;     
    }

    public function create() {
        // SQL-fråga för att skapa ett jobb med specifika värden
        $sql = "INSERT INTO work(job, title, startDate, endDate) VALUES('$this->job', '$this->title', '$this->startDate', '$this->endDate');";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }

    public function update($id) {
        // SQL-fråga för att uppdatera ett specifik jobb
        $sql = "UPDATE work SET job = '$this->job', title = '$this->title', startDate = '$this->startDate', endDate = '$this->endDate' WHERE id = $id";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }

    public function delete($id) {
        // SQL-fråga för att ta bort ett specifik jobb
        $sql = "DELETE FROM work WHERE id = '$id'";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }
}