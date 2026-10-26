<?php

$host = "localhost";
$dbname = "spotify_tp";
$user = "root";
$password = "";

$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,
    $password
);



?>