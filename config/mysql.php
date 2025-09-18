<?php
  $username = 'root';
  $password = '12345';
  $host = 'localhost';
  $dbname = 'gestion_garage';

    try {
        $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>