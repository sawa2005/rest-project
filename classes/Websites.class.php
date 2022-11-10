<?php

class Websites {
    // Egenskaper
    public $id;
    public $title;
    public $type;
    public $link;
    public $description;
    public $image;
    public $year;

    // Sparar databasanslutningen för användning
    function __construct($db) {
        $this->db = $db;
    }
        
    // Metoder
    public function read() {
        // SQL-fråga för att läsa ut allt (*) från tabellen webbsidor
        $sql = "SELECT * FROM websites;";
        $result = mysqli_query($this->db, $sql);
            
        // Loopa genom alla rader
        while($row = mysqli_fetch_assoc($result)) {
            $arrResult[] = $row;
        }

        // Returnera resultatet
        return $arrResult;     
    }

    public function create() {
        // SQL-fråga för att skapa en webbsida med specifika värden
        $sql = "INSERT INTO websites(title, type, link, description, image, year) VALUES('$this->title', '$this->type', '$this->link', '$this->description', '$this->image', '$this->year');";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }

    public function update($id) {
        // SQL-fråga för att uppdatera en specifik webbsida
        $sql = "UPDATE websites SET title = '$this->title', type = '$this->type', link = '$this->link', description = '$this->description', image = '$this->image', year = '$this->year' WHERE id = $id";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }

    public function delete($id) {
        // SQL-fråga för att ta bort en specifik webbsida
        $sql = "DELETE FROM websites WHERE id = '$id'";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }
}