<?php

//---------------------------------------------------------------------------------------------------//
// Naam script		: pgm_pdosql_dbcon2a_anfile1.php
// Omschrijving		: PDO connectie met OOP database connectie en sql buiten de klasse zonder construct
// Naam ontwikkelaar	:
// Project		:
// Datum		:
//---------------------------------------------------------------------------------------------------//
// Aanpassing	Datum	Project	 Pgmr	Omschrijving
//
//---------------------------------------------------------------------------------------------------//


// aanmaken klasse voor connectie
class MariaDB_dianafile1
{                // database server MariaDB bevindt zich op poort 3307
    public $db_server;                // database name an_db1 in MariaDB
    public $username;                // database username "root" is default
    public $password;                // database password *blanks is default


// automatisch functie aanmaken object (onderdrukt)
// function __construct($db_server,$username,$password)

// functie aanmaken object
    function set_server($db_server, $username, $password)
    {
        $this->db_server = $db_server;
        $this->username = $username;
        $this->password = $password;
    }

// functie aanmaken Connectie met database
// function get_server($db_server,$username,$password)
    function get_server()
    {
        $this->pdo_conn = new PDO($this->db_server, $this->username, $this->password);

        if ($this->pdo_conn) {
            echo "MariaDB/diana_db1 connected successfully" . "<br />";

        }
        return $this->pdo_conn;
    }

// Functie sluiten database verbinding (let wel, deze sluit ook automatisch als script wordt beeindigd)
    function set_conn_close()
    {
        $this->pdo_conn = null;
        echo "MariaDB/diana_db1 closed successfully" . "<br />";
    }

}

// require_once('MariaDB_dianafile1.php');	// indien class als extern bestand moet worden aangeroepen

// stap_001 aanmaken object op basis van klasse MariaDB_dianafile1 met benodigde variabelen
$db_dianafile1 = new MariaDB_dianafile1();    // maak object aan
$diana_file = "diana_file1";
$db_server = "mysql: host=localhost;dbname=diana_db1;port=3306";
$username = "root";
$password = "";

$db_dianafile1->set_server($db_server, $username, $password);

$db = $db_dianafile1->get_server();      // functie maak connectie

$sql = "SELECT * FROM $diana_file";
$row = $db->query($sql);
if (!$row) {
    echo "geen records geselecteerd" . "<br>";
} else {
    foreach ($db->query($sql) as $row) {
// while ($row = $db->query($sql) {

        echo ("{$row["naam"]} {$row["adres"]} {$row["woonplaats"]}\n") . "<br />";
    }
}
echo "tot deze regel gekomen" . "<br />";

$cl = $db_dianafile1->set_conn_close();




