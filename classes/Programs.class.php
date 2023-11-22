<?php

class Programs {
    // Egenskaper
    public $id;
    public $school;
    public $name;
    public $startDate;
    public $endDate;

    // Sparar databasanslutningen för användning
    function __construct($db) {
        $this->db = $db;
    }
        
    // Metoder
    public function read() {
        // SQL-fråga för att läsa ut allt (*) från tabellen kurser
        $sql = "SELECT * FROM programs;";
        $result = mysqli_query($this->db, $sql);
            
        // Loopa genom alla rader
        while($row = mysqli_fetch_assoc($result)) {
            $arrResult[] = $row;
        }

        // Returnera resultatet
        return $arrResult;     
    }

    public function create() {
        // Kollar om en sträng innehåller PHP eller HTML-kod
        function isHTML($string) {
            return $string != strip_tags($string) ? true:false;
        }

        // Kollar att alla fält är ifyllda
        if ($this->school && $this->name && $this->startDate && $this->endDate) {
            // Ser till att ingen kod injiceras
            if (!isHTML($this->school) && !isHTML($this->name) && !isHTML($this->startDate) && !isHTML($this->endDate)) {
                // SQL-fråga för att skapa en kurs med specifika värden
                $sql = "INSERT INTO programs(school, name, startDate, endDate) VALUES('$this->school', '$this->name', '$this->startDate', '$this->endDate');";
                $result = mysqli_query($this->db, $sql);
        
                return $result;
            }
        }
    }

    public function update($id) {
        function isHTML($string) {
            return $string != strip_tags($string) ? true:false;
        }

        if ($this->school && $this->name && $this->startDate && $this->endDate) {
            if (!isHTML($this->school) && !isHTML($this->name) && !isHTML($this->startDate) && !isHTML($this->endDate)) {
                // SQL-fråga för att uppdatera en specifik kurs
                $sql = "UPDATE programs SET school = '$this->school', name = '$this->name', startDate = '$this->startDate', endDate = '$this->endDate' WHERE id = $id";
                $result = mysqli_query($this->db, $sql);

                return $result;
            }
        }
    }

    public function delete($id) {
        // SQL-fråga för att ta bort en specifik kurs
        $sql = "DELETE FROM studies WHERE id = '$id'";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }
}