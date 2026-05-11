<?php

$db_host = 'mysql-db';
$db_port = '3306';
$db_name= 'e_commerce';
$db_user = 'monje';
$db_pass = 'monje';

$conn = null;
try {
    $conn = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
