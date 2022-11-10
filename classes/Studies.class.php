<?php

class Studies {
    // Egenskaper
    public $id;
    public $school;
    public $name;
    public $type;
    public $startDate;
    public $endDate;

    // Sparar databasanslutningen för användning
    function __construct($db) {
        $this->db = $db;
    }
        
    // Metoder
    public function read() {
        // SQL-fråga för att läsa ut allt (*) från tabellen kurser
        $sql = "SELECT * FROM studies;";
        $result = mysqli_query($this->db, $sql);
            
        // Loopa genom alla rader
        while($row = mysqli_fetch_assoc($result)) {
            $arrResult[] = $row;
        }

        // Returnera resultatet
        return $arrResult;     
    }

    public function create() {
        // SQL-fråga för att skapa en kurs med specifika värden
        $sql = "INSERT INTO studies(school, name, type, startDate, endDate) VALUES('$this->school', '$this->name', '$this->type', '$this->startDate', '$this->endDate');";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }

    public function update($id) {
        // SQL-fråga för att uppdatera en specifik kurs
        $sql = "UPDATE studies SET school = '$this->school', name = '$this->name', type = '$this->type', startDate = '$this->startDate', endDate = '$this->endDate' WHERE id = $id";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }

    public function delete($id) {
        // SQL-fråga för att ta bort en specifik kurs
        $sql = "DELETE FROM studies WHERE id = '$id'";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }
}