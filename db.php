<?php
    $host = 'localhost';
    $dbname = 'crud';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
    }catch(PDOException $e){
        print 'Database connection failed: <br>' . $e->getMessage();
        die();
    }
    require_once 'function.php';
?>