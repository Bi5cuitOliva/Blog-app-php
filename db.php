<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dayblogger";

//create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ERROR CONNECTING TO DB". $conn->connect_error);
}