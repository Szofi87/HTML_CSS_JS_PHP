<?php

    define('HOST', 'localhost');
    define('USER', 'root');
    define('PWD', '');
    define('DBNAME', 'gameshop');

    $dbCon = mysqli_connect(HOST, USER, PWD, DBNAME);
    mysqli_query($dbCon, "SET NAMES utf8");

?>