<?php

namespace NovApp;

class API
{
    const SERVERNAME = 'db';
    const USERNAME = 'appadmin';
    const PASSWORD = 'appadmin';
    const DBNAME = 'novaturasdb';

    public function __construct()
    {

    }

    public function getCountries() {
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }
        $sql = "SELECT *
        FROM `country` c
        ";
        $result = $conn->query($sql);
        $conn->close();

        return $result;
    }

    public function getAirports() {
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }
        $sql = "SELECT a.id id, a.name `name`, l.lat lat, l.lng lng, c.name country, c.ISO ISO 
        FROM `airport` a 
        JOIN `location` l ON a.id = l.id_airport 
        JOIN country c ON a.id_country = c.id
        ";
        $result = $conn->query($sql);
        $conn->close();

        return $result;
    }

    public function getAvialines() {
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }
        $sql = "SELECT a.id id, a.name `name`, c.name country, c.ISO ISO 
        FROM `avialine` a 
        JOIN country c ON a.id_country = c.id
        ";
        $result = $conn->query($sql);
        $conn->close();

        return $result;
    }

    public function addAirport($name, $id_country, $lat, $lng) {
        if(!$name || !$id_country || !$lat || !$lng) {
            return false;
        }
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sql = $conn->prepare("INSERT INTO airport (`name`, id_country) VALUES (?, ?)");
        $sql->bind_param("ss", $name, $id_country);
        $sql->execute();

        $last_id = $conn->insert_id;

        $sql = $conn->prepare("INSERT INTO `location` (id_airport, lat, lng) 
        VALUES ($last_id, ?, ?)
        ");
        $sql->bind_param("ss", $lat, $lng);
        $sql->execute();

        return true;
    }

    public function deleteAirport($id) {
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sql = $conn->prepare("DELETE FROM airport WHERE id = ?");
        $sql->bind_param("s", $id);
        $sql->execute();


        $sql = $conn->prepare("DELETE FROM `location` WHERE id_airport = ?");
        $sql->bind_param("s", $id);
        $sql->execute();

        return true;
    }

    public function addAvialine($name, $id_country) {
        if(!$name || !$id_country) {
            return false;
        }
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sql = $conn->prepare("INSERT INTO avialine (`name`, id_country) VALUES (?, ?)");
        $sql->bind_param("ss", $name, $id_country);
        $sql->execute();

        return true;
    }

    public function addAvialineToAirport($id_airport, $id_avialine) {
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sql = $conn->prepare("INSERT INTO airport_avialine (id_airport, id_avialine) VALUES (?, ?)");
        $sql->bind_param("ss", $id_airport, $id_avialine);
        $sql->execute();

        return true;
    }

    public function deleteAvialine($id) {
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sql = $conn->prepare("DELETE FROM avialine WHERE id = ?");
        $sql->bind_param("s", $id);
        $sql->execute();


        $sql = $conn->prepare("DELETE FROM airport_avialine WHERE id_avialine = ?");
        $sql->bind_param("s", $id);
        $sql->execute();

        return true;
    }

    public function updateAirport($id, $name, $id_country, $lat, $lng) {
        if(!$id) {
            return false;
        }

        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        if($name || $id_country) {

            $sqlstr = "UPDATE airport SET ";
            $sqlstr .= $name ? "`name`=?, " : "";
            $sqlstr .= $id_country ? "id_country=?, " : "";
            $sqlstr = substr($sqlstr, 0, -2);
            $sqlstr .= " WHERE id=?";
            $sql = $conn->prepare($sqlstr);
            if($name && $id_country) {
                $sql->bind_param("sss", $name, $id_country, $id);
            } 
            else {
                if($id_country) {
                    $sql->bind_param("ss", $id_country, $id);
                } 
                else {
                    $sql->bind_param("ss", $name, $id);
                }
            }
            $sql->execute();
        }

        if($lat || $lng) {

            $sqlstr = "UPDATE `location` SET ";
            $sqlstr .= $lat ? "lat=?, " : "";
            $sqlstr .= $lng ? "lng=?, " : "";
            $sqlstr = substr($sqlstr, 0, -2);
            $sqlstr .= " WHERE id_airport=?";
            $sql = $conn->prepare($sqlstr);
            if($lat && $lng) {
                $sql->bind_param("sss", $lat, $lng, $id);
            } 
            else {
                if($lng) {
                    $sql->bind_param("ss", $lng);
                } 
                else {
                    $sql->bind_param("ss", $lat);
                }
            }
            $sql->execute();
    }

        return true;
    }

    
    public function updateAvialine($id, $name, $id_country) {
        if(!$id) {
            return false;
        }

        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }


            $sqlstr = "UPDATE avialine SET ";
            $sqlstr .= $name ? "`name`=?, " : "";
            $sqlstr .= $id_country ? "id_country=?, " : "";
            $sqlstr = substr($sqlstr, 0, -2);
            $sqlstr .= " WHERE id=?";
            $sql = $conn->prepare($sqlstr);
            if($name && $id_country) {
                $sql->bind_param("sss", $name, $id_country, $id);
            } 
            else {
                if($id_country) {
                    $sql->bind_param("ss", $id_country, $id);
                } 
                else {
                    $sql->bind_param("ss", $name, $id);
                }
            }
            $sql->execute();
        

        return true;
    }

    public function getAirportAvialines($id) {
        if(!$id) {
            return false;
        }

        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sqlstr = "SELECT av.id, av.name `name`, c.name country
        FROM `airport_avialine` apav 
        JOIN `avialine` av ON av.id = apav.id_avialine 
        JOIN country c ON av.id_country = c.id 
        WHERE apav.id_airport = ?
        ";
        $sql = $conn->prepare($sqlstr);
        $sql->bind_param("s", $id);
        $sql->execute();
        $result = $sql->get_result();

        return $result;

    }

    public function deleteAirportAvialine($id_airport, $id_avialine) {
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sql = $conn->prepare("DELETE FROM airport_avialine WHERE id_airport = ? AND id_avialine = ?");
        $sql->bind_param("ss", $id_airport, $id_avialine);
        $sql->execute();

        return true;
    }

    public function addAirportAvialine($id_airport, $id_avialine) {
        if(!$id_airport || !$id_avialine) {
            return false;
        }
        $conn = new \mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($conn -> connect_errno) {
            return false;
        }

        $sql = $conn->prepare("INSERT INTO airport_avialine (id_airport, id_avialine) VALUES (?, ?)");
        $sql->bind_param("ss", $id_airport, $id_avialine);
        $sql->execute();

        return true;
    }



}
