<?php
function connectToDatabase($hostname, $username, $password, $database)
{
    // Connect to MySQL server
    $conn = mysqli_connect($hostname, $username, $password);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Create the database if it doesn't already exist
    $query = "CREATE DATABASE IF NOT EXISTS `$database`";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error creating database: " . mysqli_error($conn));
    }

    // Connect to the database
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
