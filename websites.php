<?php

require 'config/Database.php';
require 'classes/Websites.class.php';

/*Headers med inställningar för din REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av code finns i urlen lagras det i en variabel
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Skapar en ny instans av databasklassen och kör funktionen för att ansluta till databasen
$database = new Database();
$db = $database->connect();

// Skapar instans av klassen för att skicka SQL-frågor till databasen
$websites = new Websites($db); // Databasanslutning skickas med som parameter

switch($method) {
    case 'GET':
        $response = $websites->read();

        // Kontrollerar om resultatet har några rader
        if ($response !== null) {
            // Skickar en "HTTP response status code"
            http_response_code(200); // OK - The request has succeeded
        }
        else {
            http_response_code(404); // Not found - The request has failed
            // Lagrar ett meddelande som sedan skickas tillbaka till anroparen
            $response = array("message" => "No website found");
        }
        break;
    case 'POST':
        // Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));

        // Skickar de medskickade egenskaperna till klassen och sparar dessa i klassens egenskaper
        $websites->title = $data->title;
        $websites->type = $data->type;
        $websites->link = $data->link;
        $websites->description = $data->description;
        $websites->image = $data->image;
        $websites->year = $data->year;

        // Kör funktionen för att skapa en ny webbsida
        if ($websites->create()) {
            http_response_code(201); // Created
            $response = array("message" => "Website created");
        }
        else {
            http_response_code(503); // Server error
            $response = array("message" => "Website not created");
        }
        break;
    case 'PUT':
        // Om ingen kod är medskickat, skicka felmeddelande
        if(!isset($id)) {
            http_response_code(400); // Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No id was sent");  
        }
        // Om en kod är skickad
        else {
            $data = json_decode(file_get_contents("php://input"));

            $websites->title = $data->title;
            $websites->type = $data->type;
            $websites->link = $data->link;
            $websites->description = $data->description;
            $websites->image = $data->image;
            $websites->year = $data->year;

            // Kör funktionen för att uppdatera en webbsida
            if ($websites->update($id)) {
                http_response_code(200);
                $response = array("message" => "Website with id = $id is updated");
            }
            else {
                http_response_code(503);
                $response = array("message" => "Website not updated");
            }
        }
        break;
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id was sent");  
        } 
        else {
            // Kör funktionen för att ta bort en webbsida
            if ($websites->delete($id)) {
                http_response_code(200);
                $response = array("message" => "Website with id = $id has been deleted");
            }
            else {
                http_response_code(503);
                $response = array("message" => "Website not deleted");
            }
        }
        break;        
}

// Skickar svar tillbaka till avsändaren
echo json_encode($response);
