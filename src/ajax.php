<?php

header('Content-Type: application/json');
require("../vendor/autoload.php");

use NovApp\API;

$api = new API();

if($_POST['action'] == 'get_markers') {
    $airports = $api->getAirports();
    $markers = [];
    while($airport = mysqli_fetch_array($airports)) {
        $markers[] = [
            'name' => $airport['name'],
            'lat' => $airport['lat'],
            'lng' => $airport['lng'],
            'id' => $airport['id']
        ];
    }

    echo json_encode($markers);
    exit;
}

if($_POST['action'] == 'remove_airport') {

    $id = $_POST['id'];
    $result = $api->deleteAirport($id);
    echo json_encode($result ? "$id airport removed" : "$id airport not removed");
    exit;
}

if($_POST['action'] == 'remove_avialine') {

    $id = $_POST['id'];
    $result = $api->deleteAvialine($id);
    echo json_encode($result ? "$id avialine removed" : "$id avialine not removed");
    exit;
}

if($_POST['action'] == 'update_airport') {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $country_id = $_POST['country_id'];
    $result = $api->updateAirport($id, $name, $country_id, $lat, $lng);
    
    echo json_encode($result ? "$id airport updated" : "$id airport not updated");
    exit;
}

if($_POST['action'] == 'update_avialine') {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $country_id = $_POST['country_id'];
    $result = $api->updateAvialine($id, $name, $country_id);
    
    echo json_encode($result ? "$id avialine updated" : "$id avialine not updated");
    exit;
}

if($_POST['action'] == 'add_airport') {

    $name = $_POST['name'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $country_id = $_POST['country_id'];
    $result = $api->addAirport($name, $country_id, $lat, $lng);
    
    echo json_encode($result ? "$id airport added" : "$id airport not added");
    exit;
}

if($_POST['action'] == 'add_avialine') {

    $name = $_POST['name'];
    $country_id = $_POST['country_id'];
    $result = $api->addAvialine($name, $country_id);
    
    echo json_encode($result ? "$id avialine added" : "$id avialine not added");
    exit;
}

if($_POST['action'] == 'get_airport_avialines') {

    $id = $_POST['id'];
    $airportAvialines = $api->getAirportAvialines($id);

    $result = array();

    while($airportAvialine = mysqli_fetch_array($airportAvialines)) {
        $result[] = [
            'id' => $airportAvialine['id'],
            'name' => $airportAvialine['name'],
            'country' => $airportAvialine['country']
        ];
    }
    
    echo json_encode($result);
    exit;
}

if($_POST['action'] == 'remove_airport_avialine') {

    $id_airport = $_POST['id_airport'];
    $id_avialine = $_POST['id_avialine'];

    $result = $api->deleteAirportAvialine($id_airport, $id_avialine);

    echo json_encode($result ? "removed" : "not removed");
    exit;
}

if($_POST['action'] == 'add_airport_avialine') {

    $id_airport = $_POST['id_airport'];
    $id_avialine = $_POST['id_avialine'];

    $result = $api->addAirportAvialine($id_airport, $id_avialine);
    
    echo json_encode($result ? "added" : "not added");
    exit;
}

echo 'false';
exit;