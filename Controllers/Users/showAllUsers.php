<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $query = "SELECT * FROM `blogApi`.`users`";
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($result) {
        header("Content-Type: application/json");
        return response($users, 200);
    } else {
        header("Content-Type: application/json");
        return response("error in storing user", 405);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
