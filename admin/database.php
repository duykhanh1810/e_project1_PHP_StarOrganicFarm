<?php
//This file contain database connection
define('HOST', 'localhost');
define('USER', 'root');
define('PWD', '');
define('DB', 'starorganic');

function connect() {
    $conn = new mysqli(HOST, USER, PWD, DB);
    if($conn->connect_error) {
        return null;
    } else {
        return $conn;
    }
}

?>