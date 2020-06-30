<?php 

$hots = 'localhost';
$username = 'root';
$password = '';
$dbname = 'airproperties';

$conn= new mysqli($hots,$username, $password, $dbname);
    if ($conn->connect_error){
        die($conn->connect_error);
    }
