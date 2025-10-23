<?php
require_once("DiplomskiRadovi.php");

$conn = new mysqli("localhost", "root", "", "radovi");
if ($conn->connect_error) {
    die("Greška u spajanju na bazu: " . $conn->connect_error);
}

$dr = new DiplomskiRadovi();
$dr->create();  
$dr->save($conn); 
$dr->read($conn); 

$conn->close();
?>
