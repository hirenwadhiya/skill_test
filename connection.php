<?php
function connect()
{
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "test";

    $connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}

function disconnect($connection)
{
    $connection->close();
}