<?php
    $dsn = 'mysql:host=localhost;dbname=tech_support';
    $username = 'root';
    $password = '38wYTc8k@p8PNxR';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();
    }
?>