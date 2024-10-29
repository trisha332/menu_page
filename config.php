<?php
session_start();
$server="localhost";
$dbuser="root";
$dbpass="";
$dbname="php37";
$port="3306";
try{
    $con=mysqli_connect($server,$dbuser,$dbpass,$dbname,$port);
}
catch (Exception $e) {
    echo$e->getMessage();
}

?>