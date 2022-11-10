<?php
class Database {
    // Databasinställningar
    private $host = 'slw.one.mysql';
    private $db_name = 'slw_one_main';
    private $username = 'slw_one_main';
    private $password = 'SaDatabaseMuel6354!?';
    private $conn;

    // Anslut till databasen
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name) or die('Fel vid anslutning');
        }
        // Om något fel uppstår
        catch(PDOException $e) {
            echo "Connection Error " . $e->getMessage();
        }
        
        return $this->conn;
    }

    // Stäng databasanslutning
    public function close() {
        $this->conn = null;
    }
}